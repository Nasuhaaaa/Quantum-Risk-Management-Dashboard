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
            if (!Schema::hasColumn('risk_register', 'status_kelulusan')) {
                $table->string('status_kelulusan')->nullable()->after('pelan_mitigasi');
            }

            if (!Schema::hasColumn('risk_register', 'diluluskan_oleh')) {
                $table->string('diluluskan_oleh')->nullable()->after('status_kelulusan');
            }

            if (!Schema::hasColumn('risk_register', 'diluluskan_pada')) {
                $table->timestamp('diluluskan_pada')->nullable()->after('diluluskan_oleh');
            }

            if (!Schema::hasColumn('risk_register', 'catatan')) {
                $table->text('catatan')->nullable()->after('diluluskan_pada');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('risk_register', function (Blueprint $table) {
            if (Schema::hasColumn('risk_register', 'catatan')) {
                $table->dropColumn('catatan');
            }

            if (Schema::hasColumn('risk_register', 'diluluskan_pada')) {
                $table->dropColumn('diluluskan_pada');
            }

            if (Schema::hasColumn('risk_register', 'diluluskan_oleh')) {
                $table->dropColumn('diluluskan_oleh');
            }

            if (Schema::hasColumn('risk_register', 'status_kelulusan')) {
                $table->dropColumn('status_kelulusan');
            }
        });
    }
};
