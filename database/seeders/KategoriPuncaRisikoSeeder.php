<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\KategoriPuncaRisiko;

class KategoriPuncaRisikoSeeder extends Seeder
{
    public function run(): void
    {
        KategoriPuncaRisiko::create([
            'kategori_punca_risiko' => 'Ancaman Strategik Kuantum',
        ]);

        KategoriPuncaRisiko::create([
            'kategori_punca_risiko' => 'Jaminan Algoritma',
        ]);

        $this->command->info('KategoriPuncaRisiko seeded successfully!');
    }
}
