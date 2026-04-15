<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Sektor;

class SektorSeeder extends Seeder
{
    public function run(): void
    {
        Sektor::create([
            'nama_sektor' => 'Kewangan',
            'ketua_sektor' => 'Ahmad Bin Kadir',
            'keterangan_sektor' => 'Mengelola risiko kewangan dan operasional',
            'maklumat_perhubungan_sektor' => 'ahmad.kadir@example.com | 60-3-1234-5678',
        ]);

        Sektor::create([
            'nama_sektor' => 'Kesihatan',
            'ketua_sektor' => 'Siti Fatimah Bt Ismail',
            'keterangan_sektor' => 'Mengelola risiko operasional dan supply chain',
            'maklumat_perhubungan_sektor' => 'siti.fatimah@example.com | 60-3-1234-5679',
        ]);

        $this->command->info('Sektor seeded successfully!');
    }
}
