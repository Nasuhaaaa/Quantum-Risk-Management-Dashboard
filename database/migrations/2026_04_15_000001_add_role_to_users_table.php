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
        // Legacy migration kept for compatibility. The canonical schema
        // stores user roles via jenis_pengguna_id instead of a role string.
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
