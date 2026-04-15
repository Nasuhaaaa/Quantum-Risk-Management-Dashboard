<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\JenisPengguna;
use App\Models\Agensi;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $jenisPenggunaEntiti = JenisPengguna::where('jenis_pengguna', 'Entiti (Agensi)')->first()?->role_id;
        $jenisPenggunaSektor = JenisPengguna::where('jenis_pengguna', 'Ketua Sektor')->first()?->role_id;
        $jenisPengguna = JenisPengguna::where('jenis_pengguna', 'Pengurusan')->first()?->role_id;
        $jenisPenggunaAdmin = JenisPengguna::where('jenis_pengguna', 'Sistem Admin')->first()?->role_id;

        $entity1 = Agensi::where('nama_agensi', 'Bank Nasional Malaysia')->first();

        // 1. Entiti User (from entity 1)
        User::create([
            'username' => 'entiti.user',
            'Jenis_Pengguna' => $jenisPenggunaEntiti,
            'ID_Agensi' => $entity1->id,
            'Kata_Laluan' => 'Test@123456',
        ]);

        // 2. Ketua Sektor User
        User::create([
            'username' => 'sektor.head',
            'Jenis_Pengguna' => $jenisPenggunaSektor,
            'ID_Agensi' => null,
            'Kata_Laluan' => 'Test@123456',
        ]);

        // 3. Pengurusan User (Risk Management)
        User::create([
            'username' => 'risk.manager',
            'Jenis_Pengguna' => $jenisPengguna,
            'ID_Agensi' => null,
            'Kata_Laluan' => 'Test@123456',
        ]);

        // 4. Admin User
        User::create([
            'username' => 'system.admin',
            'Jenis_Pengguna' => $jenisPenggunaAdmin,
            'ID_Agensi' => null,
            'Kata_Laluan' => 'Test@123456',
        ]);

        $this->command->info('User seeded successfully!');
    }
}
