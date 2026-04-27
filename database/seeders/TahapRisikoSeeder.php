<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\TahapRisiko;

class TahapRisikoSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            ['skor_min' => 1, 'skor_max' => 4, 'tahap_risiko' => 'Sangat Rendah'],
            ['skor_min' => 5, 'skor_max' => 9, 'tahap_risiko' => 'Rendah'],
            ['skor_min' => 10, 'skor_max' => 14, 'tahap_risiko' => 'Sederhana'],
            ['skor_min' => 15, 'skor_max' => 19, 'tahap_risiko' => 'Tinggi'],
            ['skor_min' => 20, 'skor_max' => 25, 'tahap_risiko' => 'Sangat Tinggi'],
        ];

        foreach ($data as $item) {
            TahapRisiko::firstOrCreate(['tahap_risiko' => $item['tahap_risiko']], $item);
        }

        $this->command->info('TahapRisiko seeded successfully!');
    }
}
