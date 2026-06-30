<?php

namespace Database\Seeders;

use App\Models\Agensi;
use App\Models\CBOM;
use App\Models\Impak;
use App\Models\Inventori;
use App\Models\Kebarangkalian;
use App\Models\PuncaRisiko;
use App\Models\RegisterRisk;
use App\Models\Risiko;
use App\Models\SBOM;
use App\Models\Sektor;
use App\Models\TahapRisiko;
use Illuminate\Database\Seeder;

class AdditionalSampleDataSeeder extends Seeder
{
    public function run(): void
    {
        $assets = [
            [
                'sector' => 'Tenaga',
                'agency' => 'Tenaga Nasional Digital',
                'asset' => 'Grid Operations Control Platform',
                'jenis_aset' => 'Sistem Kawalan Infrastruktur Kritikal',
                'location' => 'Pusat Kawalan Grid - Bangsar',
                'legacy' => 'Sebahagian - integrasi SCADA lama masih aktif',
                'crypto' => 'TLS 1.2, RSA-2048, AES-256-GCM',
                'algorithm' => 'RSA-2048, AES-256-GCM, SHA-256',
                'key_length' => '2048-bit RSA, 256-bit AES',
                'purpose' => 'Komunikasi operator, integriti arahan grid, audit transaksi operasi',
                'libraries' => 'OpenSSL, Java Cryptography Architecture, Bouncy Castle',
                'data_category' => 'Grid Telemetry, Operator Commands, Incident Logs',
                'agility' => 'Medium - lapisan API boleh dikemas kini, peranti medan memerlukan penggantian berperingkat',
                'risk' => 'TLS tidak menyokong PQC cipher suite',
                'cause_like' => '%Pelaksanaan komputer kuantum%',
                'impact' => 5,
                'likelihood' => 4,
                'control' => 'Segmentasi rangkaian OT, sijil dalaman, dan pemantauan trafik anomali',
                'mitigation' => 'Rancang ujian TLS hibrid PQC untuk sistem kawalan dan kemas kini gateway kriptografi.',
            ],
            [
                'sector' => 'Pendidikan',
                'agency' => 'Universiti Teknologi Nasional',
                'asset' => 'Research Data Exchange Portal',
                'jenis_aset' => 'Portal Perkongsian Data Penyelidikan',
                'location' => 'Cloud Government Zone - Cyberjaya',
                'legacy' => 'Tidak - aplikasi moden berasaskan kontena',
                'crypto' => 'ECDSA P-256, AES-GCM, SHA-256',
                'algorithm' => 'ECDSA P-256, AES-GCM, SHA-256',
                'key_length' => '256-bit ECC, 256-bit AES',
                'purpose' => 'Tandatangan dokumen penyelidikan, penyulitan dataset, pengesahan API',
                'libraries' => 'libsodium, OpenSSL, Laravel Sanctum',
                'data_category' => 'Research Datasets, Researcher Identity, API Tokens',
                'agility' => 'High - servis kontena boleh dinaik taraf secara berperingkat',
                'risk' => 'Algoritma masih menggunakan RSA/ECC tanpa mod hibrid',
                'cause_like' => '%Ketiadaan inventori aset kriptografi%',
                'impact' => 4,
                'likelihood' => 3,
                'control' => 'Semakan keselamatan kod dan pengurusan rahsia melalui vault',
                'mitigation' => 'Tambah profil hibrid untuk tandatangan dokumen dan senaraikan komponen kriptografi dalam CBOM.',
            ],
            [
                'sector' => 'Pengangkutan',
                'agency' => 'Agensi Pengangkutan Awam Digital',
                'asset' => 'National Ticketing Gateway',
                'jenis_aset' => 'Gerbang Pembayaran dan Tiket',
                'location' => 'Data Center Transit - Putrajaya',
                'legacy' => 'Ya - integrasi terminal lama masih digunakan',
                'crypto' => 'RSA-2048, 3DES fallback, SHA-1, AES-128',
                'algorithm' => 'RSA-2048, AES-128, SHA-1',
                'key_length' => '2048-bit RSA, 128-bit AES',
                'purpose' => 'Pembayaran tiket, pengesahan terminal, token transaksi',
                'libraries' => 'OpenSSL 1.0.2, vendor payment SDK, HSM client library',
                'data_category' => 'Payment Tokens, Travel Records, Terminal Credentials',
                'agility' => 'Low - vendor SDK lama mengehadkan sokongan algoritma baharu',
                'risk' => 'TLS masih membenarkan cipher lemah',
                'cause_like' => '%Penggunaan skim berasaskan kata laluan sahaja%',
                'impact' => 5,
                'likelihood' => 5,
                'control' => 'Pemantauan transaksi dan had kadar untuk terminal berisiko',
                'mitigation' => 'Matikan cipher lemah, tingkatkan SDK vendor, dan wajibkan sambungan TLS moden.',
            ],
            [
                'sector' => 'Kesihatan',
                'agency' => 'Hospital Digital Putrajaya',
                'asset' => 'Electronic Medical Record Vault',
                'jenis_aset' => 'Repositori Rekod Perubatan Elektronik',
                'location' => 'Private Cloud Kesihatan - Putrajaya',
                'legacy' => 'Sebahagian - modul arkib lama masih aktif',
                'crypto' => 'RSA-3072, AES-256, SHA-512',
                'algorithm' => 'RSA-3072, AES-256, SHA-512',
                'key_length' => '3072-bit RSA, 256-bit AES',
                'purpose' => 'Penyulitan rekod pesakit, tandatangan laporan, audit akses',
                'libraries' => 'Java JCE, PostgreSQL pgcrypto, Keycloak',
                'data_category' => 'Patient Records, Clinical Reports, Audit Trails',
                'agility' => 'Medium - modul identiti boleh dinaik taraf dahulu sebelum arkib',
                'risk' => 'Validity period sijil terlalu panjang (HNDL exposure)',
                'cause_like' => '%Pelaksanaan komputer kuantum%',
                'impact' => 5,
                'likelihood' => 3,
                'control' => 'Penyulitan pangkalan data dan kawalan akses berasaskan peranan',
                'mitigation' => 'Pendekkan tempoh sah sijil, laksana inventori sijil, dan rancang sijil hibrid.',
            ],
            [
                'sector' => 'Kewangan',
                'agency' => 'Lembaga Pembiayaan Digital',
                'asset' => 'Loan Origination API',
                'jenis_aset' => 'API Pembiayaan dan Kelayakan Kredit',
                'location' => 'Hybrid Cloud - Kuala Lumpur',
                'legacy' => 'Tidak - microservice moden',
                'crypto' => 'JWT RS256, AES-256, SHA-256',
                'algorithm' => 'RSA-2048 JWT, AES-256, SHA-256',
                'key_length' => '2048-bit RSA, 256-bit AES',
                'purpose' => 'Tandatangan token, penyulitan maklumat pemohon, integrasi API',
                'libraries' => 'Nimbus JOSE JWT, AWS KMS SDK, OpenSSL',
                'data_category' => 'Credit Application Data, PII, API Credentials',
                'agility' => 'High - kunci dan algoritma dikawal melalui KMS',
                'risk' => 'Key usage tidak selari dengan polisi',
                'cause_like' => '%Ketiadaan inventori aset kriptografi%',
                'impact' => 4,
                'likelihood' => 2,
                'control' => 'KMS berpusat, rotasi kunci berkala, dan audit akses API',
                'mitigation' => 'Selaraskan polisi penggunaan kunci dengan klasifikasi data dan automasikan semakan KMS.',
            ],
            [
                'sector' => 'Kerajaan Digital',
                'agency' => 'Jabatan Identiti Digital Negara',
                'asset' => 'National Identity Signing Service',
                'jenis_aset' => 'Perkhidmatan Tandatangan Identiti Digital',
                'location' => 'Government Secure Data Center',
                'legacy' => 'Tidak - platform identiti generasi baharu',
                'crypto' => 'ECDSA, RSA-PSS, SHA-256, HSM backed keys',
                'algorithm' => 'ECDSA P-384, RSA-PSS, SHA-256',
                'key_length' => '384-bit ECC, 3072-bit RSA',
                'purpose' => 'Tandatangan transaksi identiti, pengesahan dokumen, integrasi eKYC',
                'libraries' => 'HSM PKCS#11, OpenSSL 3, custom signing service',
                'data_category' => 'Identity Assertions, Signing Keys, Citizen Verification Logs',
                'agility' => 'Medium - HSM menyokong profil baharu tetapi aplikasi perlu diuji',
                'risk' => 'CA tidak menyokong tandatangan PQC',
                'cause_like' => '%Pelaksanaan komputer kuantum%',
                'impact' => 5,
                'likelihood' => 4,
                'control' => 'HSM, pemisahan tugas pentadbir, dan audit transaksi tandatangan',
                'mitigation' => 'Uji CA hibrid, kenal pasti sokongan HSM PQC, dan sediakan pelan rollover sijil.',
            ],
        ];

        foreach ($assets as $item) {
            $sector = Sektor::firstOrCreate(
                ['nama_sektor' => $item['sector']],
                [
                    'ketua_sektor' => 'Ketua Sektor ' . $item['sector'],
                    'keterangan_sektor' => 'Sektor sampel untuk penilaian risiko PQC',
                    'maklumat_perhubungan_sektor' => strtolower(str_replace(' ', '.', $item['sector'])) . '@example.gov.my | 60-3-8000-0000',
                ]
            );

            $agency = Agensi::updateOrCreate(
                ['nama_agensi' => $item['agency']],
                [
                    'sektor_id' => $sector->id,
                    'no_tel_agensi' => '60-3-8000-' . str_pad((string) $sector->id, 4, '0', STR_PAD_LEFT),
                    'website' => 'www.' . strtolower(str_replace(' ', '-', $item['agency'])) . '.gov.my',
                    'nama_pic' => 'Pegawai Keselamatan ICT',
                    'no_tel_pic' => '60-3-8000-1000',
                    'emel_pic' => 'pqc.' . strtolower(str_replace(' ', '.', $item['agency'])) . '@example.gov.my',
                    'jenis_perniagaan_perhubungan' => $item['sector'],
                ]
            );

            $inventory = Inventori::updateOrCreate(
                ['nama_aset' => $item['asset']],
                [
                    'agensi_id' => $agency->id,
                    'jenis_aset' => $item['jenis_aset'],
                    'lokasi_pemilik' => $item['location'],
                    'sistem_legasi' => $item['legacy'],
                    'catatan' => 'Data sampel PQC: ' . $item['purpose'],
                ]
            );

            $sbom = SBOM::updateOrCreate(
                ['inventori_id' => $inventory->id, 'komponen_versi' => $item['asset'] . ' Components'],
                [
                    'sub_komponen' => 'Authentication, Encryption, Audit, API Gateway',
                    'url' => 'https://example.gov.my/' . strtolower(str_replace(' ', '-', $item['asset'])),
                    'mod_perkhidmatan' => 'Production',
                    'language_framework' => 'Java, PHP, Node.js, Python',
                    'modules_libraries' => $item['libraries'],
                    'external_apis_services' => 'Identity Provider, Notification API, Monitoring API',
                    'in_house_vendor' => 'Internal Digital Team',
                    'nama_vendor' => $item['agency'] . ' ICT Division',
                    'kepakaran_kriptografi' => $item['crypto'],
                ]
            );

            $cbom = CBOM::updateOrCreate(
                ['sbom_id' => $sbom->id, 'algoritma_kriptografi' => $item['algorithm']],
                [
                    'panjang_kunci' => $item['key_length'],
                    'tujuan_penggunaan' => $item['purpose'],
                    'library_modules' => $item['libraries'],
                    'kategori_data' => $item['data_category'],
                    'sokongan_crypto_agility' => $item['agility'],
                ]
            );

            $risk = Risiko::where('nama_risiko', $item['risk'])->first() ?? Risiko::first();
            $cause = PuncaRisiko::where('punca_risiko', 'LIKE', $item['cause_like'])->first() ?? PuncaRisiko::first();

            if (!$risk || !$cause) {
                continue;
            }

            $score = $item['impact'] * $item['likelihood'];
            $riskLevel = TahapRisiko::where('skor_min', '<=', $score)
                ->where('skor_max', '>=', $score)
                ->first();
            $impact = Impak::where('skala', $item['impact'])->first();
            $likelihood = Kebarangkalian::where('skala', $item['likelihood'])->first();

            if (!$riskLevel || !$impact || !$likelihood) {
                continue;
            }

            $exists = RegisterRisk::where('cbom_id', $cbom->id)
                ->where('risiko_id', $risk->id)
                ->where('punca_risiko_id', $cause->id)
                ->exists();

            if (!$exists) {
                RegisterRisk::create([
                    'cbom_id' => $cbom->id,
                    'risiko_id' => $risk->id,
                    'pemilik_risiko' => $agency->nama_agensi,
                    'punca_risiko_id' => $cause->id,
                    'impak' => $impact->skala,
                    'kemungkinan' => $likelihood->skala,
                    'impak_id' => $impact->impak_id,
                    'kebarangkalian_id' => $likelihood->kebarangkalian_id,
                    'skor_risiko' => $score,
                    'tahap_risiko' => $riskLevel->tahap_risiko,
                    'tahap_risiko_id' => $riskLevel->tahap_risiko_id,
                    'kawalan_sedia_ada' => $item['control'],
                    'pelan_mitigasi' => $item['mitigation'],
                ]);
            }
        }

        $this->command->info('Additional sample data seeded successfully!');
    }
}
