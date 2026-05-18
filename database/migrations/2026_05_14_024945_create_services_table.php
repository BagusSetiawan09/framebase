<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
{
    Schema::create('services', function (Blueprint $table) {
        $table->id();
        $table->string('name'); // Nama Paket (ex: Wedding Platinum)
        $table->string('slug')->unique(); // URL friendly name
        $table->text('description')->nullable(); // Deskripsi detail
        $table->integer('price'); // Harga paket
        $table->json('deliverables')->nullable(); // Apa saja yang didapat (ex: 100 Foto, 1 Video)
        $table->string('thumbnail')->nullable(); // Gambar cover paket
        $table->boolean('is_active')->default(true); // Status paket aktif/tidak
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('services');
    }
};
