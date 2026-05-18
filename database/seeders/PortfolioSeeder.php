<?php

namespace Database\Seeders;

use App\Models\Client;
use App\Models\Portfolio;
use App\Models\Service;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class PortfolioSeeder extends Seeder
{
    public function run(): void
    {
        // Mengambil data kategori layanan yang sudah ada di database
        $serviceCommercial = Service::where('slug', 'commercial-product-photography')->first();
        $serviceWedding = Service::where('slug', 'wedding-royal-platinum-photo-video-drone')->first();
        $serviceCorporate = Service::where('slug', 'corporate-event-conference-coverage')->first();

        // Mengambil data klien yang relevan dengan proyek
        $clientZevan = Client::where('company_name', 'Zevan Sparepart')->first();
        $clientAroma = Client::where('company_name', 'Gunung Aroma Coffee')->first();

        // Menyusun daftar data portofolio tiruan untuk kebutuhan etalase visual
        $portfolios = [
            [
                'title' => 'Zevan Premium Component Series',
                'description' => 'Produksi aset visual komersial yang berfokus pada detail ketajaman material dan presisi komponen suku cadang. Pencahayaan studio diatur secara khusus untuk menonjolkan tekstur logam profesional',
                'service_id' => $serviceCommercial ? $serviceCommercial->id : 1,
                'client_id' => $clientZevan ? $clientZevan->id : null,
                'images' => [
                    'portfolios/sample-product-1.jpg',
                    'portfolios/sample-product-2.jpg',
                    'portfolios/sample-product-3.jpg',
                ],
                'video_url' => 'https://www.youtube.com/watch?v=dQw4w9WgXcQ',
            ],
            [
                'title' => 'Gunung Aroma Aesthetic Package Shot',
                'description' => 'Sesi pemotretan produk kreatif untuk kemasan biji kopi Gunung Aroma. Menggunakan konsep visual organik dengan elemen pendukung alami seperti properti kain rami dan sebaran biji kopi asli',
                'service_id' => $serviceCommercial ? $serviceCommercial->id : 1,
                'client_id' => $clientAroma ? $clientAroma->id : null,
                'images' => [
                    'portfolios/sample-coffee-1.jpg',
                    'portfolios/sample-coffee-2.jpg',
                ],
                'video_url' => null,
            ],
            [
                'title' => 'The Royal Wedding of Adrian & Alyssa',
                'description' => 'Dokumentasi lengkap pernikahan megah bernuansa tradisional dan modern. Seluruh momen sakral diabadikan dengan teknik sinematik beresolusi tinggi dari udara dan darat',
                'service_id' => $serviceWedding ? $serviceWedding->id : 1,
                'client_id' => null, // Proyek internal contoh portofolio
                'images' => [
                    'portfolios/sample-wedding-1.jpg',
                    'portfolios/sample-wedding-2.jpg',
                    'portfolios/sample-wedding-3.jpg',
                    'portfolios/sample-wedding-4.jpg',
                ],
                'video_url' => 'https://vimeo.com/12345678',
            ],
            [
                'title' => 'Annual National Coffee Conference 2026',
                'description' => 'Liputan dokumentasi berskala besar untuk acara pameran dan konferensi tahunan. Fokus utama pada interaksi pembicara utama, antusiasme peserta, serta atmosfer eksklusif ruang pameran',
                'service_id' => $serviceCorporate ? $serviceCorporate->id : 1,
                'client_id' => $clientAroma ? $clientAroma->id : null,
                'images' => [
                    'portfolios/sample-event-1.jpg',
                    'portfolios/sample-event-2.jpg',
                ],
                'video_url' => null,
            ],
        ];

        // Memasukkan setiap data portofolio ke dalam database menggunakan perulangan
        foreach ($portfolios as $portfolio) {
            Portfolio::create([
                'title' => $portfolio['title'],
                'slug' => Str::slug($portfolio['title']),
                'description' => $portfolio['description'],
                'service_id' => $portfolio['service_id'],
                'client_id' => $portfolio['client_id'],
                'images' => $portfolio['images'],
                'video_url' => $portfolio['video_url'],
            ]);
        }
    }
}