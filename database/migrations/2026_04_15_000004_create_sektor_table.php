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
        if (Schema::hasTable('sektor')) {
            return;
        }

        Schema::create('sektor', function (Blueprint $table) {
            $table->id();
            $table->string('nama_sektor', 150);
            $table->text('keterangan_sektor')->nullable();
            $table->string('ketua_sektor', 150)->nullable();
            $table->text('maklumat_perhubungan_sektor')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
