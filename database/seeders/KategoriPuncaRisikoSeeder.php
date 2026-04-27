<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\KategoriPuncaRisiko;

class KategoriPuncaRisikoSeeder extends Seeder
{
    public function run(): void
    {
        KategoriPuncaRisiko::firstOrCreate([
            'kategori_punca_risiko' => 'Ancaman Strategik Kuantum',
        ]);

        KategoriPuncaRisiko::firstOrCreate([
            'kategori_punca_risiko' => 'Jaminan Algoritma',
        ]);

        KategoriPuncaRisiko::firstOrCreate([
            'kategori_punca_risiko' => 'Kawalan Akses Kripto',
        ]);

        KategoriPuncaRisiko::firstOrCreate([
            'kategori_punca_risiko' => 'Kelemahan Implementasi',
        ]);

        KategoriPuncaRisiko::firstOrCreate([
            'kategori_punca_risiko' => 'Keterlihatan Aset Kriptografi',
        ]);

        KategoriPuncaRisiko::firstOrCreate([
            'kategori_punca_risiko' => 'Keupayaan & Sumber Manusia',
        ]);

        KategoriPuncaRisiko::firstOrCreate([
            'kategori_punca_risiko' => 'Migrasi PQC & Ketangkasan Kripto',
        ]);

        KategoriPuncaRisiko::firstOrCreate([
            'kategori_punca_risiko' => 'Operasi & Respons Insiden',
        ]);

        KategoriPuncaRisiko::firstOrCreate([
            'kategori_punca_risiko' => 'Pengurusan Kunci',
        ]);

        KategoriPuncaRisiko::firstOrCreate([
            'kategori_punca_risiko' => 'Perlindungan Data',
        ]);

        KategoriPuncaRisiko::firstOrCreate([
            'kategori_punca_risiko' => 'Rantaian Bekalan & Vendor',
        ]);

        KategoriPuncaRisiko::firstOrCreate([
            'kategori_punca_risiko' => 'Tadbir Urus & Polisi',
        ]);

        $this->command->info('KategoriPuncaRisiko seeded successfully!');
    }
}
