<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\SubKategoriRisiko;
use App\Models\KategoriRisiko;

class SubKategoriRisikoSeeder extends Seeder
{
    public function run(): void
    {
        $cat1 = KategoriRisiko::where('kategori_risiko', 'Kekuatan Algoritma Kriptografi')->first();
        $cat2 = KategoriRisiko::where('kategori_risiko', 'Keterlihatan Aset Kriptografi')->first();
        $cat3 = KategoriRisiko::where('kategori_risiko', 'Pengurusan Kunci')->first();
        $cat4 = KategoriRisiko::where('kategori_risiko', 'PKI & Sijil Digital')->first();
        $cat5 = KategoriRisiko::where('kategori_risiko', 'Rangkaian & Protokol')->first();
        $cat6 = KategoriRisiko::where('kategori_risiko', 'Pelaksanaan Sistem')->first();
        $cat7 = KategoriRisiko::where('kategori_risiko', 'Vendor & Rantaian Bekalan')->first();
        $cat8 = KategoriRisiko::where('kategori_risiko', 'Tadbir Urus & Kitar Hayat')->first();

        // Category 1: Kekuatan Algoritma Kriptografi
        SubKategoriRisiko::firstOrCreate([
            'kategori_risiko_id' => $cat1->id,
            'sub_kategori_risiko' => 'Klasik vs Hibrid',
        ]);
        SubKategoriRisiko::firstOrCreate([
            'kategori_risiko_id' => $cat1->id,
            'sub_kategori_risiko' => 'Pematuhan NIST',
        ]);
        SubKategoriRisiko::firstOrCreate([
            'kategori_risiko_id' => $cat1->id,
            'sub_kategori_risiko' => 'Kitar Hayat Algoritma',
        ]);
        SubKategoriRisiko::firstOrCreate([
            'kategori_risiko_id' => $cat1->id,
            'sub_kategori_risiko' => 'Kekuatan Parameter',
        ]);
        SubKategoriRisiko::firstOrCreate([
            'kategori_risiko_id' => $cat1->id,
            'sub_kategori_risiko' => 'Penggunaan Eksperimen',
        ]);
        SubKategoriRisiko::firstOrCreate([
            'kategori_risiko_id' => $cat1->id,
            'sub_kategori_risiko' => 'Ketahanan Kuantum',
        ]);
        SubKategoriRisiko::firstOrCreate([
            'kategori_risiko_id' => $cat1->id,
            'sub_kategori_risiko' => 'Pematuhan Parameter',
        ]);
        SubKategoriRisiko::firstOrCreate([
            'kategori_risiko_id' => $cat1->id,
            'sub_kategori_risiko' => 'Kekuatan Hash / Tandatangan',
        ]);
        SubKategoriRisiko::firstOrCreate([
            'kategori_risiko_id' => $cat1->id,
            'sub_kategori_risiko' => 'Hash / Sijil',
        ]);

        // Category 2: Keterlihatan Aset Kriptografi
        SubKategoriRisiko::firstOrCreate([
            'kategori_risiko_id' => $cat2->id,
            'sub_kategori_risiko' => 'Pendaftaran Inventori',
        ]);
        SubKategoriRisiko::firstOrCreate([
            'kategori_risiko_id' => $cat2->id,
            'sub_kategori_risiko' => 'Pendedahan CBOM',
        ]);
        SubKategoriRisiko::firstOrCreate([
            'kategori_risiko_id' => $cat2->id,
            'sub_kategori_risiko' => 'Penjejakan Lokasi Kunci',
        ]);
        SubKategoriRisiko::firstOrCreate([
            'kategori_risiko_id' => $cat2->id,
            'sub_kategori_risiko' => 'Inventori Sijil',
        ]);
        SubKategoriRisiko::firstOrCreate([
            'kategori_risiko_id' => $cat2->id,
            'sub_kategori_risiko' => 'Dokumentasi Set Sifer',
        ]);
        SubKategoriRisiko::firstOrCreate([
            'kategori_risiko_id' => $cat2->id,
            'sub_kategori_risiko' => 'Pendedahan Komponen',
        ]);
        SubKategoriRisiko::firstOrCreate([
            'kategori_risiko_id' => $cat2->id,
            'sub_kategori_risiko' => 'SBOM Vendor',
        ]);
        SubKategoriRisiko::firstOrCreate([
            'kategori_risiko_id' => $cat2->id,
            'sub_kategori_risiko' => 'CBOM Vendor',
        ]);

        // Category 3: Pengurusan Kunci
        SubKategoriRisiko::firstOrCreate([
            'kategori_risiko_id' => $cat3->id,
            'sub_kategori_risiko' => 'Penyimpanan Kunci',
        ]);
        SubKategoriRisiko::firstOrCreate([
            'kategori_risiko_id' => $cat3->id,
            'sub_kategori_risiko' => 'Perlindungan Perkakasan',
        ]);
        SubKategoriRisiko::firstOrCreate([
            'kategori_risiko_id' => $cat3->id,
            'sub_kategori_risiko' => 'Kitar Hayat Kunci',
        ]);
        SubKategoriRisiko::firstOrCreate([
            'kategori_risiko_id' => $cat3->id,
            'sub_kategori_risiko' => 'Penamatan Kunci',
        ]);
        SubKategoriRisiko::firstOrCreate([
            'kategori_risiko_id' => $cat3->id,
            'sub_kategori_risiko' => 'Kualiti Entropi',
        ]);
        SubKategoriRisiko::firstOrCreate([
            'kategori_risiko_id' => $cat3->id,
            'sub_kategori_risiko' => 'Pematuhan Polisi',
        ]);

        // Category 4: PKI & Sijil Digital
        SubKategoriRisiko::firstOrCreate([
            'kategori_risiko_id' => $cat4->id,
            'sub_kategori_risiko' => 'Keupayaan CA',
        ]);
        SubKategoriRisiko::firstOrCreate([
            'kategori_risiko_id' => $cat4->id,
            'sub_kategori_risiko' => 'Keserasian Rantaian',
        ]);
        SubKategoriRisiko::firstOrCreate([
            'kategori_risiko_id' => $cat4->id,
            'sub_kategori_risiko' => 'Tempoh Sah Sijil',
        ]);
        SubKategoriRisiko::firstOrCreate([
            'kategori_risiko_id' => $cat4->id,
            'sub_kategori_risiko' => 'Sijil Tidak Dikenali',
        ]);
        SubKategoriRisiko::firstOrCreate([
            'kategori_risiko_id' => $cat4->id,
            'sub_kategori_risiko' => 'Pengiktirafan OID',
        ]);
        SubKategoriRisiko::firstOrCreate([
            'kategori_risiko_id' => $cat4->id,
            'sub_kategori_risiko' => 'Penyimpanan Sijil Terpercaya',
        ]);
        SubKategoriRisiko::firstOrCreate([
            'kategori_risiko_id' => $cat4->id,
            'sub_kategori_risiko' => 'Pengujian Hibrid',
        ]);
        SubKategoriRisiko::firstOrCreate([
            'kategori_risiko_id' => $cat4->id,
            'sub_kategori_risiko' => 'Risiko Penurunan Tahap (Downgrade)',
        ]);

        // Category 5: Rangkaian & Protokol
        SubKategoriRisiko::firstOrCreate([
            'kategori_risiko_id' => $cat5->id,
            'sub_kategori_risiko' => 'Keupayaan TLS',
        ]);
        SubKategoriRisiko::firstOrCreate([
            'kategori_risiko_id' => $cat5->id,
            'sub_kategori_risiko' => 'Kebenaran Sifer Lemah',
        ]);
        SubKategoriRisiko::firstOrCreate([
            'kategori_risiko_id' => $cat5->id,
            'sub_kategori_risiko' => 'Keupayaan VPN/IPSec',
        ]);
        SubKategoriRisiko::firstOrCreate([
            'kategori_risiko_id' => $cat5->id,
            'sub_kategori_risiko' => 'Konfigurasi SSH',
        ]);
        SubKategoriRisiko::firstOrCreate([
            'kategori_risiko_id' => $cat5->id,
            'sub_kategori_risiko' => 'Had Saiz Protokol',
        ]);
        SubKategoriRisiko::firstOrCreate([
            'kategori_risiko_id' => $cat5->id,
            'sub_kategori_risiko' => 'Keselamatan Rundingan',
        ]);
        SubKategoriRisiko::firstOrCreate([
            'kategori_risiko_id' => $cat5->id,
            'sub_kategori_risiko' => 'Impak Prestasi',
        ]);
        SubKategoriRisiko::firstOrCreate([
            'kategori_risiko_id' => $cat5->id,
            'sub_kategori_risiko' => 'Keserasian Peranti Rangkaian',
        ]);

        // Category 6: Pelaksanaan Sistem
        SubKategoriRisiko::firstOrCreate([
            'kategori_risiko_id' => $cat6->id,
            'sub_kategori_risiko' => 'Pengelasan Keselamatan',
        ]);
        SubKategoriRisiko::firstOrCreate([
            'kategori_risiko_id' => $cat6->id,
            'sub_kategori_risiko' => 'Konsistensi Versi',
        ]);
        SubKategoriRisiko::firstOrCreate([
            'kategori_risiko_id' => $cat6->id,
            'sub_kategori_risiko' => 'Keanjalan Kripto (Crypto Agility)',
        ]);
        SubKategoriRisiko::firstOrCreate([
            'kategori_risiko_id' => $cat6->id,
            'sub_kategori_risiko' => 'Konsistensi Persekitaran',
        ]);
        SubKategoriRisiko::firstOrCreate([
            'kategori_risiko_id' => $cat6->id,
            'sub_kategori_risiko' => 'Kekinian Pustaka',
        ]);
        SubKategoriRisiko::firstOrCreate([
            'kategori_risiko_id' => $cat6->id,
            'sub_kategori_risiko' => 'Kemas Kini Pustaka',
        ]);
        SubKategoriRisiko::firstOrCreate([
            'kategori_risiko_id' => $cat6->id,
            'sub_kategori_risiko' => 'Kebergantungan Legasi',
        ]);
        SubKategoriRisiko::firstOrCreate([
            'kategori_risiko_id' => $cat6->id,
            'sub_kategori_risiko' => 'Sokongan Firmware',
        ]);
        SubKategoriRisiko::firstOrCreate([
            'kategori_risiko_id' => $cat6->id,
            'sub_kategori_risiko' => 'Keserasian Pustaka',
        ]);
        SubKategoriRisiko::firstOrCreate([
            'kategori_risiko_id' => $cat6->id,
            'sub_kategori_risiko' => 'Pengesahan Integriti',
        ]);

        // Category 7: Vendor & Rantaian Bekalan
        SubKategoriRisiko::firstOrCreate([
            'kategori_risiko_id' => $cat7->id,
            'sub_kategori_risiko' => 'Status Pengesahan',
        ]);
        SubKategoriRisiko::firstOrCreate([
            'kategori_risiko_id' => $cat7->id,
            'sub_kategori_risiko' => 'Pelan Hala Tuju Vendor',
        ]);
        SubKategoriRisiko::firstOrCreate([
            'kategori_risiko_id' => $cat7->id,
            'sub_kategori_risiko' => 'Keupayaan Vendor',
        ]);
        SubKategoriRisiko::firstOrCreate([
            'kategori_risiko_id' => $cat7->id,
            'sub_kategori_risiko' => 'Ketelusan',
        ]);
        SubKategoriRisiko::firstOrCreate([
            'kategori_risiko_id' => $cat7->id,
            'sub_kategori_risiko' => 'Risiko Geopolitik',
        ]);
        SubKategoriRisiko::firstOrCreate([
            'kategori_risiko_id' => $cat7->id,
            'sub_kategori_risiko' => 'Asal Usul (Provenans)',
        ]);
        SubKategoriRisiko::firstOrCreate([
            'kategori_risiko_id' => $cat7->id,
            'sub_kategori_risiko' => 'Risiko Pengubahsuaian (Tampering)',
        ]);
        SubKategoriRisiko::firstOrCreate([
            'kategori_risiko_id' => $cat7->id,
            'sub_kategori_risiko' => 'Pematuhan Piawaian',
        ]);

        // Category 8: Tadbir Urus & Kitar Hayat
        SubKategoriRisiko::firstOrCreate([
            'kategori_risiko_id' => $cat8->id,
            'sub_kategori_risiko' => 'Pemantauan Algoritma',
        ]);
        SubKategoriRisiko::firstOrCreate([
            'kategori_risiko_id' => $cat8->id,
            'sub_kategori_risiko' => 'Kemas Kini Automatik',
        ]);

        $this->command->info('SubKategoriRisiko seeded successfully!');
    }
}
