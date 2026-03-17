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
        Schema::create('punca_risiko', function (Blueprint $table) {
            $table->id();
            $table->string('punca_risiko', 100);
            $table->foreignId('kategori_punca_risiko_id')->constrained('kategori_punca_risiko');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('punca_risiko');
    }
};
