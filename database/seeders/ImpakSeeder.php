<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Impak;

class ImpakSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            ['tahap' => 'Sangat Rendah', 'skala' => 1],
            ['tahap' => 'Rendah', 'skala' => 2],
            ['tahap' => 'Sederhana', 'skala' => 3],
            ['tahap' => 'Tinggi', 'skala' => 4],
            ['tahap' => 'Sangat Tinggi', 'skala' => 5],
        ];

        foreach ($data as $item) {
            Impak::firstOrCreate(['tahap' => $item['tahap']], $item);
        }

        $this->command->info('Impak seeded successfully!');
    }
}
