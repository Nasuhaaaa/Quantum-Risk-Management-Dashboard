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
        Schema::table('inventori', function (Blueprint $table) {
            if (!Schema::hasColumn('inventori', 'agensi_id')) {
                $table->foreignId('agensi_id')->after('id')->constrained('agensi')->onDelete('cascade');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('inventori', function (Blueprint $table) {
            $table->dropForeignKeyIfExists('inventori_agensi_id_foreign');
            $table->dropColumn('agensi_id');
        });
    }
};
