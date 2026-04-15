<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\SubKategoriRisiko;
use App\Models\KategoriRisiko;

class SubKategoriRisikoSeeder extends Seeder
{
    public function run(): void
    {
        $catRisiko1 = KategoriRisiko::where('kategori_risiko', 'Kekuatan Algoritma Kriptografi')->first();
        $catRisiko2 = KategoriRisiko::where('kategori_risiko', 'Keterlihatan Aset Kriptografi')->first();
        $catRisiko3 = KategoriRisiko::where('kategori_risiko', 'Pengurusan Kunci')->first();

        SubKategoriRisiko::create([
            'kategori_risiko_id' => $catRisiko1->id,
            'sub_kategori_risiko' => 'Klasik vs Hybrid',
        ]);

        SubKategoriRisiko::create([
            'kategori_risiko_id' => $catRisiko2->id,
            'sub_kategori_risiko' => 'Pendaftaran Inventori',
        ]);

        SubKategoriRisiko::create([
            'kategori_risiko_id' => $catRisiko3->id,
            'sub_kategori_risiko' => 'Penyimpanan Kunci',
        ]);

        $this->command->info('SubKategoriRisiko seeded successfully!');
    }
}
