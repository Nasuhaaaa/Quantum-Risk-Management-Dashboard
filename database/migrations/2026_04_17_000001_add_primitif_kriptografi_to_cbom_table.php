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
        Schema::table('cbom', function (Blueprint $table) {
            $table->string('primitif_kriptografi')->nullable()->after('sbom_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('cbom', function (Blueprint $table) {
            $table->dropColumn('primitif_kriptografi');
        });
    }
};
