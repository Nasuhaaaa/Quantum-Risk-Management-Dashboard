<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Risiko;
use App\Models\SubKategoriRisiko;

class RisikoSeeder extends Seeder
{
    public function run(): void
    {
        // Category 1: Kekuatan Algoritma Kriptografi
        $this->seedCategory1Risks();

        // Category 2: Keterlihatan Aset Kriptografi
        $this->seedCategory2Risks();

        // Category 3: Pengurusan Kunci
        $this->seedCategory3Risks();

        // Category 4: PKI & Sijil Digital
        $this->seedCategory4Risks();

        // Category 5: Rangkaian & Protokol
        $this->seedCategory5Risks();

        // Category 6: Pelaksanaan Sistem
        $this->seedCategory6Risks();

        // Category 7: Vendor & Rantaian Bekalan
        $this->seedCategory7Risks();

        // Category 8: Tadbir Urus & Kitar Hayat
        $this->seedCategory8Risks();

        $this->command->info('Risiko seeded successfully!');
    }

    private function seedCategory1Risks()
    {
        $subCats = [
            'Klasik vs Hibrid' => 'Algoritma masih menggunakan RSA/ECC tanpa mod hibrid',
            'Pematuhan NIST' => 'Algoritma PQC bukan versi yang diluluskan NIST',
            'Kitar Hayat Algoritma' => 'Algoritma dalam status deprecated',
            'Kekuatan Parameter' => 'Penggunaan parameter set tidak disyorkan',
            'Penggunaan Eksperimen' => 'Penggunaan algoritma eksperimen dalam produksi',
            'Ketahanan Kuantum' => 'Saiz kunci klasik tidak tahan ancaman kuantum',
            'Pematuhan Parameter' => 'Saiz kunci PQC tidak mengikut parameter rasmi',
            'Kekuatan Hash / Tandatangan' => 'Backup key menggunakan algoritma klasik',
            'Hash / Sijil' => 'Sijil masih menggunakan SHA-1/SHA-256 tanpa PQC',
        ];

        foreach ($subCats as $subCat => $risk) {
            $subCategory = SubKategoriRisiko::where('sub_kategori_risiko', $subCat)->first();
            if ($subCategory) {
                Risiko::firstOrCreate([
                    'nama_risiko' => $risk,
                    'sub_kategori_risiko_id' => $subCategory->id,
                ]);
            }
        }
    }

    private function seedCategory2Risks()
    {
        $subCats = [
            'Pendaftaran Inventori' => 'Algoritma tiada disenaraikan dalam MySEAL',
            'Pendedahan CBOM' => 'Algoritma tidak dinyatakan dalam CBOM (blind crypto asset)',
            'Penjejakan Lokasi Kunci' => 'Lokasi penyimpanan kunci tidak direkod dalam CBOM',
            'Inventori Sijil' => 'Tiada inventori sijil dalam CBOM',
            'Dokumentasi Set Sifer' => 'Cipher suite tidak didokumen dalam CBOM',
            'Pendedahan Komponen' => 'Komponen tidak menyatakan maklumat kriptografi lengkap',
            'SBOM Vendor' => 'SBOM vendor tidak lengkap',
            'CBOM Vendor' => 'CBOM tidak disediakan oleh vendor',
        ];

        foreach ($subCats as $subCat => $risk) {
            $subCategory = SubKategoriRisiko::where('sub_kategori_risiko', $subCat)->first();
            if ($subCategory) {
                Risiko::firstOrCreate([
                    'nama_risiko' => $risk,
                    'sub_kategori_risiko_id' => $subCategory->id,
                ]);
            }
        }
    }

    private function seedCategory3Risks()
    {
        $subCats = [
            'Penyimpanan Kunci' => 'Private key disimpan dalam software sahaja',
            'Perlindungan Perkakasan' => 'Kunci tidak dilindungi HSM',
            'Kitar Hayat Kunci' => 'Tiada mekanisme key rotation',
            'Penamatan Kunci' => 'Kunci lama masih aktif selepas migrasi',
            'Kualiti Entropi' => 'Entropy source tidak mencukupi',
            'Pematuhan Polisi' => 'Key usage tidak selari dengan polisi',
        ];

        foreach ($subCats as $subCat => $risk) {
            $subCategory = SubKategoriRisiko::where('sub_kategori_risiko', $subCat)->first();
            if ($subCategory) {
                Risiko::firstOrCreate([
                    'nama_risiko' => $risk,
                    'sub_kategori_risiko_id' => $subCategory->id,
                ]);
            }
        }
    }

