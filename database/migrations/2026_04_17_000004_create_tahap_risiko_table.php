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
        Schema::create('tahap_risiko', function (Blueprint $table) {
            $table->id('tahap_risiko_id');
            $table->integer('skor_min');
            $table->integer('skor_max');
            $table->string('tahap_risiko');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tahap_risiko');
    }
};
