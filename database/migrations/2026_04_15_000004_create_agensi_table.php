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
        Schema::create('agensi', function (Blueprint $table) {
            $table->id();
            $table->string('nama_agensi', 150);
            $table->string('no_tel_agensi', 50)->nullable();
            $table->string('website')->nullable();
            $table->string('nama_pic', 150)->nullable();
            $table->string('no_tel_pic', 50)->nullable();
            $table->string('emel_pic')->nullable();
            $table->foreignId('sektor_id')->nullable()->constrained('sektor');
            $table->string('jenis_perniagaan_perhubungan')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('agensi');
    }
};