    private function seedCategory4Risks()
    {
        $subCats = [
            'Keupayaan CA' => 'CA tidak menyokong tandatangan PQC',
            'Keserasian Rantaian' => 'Certificate chain bercampur algoritma tidak serasi',
            'Tempoh Sah Sijil' => 'Validity period sijil terlalu panjang (HNDL exposure)',
            'Sijil Tidak Dikenali' => 'Sijil self-signed tidak diketahui',
            'Pengiktirafan OID' => 'OID algoritma dalam sijil tidak dikenali sistem',
            'Penyimpanan Sijil Terpercaya' => 'Trust store tidak dikemas kini',
            'Pengujian Hibrid' => 'Hybrid certificate tidak diuji',
            'Risiko Penurunan Tahap (Downgrade)' => 'Risiko downgrade ke sijil klasik',
        ];

        foreach ($subCats as $subCat => $risk) {
            $subCategory = SubKategoriRisiko::where('sub_kategori_risiko', $subCat)->first();
            if ($subCategory) {
                Risiko::firstOrCreate([
                    'nama_risiko' => $risk,
                    'sub_kategori_risiko_id' => $subCategory->id,
                ]);
            }
        }
    }

    private function seedCategory5Risks()
    {
        $subCats = [
            'Keupayaan TLS' => 'TLS tidak menyokong PQC cipher suite',
            'Kebenaran Sifer Lemah' => 'TLS masih membenarkan cipher lemah',
            'Keupayaan VPN/IPSec' => 'VPN/IPSec tidak menyokong ML-KEM',
            'Konfigurasi SSH' => 'SSH tidak dikonfigurasi hybrid',
            'Had Saiz Protokol' => 'Protokol tidak menyokong mesej besar (PQC signature)',
            'Keselamatan Rundingan' => 'Downgrade attack semasa negotiation',
            'Impak Prestasi' => 'Kependaman tinggi akibat saiz kunci',
            'Keserasian Peranti Rangkaian' => 'Firewall/load balancer/WAF/VPN tidak serasi PQC',
        ];

        foreach ($subCats as $subCat => $risk) {
            $subCategory = SubKategoriRisiko::where('sub_kategori_risiko', $subCat)->first();
            if ($subCategory) {
                Risiko::firstOrCreate([
                    'nama_risiko' => $risk,
                    'sub_kategori_risiko_id' => $subCategory->id,
                ]);
            }
        }
    }

    private function seedCategory6Risks()
    {
        $subCats = [
            'Pengelasan Keselamatan' => 'Tahap keselamatan tidak selari klasifikasi sistem',
            'Konsistensi Versi' => 'Versi algoritma berbeza antara komponen',
            'Keanjalan Kripto (Crypto Agility)' => 'Tiada crypto-agility untuk pertukaran algoritma',
            'Konsistensi Persekitaran' => 'Konfigurasi berbeza antara persekitaran',
            'Kekinian Pustaka' => 'Library kriptografi versi lama',
            'Kemas Kini Pustaka' => 'OpenSSL/liboqs tidak dikemas kini',
            'Kebergantungan Legasi' => 'Dependensi masih guna algoritma klasik',
            'Sokongan Firmware' => 'Firmware tidak menyokong PQC',
            'Keserasian Pustaka' => 'Versi library kriptografi berbeza menyebabkan ketidakserasian',
            'Pengesahan Integriti' => 'Tiada hash integrity verification',
        ];

        foreach ($subCats as $subCat => $risk) {
            $subCategory = SubKategoriRisiko::where('sub_kategori_risiko', $subCat)->first();
            if ($subCategory) {
                Risiko::firstOrCreate([
                    'nama_risiko' => $risk,
                    'sub_kategori_risiko_id' => $subCategory->id,
                ]);
            }
        }
    }

    private function seedCategory7Risks()
    {
        $subCats = [
            'Status Pengesahan' => 'Tiada status FIPS/NIST validation',
            'Pelan Hala Tuju Vendor' => 'Vendor tidak menyatakan roadmap PQC',
            'Keupayaan Vendor' => 'Vendor tiada sokongan crypto-agility',
            'Ketelusan' => 'Komponen closed-source tidak telus',
            'Risiko Geopolitik' => 'Komponen dibangunkan di lokasi berisiko tinggi',
            'Asal Usul (Provenans)' => 'Ketidakpastian asal-usul modul kriptografi',
            'Risiko Pengubahsuaian (Tampering)' => 'Risiko manipulasi komponen kriptografi',
            'Pematuhan Piawaian' => 'Ketidakpatuhan kepada piawaian kriptografi antarabangsa',
        ];

        foreach ($subCats as $subCat => $risk) {
            $subCategory = SubKategoriRisiko::where('sub_kategori_risiko', $subCat)->first();
            if ($subCategory) {
                Risiko::firstOrCreate([
                    'nama_risiko' => $risk,
                    'sub_kategori_risiko_id' => $subCategory->id,
                ]);
            }
        }
    }

    private function seedCategory8Risks()
    {
        $subCats = [
            'Pemantauan Algoritma' => 'Tiada pemantauan perubahan algoritma',
            'Kemas Kini Automatik' => 'Tiada mekanisme kemas kini automatik apabila algoritma ditarik balik',
        ];

        foreach ($subCats as $subCat => $risk) {
            $subCategory = SubKategoriRisiko::where('sub_kategori_risiko', $subCat)->first();
            if ($subCategory) {
                Risiko::firstOrCreate([
                    'nama_risiko' => $risk,
                    'sub_kategori_risiko_id' => $subCategory->id,
                ]);
            }
        }
    }
}
