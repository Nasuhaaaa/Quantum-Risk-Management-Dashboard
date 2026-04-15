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
        // Drop existing users table if it exists
        Schema::dropIfExists('users');

        // Create new users table with exact specification
        Schema::create('users', function (Blueprint $table) {
            $table->id('User_ID'); // Primary Key, auto increment
            $table->string('Kata_Laluan'); // Password
            $table->unsignedBigInteger('Jenis_Pengguna')->nullable(); // FK to jenis_pengguna
            $table->unsignedBigInteger('ID_Agensi')->nullable(); // FK to agensi
            $table->timestamps(); // created_at, updated_at

            // Add foreign key constraints
            $table->foreign('Jenis_Pengguna')
                ->references('role_id')
                ->on('jenis_pengguna')
                ->onDelete('set null');

            $table->foreign('ID_Agensi')
                ->references('id')
                ->on('agensi')
                ->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
