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
            // Drop columns that exist
            $columnsToDrop = [];
            if (Schema::hasColumn('users', 'name')) {
                $columnsToDrop[] = 'name';
            }
            if (Schema::hasColumn('users', 'email')) {
                $columnsToDrop[] = 'email';
            }
            if (Schema::hasColumn('users', 'email_verified_at')) {
                $columnsToDrop[] = 'email_verified_at';
            }
            if (Schema::hasColumn('users', 'remember_token')) {
                $columnsToDrop[] = 'remember_token';
            }

            if (!empty($columnsToDrop)) {
                $table->dropColumn($columnsToDrop);
            }
        });

        Schema::table('users', function (Blueprint $table) {
            // Add new required columns
            if (!Schema::hasColumn('users', 'jenis_pengguna_id')) {
                $table->unsignedBigInteger('jenis_pengguna_id')->nullable()->after('password');
            }

            if (!Schema::hasColumn('users', 'id_agensi')) {
                $table->unsignedBigInteger('id_agensi')->nullable()->after('jenis_pengguna_id');
            }
        });

        Schema::table('users', function (Blueprint $table) {
            // Add foreign keys
            try {
                $table->foreign('jenis_pengguna_id', 'users_jenis_pengguna_id_foreign')
                    ->references('role_id')
                    ->on('jenis_pengguna')
                    ->onDelete('set null');
            } catch (\Exception $e) {
                // FK might exist
            }

            try {
                $table->foreign('id_agensi', 'users_id_agensi_foreign')
                    ->references('id')
                    ->on('agensi')
                    ->onDelete('set null');
            } catch (\Exception $e) {
                // FK might exist
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Drop foreign keys
            $table->dropForeignIdIfExists('jenis_pengguna_id');
            $table->dropForeignIdIfExists('id_agensi');
        });

        Schema::table('users', function (Blueprint $table) {
            // Drop custom columns
            $table->dropColumnIfExists(['jenis_pengguna_id', 'id_agensi']);
        });

        Schema::table('users', function (Blueprint $table) {
            // Re-add standard Laravel columns (if you want to reverse completely)
            // Commented out because you probably won't rollback
            // $table->string('name');
            // $table->string('email')->unique();
            // $table->timestamp('email_verified_at')->nullable();
            // $table->string('remember_token')->nullable();
        });
    }
};
