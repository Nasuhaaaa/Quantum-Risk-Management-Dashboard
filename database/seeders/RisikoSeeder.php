<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Risiko;
use App\Models\SubKategoriRisiko;

class RisikoSeeder extends Seeder
{
    public function run(): void
    {
        $subCat1 = SubKategoriRisiko::where('sub_kategori_risiko', 'Klasik vs Hybrid')->first();
        $subCat2 = SubKategoriRisiko::where('sub_kategori_risiko', 'Pendaftaran Inventori')->first();
        $subCat3 = SubKategoriRisiko::where('sub_kategori_risiko', 'Penyimpanan Kunci')->first();

        Risiko::create([
            'nama_risiko' => 'Algoritma masih menggunakan RSA/ECC tanpa mod hibrid',
            'sub_kategori_risiko_id' => $subCat1->id,
        ]);

        Risiko::create([
            'nama_risiko' => 'Algoritma tiada disenaraikan dalam MySEAL',
            'sub_kategori_risiko_id' => $subCat2->id,
        ]);

        Risiko::create([
            'nama_risiko' => 'Private key disimpan dalam software sahaja',
            'sub_kategori_risiko_id' => $subCat3->id,
        ]);

        $this->command->info('Risiko seeded successfully!');
    }
}
