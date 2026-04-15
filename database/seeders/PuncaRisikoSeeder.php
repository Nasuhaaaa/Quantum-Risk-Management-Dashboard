<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\PuncaRisiko;
use App\Models\KategoriPuncaRisiko;

class PuncaRisikoSeeder extends Seeder
{
    public function run(): void
    {
        $catPunca1 = KategoriPuncaRisiko::where('kategori_punca_risiko', 'Ancaman Strategik Kuantum')->first();
        $catPunca2 = KategoriPuncaRisiko::where('kategori_punca_risiko', 'Jaminan Algoritma')->first();

        PuncaRisiko::create([
            'punca_risiko' => 'Pelaksanaan komputer kuantum relevan terhadap kriptografi (CRQC) menjelang 2030',
            'kategori_punca_risiko_id' => $catPunca1->id,
            'pelan_mitigasi' => 'Bangunkan pelan migrasi PQC nasional, laksanakan inventori kripto, dan tetapkan garis masa peralihan algoritma',
        ]);

        PuncaRisiko::create([
            'punca_risiko' => 'Penggunaan skim berasaskan kata laluan sahaja',
            'kategori_punca_risiko_id' => $catPunca2->id,
            'pelan_mitigasi' => 'Perkenalkan MFA atau mekanisme berasaskan sijil/kunci, kuatkan derivasi kata laluan, dan hadkan penggunaan password sahaja',
        ]);

        $this->command->info('PuncaRisiko seeded successfully!');
    }
}
