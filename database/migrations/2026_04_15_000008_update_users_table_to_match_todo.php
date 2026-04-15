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
        Schema::table('users', function (Blueprint $table) {
            // Drop the old role column if it exists
            if (Schema::hasColumn('users', 'role')) {
                $table->dropColumn('role');
            }
        });

        Schema::table('users', function (Blueprint $table) {
            // Add foreign keys and attributes according to Todo
            $table->foreignId('jenis_pengguna_id')->nullable()->constrained('jenis_pengguna', 'role_id')->after('password');
            $table->foreignId('agensi_id')->nullable()->constrained('agensi')->after('jenis_pengguna_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeignKeyIfExists(['jenis_pengguna_id']);
            $table->dropForeignKeyIfExists(['agensi_id']);
            $table->dropColumn(['jenis_pengguna_id', 'agensi_id']);
        });

        Schema::table('users', function (Blueprint $table) {
            $table->string('role')->default('entiti')->after('password');
        });
    }
};
