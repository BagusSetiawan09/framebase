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
        Schema::create('clients', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Nama klien atau PIC
            $table->string('company_name')->nullable(); // Nama perusahaan/brand (opsional)
            $table->string('email')->unique()->nullable(); // Email klien
            $table->string('phone'); // Nomor WhatsApp/HP
            $table->text('address')->nullable(); // Alamat domisili/perusahaan
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('clients');
    }
};
