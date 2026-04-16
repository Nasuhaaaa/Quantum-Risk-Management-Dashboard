<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Normalize legacy users schemas into the canonical app schema:
     * id, username, password, remember_token, jenis_pengguna_id, agensi_id.
     */
    public function up(): void
    {
        if (!Schema::hasTable('users')) {
            Schema::create('users', function (Blueprint $table) {
                $table->id();
                $table->string('username')->unique();
                $table->string('password');
                $table->rememberToken();
                $table->foreignId('jenis_pengguna_id')->nullable();
                $table->foreignId('agensi_id')->nullable();
                $table->timestamps();
            });

            return;
        }

        $columns = Schema::getColumnListing('users');
        $canonicalColumns = ['id', 'username', 'password', 'remember_token', 'jenis_pengguna_id', 'agensi_id', 'created_at', 'updated_at'];
        $hasCanonicalSchema = count(array_diff($canonicalColumns, $columns)) === 0;

        if ($hasCanonicalSchema) {
            $this->ensureUserForeignKeys();
            return;
        }

        Schema::dropIfExists('users_normalized');

        Schema::create('users_normalized', function (Blueprint $table) {
            $table->id();
            $table->string('username')->unique();
            $table->string('password');
            $table->rememberToken();
            $table->foreignId('jenis_pengguna_id')->nullable();
            $table->foreignId('agensi_id')->nullable();
            $table->timestamps();
        });

        $rows = DB::table('users')->get();

        foreach ($rows as $row) {
            $row = (array) $row;

            $id = $row['id'] ?? $row['User_ID'] ?? null;
            $username = $row['username'] ?? null;
            $password = $row['password'] ?? $row['Kata_Laluan'] ?? bcrypt('password');
            $rememberToken = $row['remember_token'] ?? null;
            $jenisPenggunaId = $row['jenis_pengguna_id'] ?? $row['Jenis_Pengguna'] ?? null;
            $agensiId = $row['agensi_id'] ?? $row['id_agensi'] ?? null;
            $createdAt = $row['created_at'] ?? now();
            $updatedAt = $row['updated_at'] ?? now();

            if (!$username) {
                $suffix = $id ?? (DB::table('users_normalized')->count() + 1);
                $username = 'user.' . $suffix;
            }

            DB::table('users_normalized')->insert([
                'id' => $id,
                'username' => $username,
                'password' => $password,
                'remember_token' => $rememberToken,
                'jenis_pengguna_id' => $jenisPenggunaId,
                'agensi_id' => $agensiId,
                'created_at' => $createdAt,
                'updated_at' => $updatedAt,
            ]);
        }

        Schema::drop('users');
        Schema::rename('users_normalized', 'users');

        $this->ensureUserForeignKeys();
    }

    public function down(): void
    {
        //
    }

    private function ensureUserForeignKeys(): void
    {
        // Existing environments may already have these foreign keys with the
        // canonical names, so we keep this migration focused on shape/data
        // normalization instead of enforcing constraints again.
    }
};
