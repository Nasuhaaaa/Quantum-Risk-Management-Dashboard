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
        Schema::table('punca_risiko', function (Blueprint $table) {
            //
            $table->string('pelan_mitigasi')->nullable()->after('kategori_punca_risiko_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('punca_risiko', function (Blueprint $table) {
            $table->dropColumn('pelan_mitigasi');
            //
        });
    }
};
