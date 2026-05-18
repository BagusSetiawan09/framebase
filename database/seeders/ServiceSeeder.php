<?php

namespace Database\Seeders;

use App\Models\Service;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ServiceSeeder extends Seeder
{
    /**
        * Run the database seeds.
        */
    public function run(): void
    {
        $services = [
            [
                'name' => 'Wedding Royal Platinum (Photo, Video & Drone)',
                'slug' => Str::slug('Wedding Royal Platinum'),
                'description' => 'Paket dokumentasi pernikahan terlengkap. Menangani acara dari pagi hingga resepsi malam dengan kualitas setara film layar lebar.',
                'price' => 25000000,
                'deliverables' => [
                    '3 Fotografer Senior',
                    '2 Videografer Cinematic',
                    '1 Pilot Drone (Aerial Coverage)',
                    '1 Video Teaser 1 Menit (Same Day Edit)',
                    '1 Video Dokumenter 15 Menit',
                    '2 Cetak Album Eksklusif 20x30 (Magnetic Box)',
                    'Softcopy Ultra HD di Flashdisk Custom'
                ],
                'is_active' => true,
            ],
            [
                'name' => 'Pre-Wedding Cinematic Story',
                'slug' => Str::slug('Pre-Wedding Cinematic Story'),
                'description' => 'Sesi pemotretan dan video sebelum hari pernikahan dengan konsep bercerita (storytelling). Bisa dilakukan di dalam studio maupun luar ruangan.',
                'price' => 8500000,
                'deliverables' => [
                    '1 Hari Full Sesi Pemotretan',
                    'Video Cinematic 3 Menit',
                    '50 Foto Retouched',
                    '1 Cetak Kanvas 40x60 dengan Bingkai Minimalis',
                    'Wardrobe & Make Up Artist (MUA) Standar'
                ],
                'is_active' => true,
            ],
            [
                'name' => 'Commercial Product Photography',
                'slug' => Str::slug('Commercial Product Photography'),
                'description' => 'Layanan foto produk resolusi Ultra HD untuk kebutuhan komersial, e-commerce, dan aset visual brand. Sangat ideal untuk menonjolkan tekstur dan detail produk, mulai dari visualisasi estetis produk F&B seperti kemasan biji kopi, hingga ketajaman material produk teknis seperti sparepart.',
                'price' => 3500000,
                'deliverables' => [
                    '30 Foto High-End Retouched',
                    'Resolusi Ultra HD (Siap Cetak Billboard)',
                    'Konsep Moodboard & Styling',
                    'Penggunaan Lighting Studio Profesional',
                    'Revisi Editing Maksimal 2x'
                ],
                'is_active' => true,
            ],
            [
                'name' => 'Corporate Event & Conference Coverage',
                'slug' => Str::slug('Corporate Event & Conference Coverage'),
                'description' => 'Dokumentasi acara perusahaan, seminar, gathering, atau peluncuran produk dengan standar profesional yang cepat dan tidak mengganggu jalannya acara.',
                'price' => 7000000,
                'deliverables' => [
                    '1 Fotografer & 1 Videografer',
                    'Liputan Maksimal 8 Jam',
                    'Highlight Video 3 Menit (Cocok untuk LinkedIn/Instagram)',
                    'Semua Foto Di-edit Standar (Color Correction)',
                    'Link Google Drive Maksimal H+2 Acara'
                ],
                'is_active' => true,
            ],
            [
                'name' => 'Brand Story & Company Profile Video',
                'slug' => Str::slug('Brand Story & Company Profile Video'),
                'description' => 'Produksi video profil perusahaan yang menceritakan visi, misi, dan alur kerja perusahaan dari hulu ke hilir untuk meyakinkan calon klien atau investor.',
                'price' => 18000000,
                'deliverables' => [
                    'Konsep & Skrip Video',
                    'Sutradara & DOP',
                    'Video Resolusi 4K (Durasi 3-5 Menit)',
                    'Sewa Alat Film Grade',
                    'Voice Over (Bahasa Indonesia/Inggris)',
                    'Lisensi Musik Komersial'
                ],
                'is_active' => true,
            ],
            [
                'name' => 'Graduation & Portrait Session',
                'slug' => Str::slug('Graduation & Portrait Session'),
                'description' => 'Sesi foto personal untuk wisuda, foto keluarga, atau professional headshot untuk kebutuhan profil profesional.',
                'price' => 1500000,
                'deliverables' => [
                    'Sesi Studio 2 Jam',
                    '1 Fotografer',
                    '20 Foto Edit Pilihan',
                    '2 Cetak Ukuran 10R'
                ],
                'is_active' => true,
            ],
        ];

        foreach ($services as $service) {
            Service::create($service);
        }
    }
}