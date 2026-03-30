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
        Schema::create('risk_register', function (Blueprint $table) {
            $table->id();
            $table->string('cbom_id');
            $table->foreignId('risiko_id')->constrained('risiko');
            $table->string('pemilik_risiko');
            $table->foreignId('punca_risiko_id')->constrained('punca_risiko'); //constrained table name
            $table->unsignedTinyInteger('impak');
            $table->unsignedTinyInteger('kemungkinan');
            $table->unsignedTinyInteger('skor_risiko');
            $table->string('tahap_risiko');
            $table->string('kawalan_sedia_ada');
            $table->string('pelan_mitigasi');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('risk_register');
    }
};
