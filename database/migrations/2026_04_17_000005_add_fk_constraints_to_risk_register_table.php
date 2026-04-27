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
        Schema::table('risk_register', function (Blueprint $table) {
            // Drop existing string/integer columns
            // $table->dropColumn(['impak', 'kemungkinan', 'tahap_risiko']);
            // comment sebab error, dia dah delete column tu, so tak boleh drop lagi

            // // Add foreign key columns with custom primary keys
            // $table->unsignedBigInteger('impak_id')->after('punca_risiko_id');
            // $table->unsignedBigInteger('kebarangkalian_id')->after('impak_id');
            // $table->unsignedBigInteger('tahap_risiko_id')->after('kebarangkalian_id');

            // Add foreign key constraints
            $table->foreign('impak_id')->references('impak_id')->on('impak')->onDelete('cascade');
            $table->foreign('kebarangkalian_id')->references('kebarangkalian_id')->on('kebarangkalian')->onDelete('cascade');
            $table->foreign('tahap_risiko_id')->references('tahap_risiko_id')->on('tahap_risiko')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('risk_register', function (Blueprint $table) {
            // Drop foreign keys
            $table->dropForeign(['impak_id']);
            $table->dropForeign(['kebarangkalian_id']);
            $table->dropForeign(['tahap_risiko_id']);

            // Drop foreign key columns
            $table->dropColumn(['impak_id', 'kebarangkalian_id', 'tahap_risiko_id']);

            // Restore original columns
            $table->unsignedTinyInteger('impak')->after('punca_risiko_id');
            $table->unsignedTinyInteger('kemungkinan')->after('impak');
            $table->string('tahap_risiko')->after('kemungkinan');
        });
    }
};
