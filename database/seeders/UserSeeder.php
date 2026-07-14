<?php

namespace Database\Seeders;

use App\Models\Agensi;
use App\Models\JenisPengguna;
use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $jenisPenggunaEntiti = JenisPengguna::where('jenis_pengguna', 'Entiti (Agensi)')->first()?->role_id;
        $jenisPenggunaSektor = JenisPengguna::where('jenis_pengguna', 'Ketua Sektor')->first()?->role_id;
        $jenisPengguna = JenisPengguna::where('jenis_pengguna', 'Pengurusan')->first()?->role_id;
        $jenisPenggunaAdmin = JenisPengguna::where('jenis_pengguna', 'Sistem Admin')->first()?->role_id;

        $agencies = Agensi::all();

        $users = [];

        foreach ($agencies as $agency) {
            $users[] = [
                'username' => strtolower(str_replace([' ', '&', '/'], ['', '', ''], $agency->nama_agensi)) . '.user',
                'jenis_pengguna_id' => $jenisPenggunaEntiti,
                'agensi_id' => $agency->id,
            ];
            $users[] = [
                'username' => strtolower(str_replace([' ', '&', '/'], ['', '', ''], $agency->nama_agensi)) . '.reviewer',
                'jenis_pengguna_id' => $jenisPenggunaEntiti,
                'agensi_id' => $agency->id,
            ];
        }

        $users = array_merge($users, [
            [
                'username' => 'sektor.head',
                'jenis_pengguna_id' => $jenisPenggunaSektor,
                'agensi_id' => null,
            ],
            [
                'username' => 'risk.manager',
                'jenis_pengguna_id' => $jenisPengguna,
                'agensi_id' => null,
            ],
            [
                'username' => 'system.admin',
                'jenis_pengguna_id' => $jenisPenggunaAdmin,
                'agensi_id' => null,
            ],
        ]);

        foreach ($users as $user) {
            if (!$user['jenis_pengguna_id']) {
                continue;
            }

            User::updateOrCreate(
                ['username' => $user['username']],
                [
                    'jenis_pengguna_id' => $user['jenis_pengguna_id'],
                    'agensi_id' => $user['agensi_id'],
                    'password' => 'Test@123456',
                ]
            );
        }

        $this->command->info('User seeded successfully!');
    }
}
