<?php

namespace Database\Seeders;

use App\Models\Booking;
use App\Models\Invoice;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class InvoiceSeeder extends Seeder
{
    public function run(): void
    {
        // Mengambil seluruh data pemesanan yang ada di database
        $bookings = Booking::all();

        // Menghentikan proses jika belum ada data pemesanan sama sekali
        if ($bookings->isEmpty()) {
            return;
        }

        // Membuat tagihan untuk setiap pesanan yang ditemukan
        foreach ($bookings as $index => $booking) {
            
            // Menghitung tiga puluh persen dari harga paket untuk uang muka
            $dpAmount = $booking->service ? $booking->service->price * 0.3 : 1500000;
            
            Invoice::create([
                'booking_id' => $booking->id,
                'invoice_number' => 'INV' . strtoupper(Str::random(6)),
                'amount' => $dpAmount,
                'due_date' => now()->addDays(3),
                'status' => 'paid',
                'notes' => 'Pembayaran Uang Muka Tiga Puluh Persen',
            ]);

            // Membuat tagihan pelunasan secara acak untuk beberapa pesanan
            if ($index % 2 === 0) {
                
                // Menghitung sisa tujuh puluh persen dari harga paket
                $remainingAmount = $booking->service ? $booking->service->price * 0.7 : 3500000;
                
                Invoice::create([
                    'booking_id' => $booking->id,
                    'invoice_number' => 'INV' . strtoupper(Str::random(6)),
                    'amount' => $remainingAmount,
                    'due_date' => now()->addDays(14),
                    'status' => 'unpaid',
                    'notes' => 'Tagihan Pelunasan Sisa Pembayaran Pengerjaan',
                ]);
            }
        }
    }
}