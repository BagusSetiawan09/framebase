<?php

namespace Database\Seeders;

use App\Models\Booking;
use App\Models\Equipment;
use Illuminate\Database\Seeder;

class EquipmentSeeder extends Seeder
{
    public function run(): void
    {
        // Mendaftarkan kamera utama resolusi tinggi untuk produksi
        $eq1 = Equipment::create([
            'name' => 'Sony A7S Mark III',
            'category' => 'Camera',
            'serial_number' => 'SNY882910',
            'condition' => 'excellent',
            'status' => 'available',
            'notes' => 'Kondisi sensor sangat bersih dan siap pakai',
        ]);

        // Mendaftarkan lensa bukaan besar untuk kebutuhan low light
        $eq2 = Equipment::create([
            'name' => 'Sony FE 24 70mm f 2.8 G Master',
            'category' => 'Lens',
            'serial_number' => 'LNS773829',
            'condition' => 'excellent',
            'status' => 'available',
        ]);

        // Mendaftarkan pesawat tanpa awak untuk dokumentasi udara
        $eq3 = Equipment::create([
            'name' => 'DJI Mavic 3 Pro Cine',
            'category' => 'Drone',
            'serial_number' => 'DJI992837',
            'condition' => 'good',
            'status' => 'available',
            'notes' => 'Baling baling cadangan ada di dalam tas',
        ]);

        // Mendaftarkan pencahayaan studio untuk foto produk komersial
        $eq4 = Equipment::create([
            'name' => 'Godox AD600 Pro',
            'category' => 'Lighting',
            'serial_number' => 'GDX112233',
            'condition' => 'fair',
            'status' => 'maintenance',
            'notes' => 'Baterai drop dan sedang dikirim ke pusat servis',
        ]);

        // Mengambil seluruh data pesanan yang sudah ada di database
        $bookings = Booking::all();

        // Meminjamkan alat secara otomatis ke dalam setiap proyek pesanan
        foreach ($bookings as $booking) {
            
            // Proyek komersial produk biasanya butuh kamera dan lampu
            if ($booking->service && str_contains($booking->service->name, 'Commercial')) {
                $booking->equipment()->attach([$eq1->id, $eq2->id]);
            } 
            // Proyek pernikahan atau acara besar biasanya butuh tambahan drone udara
            else {
                $booking->equipment()->attach([$eq1->id, $eq2->id, $eq3->id]);
            }
        }
    }
}