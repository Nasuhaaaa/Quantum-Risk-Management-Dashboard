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
        Schema::create('sub_kategori_risiko', function (Blueprint $table) {
            $table->id();
            $table->string('sub_kategori_risiko', 100);
            $table->foreignId('kategori_risiko_id')->constrained('kategori_risiko');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sub_kategori_risiko');
    }
};
