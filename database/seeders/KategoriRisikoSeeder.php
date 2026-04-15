<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\KategoriRisiko;

class KategoriRisikoSeeder extends Seeder
{
    public function run(): void
    {
        KategoriRisiko::create([
            'kategori_risiko' => 'Kekuatan Algoritma Kriptografi',
        ]);

        KategoriRisiko::create([
            'kategori_risiko' => 'Keterlihatan Aset Kriptografi',
        ]);

        KategoriRisiko::create([
            'kategori_risiko' => 'Pengurusan Kunci',
        ]);

        $this->command->info('KategoriRisiko seeded successfully!');
    }
}
