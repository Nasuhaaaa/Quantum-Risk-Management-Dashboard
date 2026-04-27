<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('risk_register', function (Blueprint $table) {
            // Add the missing foreign key columns
            if (!Schema::hasColumn('risk_register', 'impak_id')) {
                $table->unsignedBigInteger('impak_id')->nullable()->after('punca_risiko_id');
            }

            if (!Schema::hasColumn('risk_register', 'kebarangkalian_id')) {
                $table->unsignedBigInteger('kebarangkalian_id')->nullable()->after('impak_id');
            }

            if (!Schema::hasColumn('risk_register', 'tahap_risiko_id')) {
                $table->unsignedBigInteger('tahap_risiko_id')->nullable()->after('kebarangkalian_id');
            }
        });

        // Populate the foreign key columns from existing data
        // Map impak values (1-5) to impak table
        DB::statement("
            UPDATE risk_register rr
            SET impak_id = (
                SELECT impak_id FROM impak WHERE skala = rr.impak LIMIT 1
            )
            WHERE impak IS NOT NULL AND impak_id IS NULL
        ");

        // Map kemungkinan values (1-5) to kebarangkalian table
        DB::statement("
            UPDATE risk_register rr
            SET kebarangkalian_id = (
                SELECT kebarangkalian_id FROM kebarangkalian WHERE skala = rr.kemungkinan LIMIT 1
            )
            WHERE kemungkinan IS NOT NULL AND kebarangkalian_id IS NULL
        ");

        // Map tahap_risiko string values to tahap_risiko table
        DB::statement("
            UPDATE risk_register rr
            SET tahap_risiko_id = (
                SELECT tahap_risiko_id FROM tahap_risiko WHERE tahap_risiko = rr.tahap_risiko LIMIT 1
            )
            WHERE tahap_risiko IS NOT NULL AND tahap_risiko_id IS NULL
        ");

        // Add foreign key constraints
        Schema::table('risk_register', function (Blueprint $table) {
            // Check if constraints already exist before adding
            try {
                $table->foreign('impak_id')->references('impak_id')->on('impak')->onDelete('cascade');
            } catch (\Exception $e) {
                // Constraint already exists
            }

            try {
                $table->foreign('kebarangkalian_id')->references('kebarangkalian_id')->on('kebarangkalian')->onDelete('cascade');
            } catch (\Exception $e) {
                // Constraint already exists
            }

            try {
                $table->foreign('tahap_risiko_id')->references('tahap_risiko_id')->on('tahap_risiko')->onDelete('cascade');
            } catch (\Exception $e) {
                // Constraint already exists
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('risk_register', function (Blueprint $table) {
            try {
                $table->dropForeign(['impak_id']);
            } catch (\Exception $e) {
                // Constraint doesn't exist
            }

            try {
                $table->dropForeign(['kebarangkalian_id']);
            } catch (\Exception $e) {
                // Constraint doesn't exist
            }

            try {
                $table->dropForeign(['tahap_risiko_id']);
            } catch (\Exception $e) {
                // Constraint doesn't exist
            }

            // Drop the foreign key columns
            if (Schema::hasColumn('risk_register', 'impak_id')) {
                $table->dropColumn('impak_id');
            }

            if (Schema::hasColumn('risk_register', 'kebarangkalian_id')) {
                $table->dropColumn('kebarangkalian_id');
            }

            if (Schema::hasColumn('risk_register', 'tahap_risiko_id')) {
                $table->dropColumn('tahap_risiko_id');
            }
        });
    }
};
