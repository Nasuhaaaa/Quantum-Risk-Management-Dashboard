<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class JenisPenggunaSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('jenis_pengguna')->insert([
            [
                'jenis_pengguna' => 'Entiti (Agensi)',
                'keterangan' => 'Agensi yang mendaftar dan menguruskan risiko',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'jenis_pengguna' => 'Ketua Sektor',
                'keterangan' => 'Ketua sektor yang mengurus entiti dalam bidang',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'jenis_pengguna' => 'Pengurusan',
                'keterangan' => 'Pihak pengurusan untuk semakan dan sahkan risiko',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'jenis_pengguna' => 'Sistem Admin',
                'keterangan' => 'Pentadbir sistem dengan akses penuh',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);

        $this->command->info('JenisPengguna seeded successfully!');
    }
}
