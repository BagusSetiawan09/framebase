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
        Schema::create('testimonials', function (Blueprint $table) {
            $table->id();
            $table->enum('type', ['company', 'personal'])->default('personal'); // Tipe Klien
            $table->string('company_name')->nullable(); // Nama Perusahaan (Khusus Company)
            $table->text('quote'); // Isi Testimoni
            $table->string('client_name'); // Nama Klien
            $table->string('role'); // Jabatan (Company) / Nama Layanan (Personal)
            $table->string('avatar')->nullable(); // Foto Klien
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('testimonials');
    }
};
