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
        if (Schema::hasTable('sbom')) {
            return;
        }

        Schema::create('sbom', function (Blueprint $table) {
            $table->id();
            $table->foreignId('inventori_id')->constrained('inventori');
            $table->string('komponen_versi')->nullable();
            $table->text('sub_komponen')->nullable();
            $table->string('url')->nullable();
            $table->string('mod_perkhidmatan')->nullable();
            $table->string('language_framework')->nullable();
            $table->text('modules_libraries')->nullable();
            $table->string('external_apis_services')->nullable();
            $table->string('in_house_vendor')->nullable();
            $table->string('nama_vendor')->nullable();
            $table->string('kepakaran_kriptografi')->nullable();
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
