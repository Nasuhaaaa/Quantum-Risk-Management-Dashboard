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
            // Drop the old string column
            $table->dropColumn('cbom_id');
        });

        Schema::table('risk_register', function (Blueprint $table) {
            // Add cbom_id as a foreign key
            $table->foreignId('cbom_id')->after('id')->constrained('cbom');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('risk_register', function (Blueprint $table) {
            $table->dropForeignKeyIfExists(['cbom_id']);
            $table->dropColumn('cbom_id');
        });

        Schema::table('risk_register', function (Blueprint $table) {
            $table->string('cbom_id')->after('id');
        });
    }
};
