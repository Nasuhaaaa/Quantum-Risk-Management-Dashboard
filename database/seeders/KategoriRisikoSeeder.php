<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\KategoriRisiko;

class KategoriRisikoSeeder extends Seeder
{
    public function run(): void
    {
        KategoriRisiko::create([
            'kategori_risiko' => 'PKI & Sijil Digital',
        ]);

        KategoriRisiko::create([
            'kategori_risiko' => 'Rangkaian & Protokol',
        ]);

        KategoriRisiko::create([
            'kategori_risiko' => 'Pelaksanaan Sistem',
        ]);

        KategoriRisiko::create([
            'kategori_risiko' => 'Vendor & Rantaian Bekalan',
        ]);

        KategoriRisiko::create([
            'kategori_risiko' => 'Tadbir Urus & Kitar Hayat',
        ]);


        $this->command->info('KategoriRisiko seeded successfully!');
    }
}
