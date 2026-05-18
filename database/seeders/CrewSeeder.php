<?php

namespace Database\Seeders;

use App\Models\Booking;
use App\Models\Crew;
use Illuminate\Database\Seeder;

class CrewSeeder extends Seeder
{
    public function run(): void
    {
        // Membuat barisan tim profesional untuk agensi FrameBase
        $crew1 = Crew::create([
            'name' => 'Bima Sena',
            'role' => 'Lead Photographer',
            'phone' => '081122223333',
            'email' => 'bima@framebase.system',
            'is_active' => true,
        ]);

        $crew2 = Crew::create([
            'name' => 'Raditya Visuals',
            'role' => 'Videographer Cinematic',
            'phone' => '082233334444',
            'email' => 'radit@framebase.system',
            'is_active' => true,
        ]);

        $crew3 = Crew::create([
            'name' => 'Aero Sky',
            'role' => 'Drone Pilot',
            'phone' => '083344445555',
            'email' => 'aero@framebase.system',
            'is_active' => true,
        ]);

        $crew4 = Crew::create([
            'name' => 'Nina Retouch',
            'role' => 'Editor Visual',
            'phone' => '084455556666',
            'email' => 'nina@framebase.system',
            'is_active' => true,
        ]);

        // Mengambil semua data pemesanan yang ada di sistem
        $bookings = Booking::all();

        // Menyuntikkan kru ke dalam setiap pemesanan secara dinamis
        foreach ($bookings as $booking) {
            // Memasukkan fotografer utama ke semua proyek
            $booking->crews()->attach($crew1->id);

            // Memasukkan videografer dan pilot drone khusus untuk pesanan yang nilainya tinggi atau kompleks
            if ($booking->service && $booking->service->price > 5000000) {
                $booking->crews()->attach([$crew2->id, $crew3->id]);
            }
        }
    }
}