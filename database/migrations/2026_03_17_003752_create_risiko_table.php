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
        Schema::create('risiko', function (Blueprint $table) {
            $table->id();
            $table->string('nama_risiko', 100);
            $table->foreignId('sub_kategori_risiko_id')->constrained('sub_kategori_risiko');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('risiko');
    }
};
