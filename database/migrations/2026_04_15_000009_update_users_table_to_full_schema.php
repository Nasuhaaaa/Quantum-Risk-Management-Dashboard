<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Update users table to match Todo specification
     * Pengguna table should have: User_ID, Kata_Laluan, Jenis_Pengguna, ID_Agensi
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Drop foreign key first if exists
            try {
                $table->dropForeign(['remember_token']);
            } catch (\Exception $e) {
                // ignore if doesn't exist
            }

            // Drop columns that shouldn't exist
            try {
                $table->dropColumn(['name', 'email', 'email_verified_at', 'remember_token']);
            } catch (\Exception $e) {
                // If any columns don't exist, try individually
                foreach (['name', 'email', 'email_verified_at', 'remember_token'] as $col) {
                    try {
                        if (Schema::hasColumn('users', $col)) {
                            $table->dropColumn($col);
                        }
                    } catch (\Exception $ex) {
                        // column already gone, continue
                    }
                }
            }
        });

        // Add new columns in separate block
        Schema::table('users', function (Blueprint $table) {
            // Add Jenis_Pengguna foreign key if not exists
            if (!Schema::hasColumn('users', 'jenis_pengguna_id')) {
                $table->unsignedBigInteger('jenis_pengguna_id')->nullable()->after('password');
            }

            // Add ID_Agensi foreign key if not exists
            if (!Schema::hasColumn('users', 'id_agensi')) {
                $table->unsignedBigInteger('id_agensi')->nullable()->after('jenis_pengguna_id');
            }
        });

        // Add foreign key constraints in separate block
        Schema::table('users', function (Blueprint $table) {
            if (Schema::hasTable('jenis_pengguna') && Schema::hasColumn('users', 'jenis_pengguna_id')) {
                try {
                    $table->foreign('jenis_pengguna_id')
                        ->references('role_id')
                        ->on('jenis_pengguna')
                        ->onDelete('set null');
                } catch (\Exception $e) {
                    // Foreign key might already exist
                }
            }

            if (Schema::hasTable('agensi') && Schema::hasColumn('users', 'id_agensi')) {
                try {
                    $table->foreign('id_agensi')
                        ->references('id')
                        ->on('agensi')
                        ->onDelete('set null');
                } catch (\Exception $e) {
                    // Foreign key might already exist
                }
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
            if (Schema::hasColumn('users', 'jenis_pengguna_id')) {
                try {
                    $table->dropForeign(['jenis_pengguna_id']);
                } catch (\Exception $e) {
                    // Foreign key might not exist
                }
            }

            if (Schema::hasColumn('users', 'id_agensi')) {
                try {
                    $table->dropForeign(['id_agensi']);
                } catch (\Exception $e) {
                    // Foreign key might not exist
                }
            }

            // Drop new columns
            $columnsToDrop = [];
            if (Schema::hasColumn('users', 'jenis_pengguna_id')) {
                $columnsToDrop[] = 'jenis_pengguna_id';
            }
            if (Schema::hasColumn('users', 'id_agensi')) {
                $columnsToDrop[] = 'id_agensi';
            }

            if (!empty($columnsToDrop)) {
                $table->dropColumn($columnsToDrop);
            }

            // Restore original columns
            if (!Schema::hasColumn('users', 'email')) {
                $table->string('email')->unique()->after('id');
            }
            if (!Schema::hasColumn('users', 'name')) {
                $table->string('name')->after('id');
            }
            if (!Schema::hasColumn('users', 'email_verified_at')) {
                $table->timestamp('email_verified_at')->nullable()->after('email');
            }
            if (!Schema::hasColumn('users', 'remember_token')) {
                $table->rememberToken()->nullable()->after('password');
            }
        });
    }
};

