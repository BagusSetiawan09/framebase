<?php

namespace Database\Seeders;

use App\Models\Booking;
use App\Models\Client;
use App\Models\Service;
use Illuminate\Database\Seeder;

class BookingSeeder extends Seeder
{
    public function run(): void
    {
        // Membuat data pelanggan baru terlebih dahulu
        $client1 = Client::create([
            'name' => 'Zevan Admin',
            'company_name' => 'Zevan Sparepart',
            'email' => 'info@zevansparepart.com',
            'phone' => '081234567890',
            'address' => 'Kawasan Industri Medan',
        ]);

        $client2 = Client::create([
            'name' => 'Haji Aroma',
            'company_name' => 'Gunung Aroma Coffee',
            'email' => 'hello@gunungaroma.com',
            'phone' => '089876543210',
            'address' => 'Jalan Kebun Kopi Nomor 45',
        ]);

        // Mengambil id paket layanan yang sudah kita seed sebelumnya
        $serviceCommercial = Service::where('slug', 'commercial-product-photography')->first();
        $serviceCorporate = Service::where('slug', 'corporate-event-conference-coverage')->first();

        // Membuat data transaksi pemesanan yang menghubungkan klien dan layanan
        if ($serviceCommercial) {
            Booking::create([
                'client_id' => $client1->id,
                'service_id' => $serviceCommercial->id,
                'booking_date' => '2026-06-01',
                'location' => 'Studio Foto Zevan Gudang A',
                'status' => 'confirmed',
                'payment_status' => 'partial',
                'notes' => 'Sesi foto fokus pada detail ketajaman material produk',
            ]);
        }

        if ($serviceCorporate) {
            Booking::create([
                'client_id' => $client2->id,
                'service_id' => $serviceCorporate->id,
                'booking_date' => '2026-06-15',
                'location' => 'Aula Pertemuan Utama Gunung Aroma',
                'status' => 'pending',
                'payment_status' => 'unpaid',
                'notes' => 'Liputan pameran varietas biji kopi baru',
            ]);
        }
    }
}