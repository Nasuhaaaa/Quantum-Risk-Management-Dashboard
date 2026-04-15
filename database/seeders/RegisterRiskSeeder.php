<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\RegisterRisk;
use App\Models\CBOM;
use App\Models\Risiko;
use App\Models\PuncaRisiko;

class RegisterRiskSeeder extends Seeder
{
    public function run(): void
    {
        $cbom1 = CBOM::where('algoritma_kriptografi', 'RSA-2048, AES-256, SHA-256')->first();
        $cbom2 = CBOM::where('algoritma_kriptografi', 'ECDH, AES-GCM, SHA-512, HKDF')->first();
        $cbom3 = CBOM::where('algoritma_kriptografi', 'SCRYPT (key derivation), SHA-256 (hashing)')->first();

        $risk1 = Risiko::where('nama_risiko', 'Algoritma masih menggunakan RSA/ECC tanpa mod hibrid')->first();
        $risk2 = Risiko::where('nama_risiko', 'Algoritma tiada disenaraikan dalam MySEAL')->first();
        $risk3 = Risiko::where('nama_risiko', 'Private key disimpan dalam software sahaja')->first();

        $punca1 = PuncaRisiko::where('punca_risiko', 'LIKE', '%Pelaksanaan komputer kuantum%')->first();
        $punca2 = PuncaRisiko::where('punca_risiko', 'Penggunaan skim berasaskan kata laluan sahaja')->first();

        RegisterRisk::create([
            'cbom_id' => $cbom1->id,
            'pemilik_risiko' => 'Bank Nasional Malaysia',
            'risiko_id' => $risk1->id,
            'punca_risiko_id' => $punca1->id,
            'tahap_risiko' => 'Tinggi',
            'kemungkinan' => 4,
            'impak' => 5,
            'skor_risiko' => 20,
            'kawalan_sedia_ada' => 'Penggunaan algoritma RSA-2048 dengan hybrid approach sebahagian',
            'pelan_mitigasi' => 'Laksanakan migrasi ke algoritma PQC pada 2025',
        ]);

        RegisterRisk::create([
            'cbom_id' => $cbom2->id,
            'pemilik_risiko' => 'Institut Kanser Negara',
            'risiko_id' => $risk2->id,
            'punca_risiko_id' => $punca2->id,
            'tahap_risiko' => 'Sederhana',
            'kemungkinan' => 3,
            'impak' => 4,
            'skor_risiko' => 12,
            'kawalan_sedia_ada' => 'Algoritma RSA tidak disenaraikan dalam MySEAL',
            'pelan_mitigasi' => 'Dapatkan kelulusan MySEAL untuk algoritma yang digunakan',
        ]);

        RegisterRisk::create([
            'cbom_id' => $cbom3->id,
            'pemilik_risiko' => 'Bank Nasional Malaysia',
            'risiko_id' => $risk3->id,
            'punca_risiko_id' => $punca1->id,
            'tahap_risiko' => 'Rendah',
            'kemungkinan' => 2,
            'impak' => 3,
            'skor_risiko' => 6,
            'kawalan_sedia_ada' => 'Private key disimpan dalam hardware security module (HSM)',
            'pelan_mitigasi' => 'Pastikan semua private keys menggunakan HSM atau perangkat keselamatan yang setara',
        ]);

        $this->command->info('RegisterRisk seeded successfully!');
    }
}
