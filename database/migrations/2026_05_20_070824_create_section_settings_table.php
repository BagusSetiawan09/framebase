<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('section_settings', function (Blueprint $table) {
            $table->id();
            
            // Seksi Layanan
            $table->string('services_title')->default('Layanan & Paket');
            $table->text('services_subtitle')->nullable();
            
            // Seksi Portofolio
            $table->string('portfolio_title_white')->default('Karya terbaik');
            $table->string('portfolio_title_gray')->default('visual kami');
            $table->text('portfolio_subtitle')->nullable();
            
            // Seksi Testimonial
            $table->string('testimonial_title')->default('Apa kata mereka tentang karya visual kami.');
            
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('section_settings');
    }
};