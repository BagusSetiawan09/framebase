<?php

use Illuminate\Support\Facades\Route;
use App\Models\Hero;
use App\Models\Service;
use App\Models\Portfolio;
use App\Models\Testimonial;
use App\Models\Footer;
use App\Models\SectionSetting;
use App\Models\Client;
use App\Models\Booking;
use Illuminate\Http\Request;

// ROUTE: HALAMAN UTAMA (LANDING PAGE)
Route::get('/', function () {
    $hero = Hero::first();
    $services = Service::all(); 
    $portfolios = Portfolio::with('service')->latest()->get(); 
    $testimonials = Testimonial::latest()->get();
    $footer = Footer::first();
    $sectionSetting = SectionSetting::first();
    
    return view('welcome', compact('hero', 'services', 'portfolios', 'testimonials', 'footer', 'sectionSetting'));
});


// ROUTE: HALAMAN ORDER
Route::get('/order', function () {
    // Tarik data service untuk dropdown form
    $services = Service::all();
    return view('order', compact('services'));
})->name('order.page');


// ROUTE: PROSES SUBMIT ORDER
Route::post('/order/submit', function (Request $request) {
    // 1. Validasi Input Klien
    $data = $request->validate([
        'name' => 'required|string|max:255',
        'company_name' => 'nullable|string|max:255',
        'email' => 'required|email',
        'phone' => 'required|string',
        'service_id' => 'required|exists:services,id',
        'scale' => 'required|string',
        'description' => 'required|string',
        'event_date' => 'required|date',
        'location' => 'required|string',
        'budget_range' => 'required|string',
        'reference_url' => 'nullable|url',
    ]);

    // 2. Cek apakah klien sudah ada berdasarkan email, jika tidak buat baru
    $client = Client::firstOrCreate(
        ['email' => $data['email']], 
        [
            'name' => $data['name'],
            'company_name' => $data['company_name'],
            'phone' => $data['phone'],
            'address' => 'Diisi otomatis dari form pemesanan web',
        ]
    );

    // 3. Meracik Detail Ekstra (Skala, Budget, URL) ke dalam satu kolom 'notes'
    $formattedNotes = "SKALA PROYEK: " . strtoupper($data['scale']) . "\n";
    $formattedNotes .= "ESTIMASI BUDGET: " . $data['budget_range'] . "\n";
    $formattedNotes .= "LINK REFERENSI: " . ($data['reference_url'] ?? 'Tidak ada referensi') . "\n";
    $formattedNotes .= "----------------------------------------\n";
    $formattedNotes .= "DESKRIPSI KEBUTUHAN:\n" . $data['description'];

    // 4. Masukkan ke tabel Booking (Pemesanan Jasa)
    Booking::create([
        'client_id' => $client->id,
        'service_id' => $data['service_id'],
        'booking_date' => $data['event_date'],
        'location' => $data['location'],
        'status' => 'pending', // Default
        'payment_status' => 'unpaid', // Default
        'notes' => $formattedNotes,
    ]);

    // 5. Kembalikan ke halaman form dengan pesan sukses
    return back()->with('success', 'Luar biasa! Brief Anda telah kami terima. Tim Frame Base akan menganalisis kebutuhan Anda dan segera menghubungi melalui WhatsApp.');
})->name('order.submit');