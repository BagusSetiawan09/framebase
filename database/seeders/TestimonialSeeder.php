<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Testimonial;

class TestimonialSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Data diurutkan secara taktis agar formasi Bento Grid langsung mengunci rapi
        $testimonials = [
            [
                'type' => 'company',
                'company_name' => 'ZEVAN SPAREPART',
                'quote' => 'Hasil foto produk sangat tajam dan presisi. Tone warna konsisten sesuai dengan brand guideline kami. Sangat membantu menaikkan konversi penjualan di e-commerce.',
                'client_name' => 'Bagus Setiawan',
                'role' => 'Founder, Zevan Sparepart',
                'avatar' => null, // Di-set null agar otomatis menggunakan UI-Avatars estetik di frontend
            ],
            [
                'type' => 'personal',
                'company_name' => null,
                'quote' => 'Sangat puas dengan hasilnya! Tim fotografer sangat ramah dan bisa mengarahkan gaya sehingga kami tidak kaku saat pre-wedding.',
                'client_name' => 'Amanda & Reza',
                'role' => 'Pre-Wedding Cinematic',
                'avatar' => null,
            ],
            [
                'type' => 'personal',
                'company_name' => null,
                'quote' => 'Momen akad nikah kami terabadikan dengan sangat indah dan emosional. Video teasernya bahkan sudah jadi di hari yang sama!',
                'client_name' => 'Sinta Ayu',
                'role' => 'Wedding Royal Platinum',
                'avatar' => null,
            ],
            [
                'type' => 'company',
                'company_name' => 'TECH SUMMIT ID',
                'quote' => 'Tim dokumentasi paling profesional yang pernah kami sewa. Bisa mengcover event 3 hari penuh dengan hasil video highlight yang memukau para sponsor.',
                'client_name' => 'Diana Putri',
                'role' => 'Event Director',
                'avatar' => null,
            ],
            [
                'type' => 'personal',
                'company_name' => null,
                'quote' => 'Kualitas cetak album eksklusifnya luar biasa mewah. Terima kasih sudah mengabadikan momen wisuda saya dengan sempurna.',
                'client_name' => 'Kevin Sanjaya',
                'role' => 'Graduation Portrait',
                'avatar' => null,
            ],
            [
                'type' => 'personal',
                'company_name' => null,
                'quote' => 'Pencahayaan untuk sesi foto keluarga kami sangat pas, tone warnanya hangat. Sangat direkomendasikan!',
                'client_name' => 'Keluarga Bapak Rudi',
                'role' => 'Family Portrait',
                'avatar' => null,
            ],
        ];

        foreach ($testimonials as $testi) {
            Testimonial::create($testi);
        }
    }
}