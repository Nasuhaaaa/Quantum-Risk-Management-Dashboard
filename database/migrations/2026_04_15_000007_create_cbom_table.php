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
        Schema::create('cbom', function (Blueprint $table) {
            $table->id();
            $table->foreignId('sbom_id')->constrained('sbom');
            $table->string('algoritma_kriptografi')->nullable();
            $table->string('panjang_kunci')->nullable();
            $table->text('tujuan_penggunaan')->nullable();
            $table->text('library_modules')->nullable();
            $table->string('kategori_data')->nullable();
            $table->string('sokongan_crypto_agility')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cbom');
    }
};
