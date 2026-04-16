<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * Creates users table according to Todo.txt specifications:
     * - User_ID (PK)
     * - Kata_Laluan (password)
     * - Jenis_Pengguna (FK to jenis_pengguna.role_id)
     * - ID_Agensi (FK to agensi.id)
     */
    public function up(): void
    {
        // Legacy migration retained for compatibility.
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
