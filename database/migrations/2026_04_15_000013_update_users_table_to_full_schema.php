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
