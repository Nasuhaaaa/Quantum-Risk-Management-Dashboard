<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Sektor;
use App\Models\Agensi;
use App\Models\KategoriRisiko;
use App\Models\SubKategoriRisiko;
use App\Models\Risiko;
use App\Models\KategoriPuncaRisiko;
use App\Models\PuncaRisiko;
use App\Models\RegisterRisk;
use App\Models\Inventori;
use App\Models\SBOM;
use App\Models\CBOM;
use Illuminate\Support\Facades\DB;

class TestDataSeeder extends Seeder
{
    public function run(): void
    {
        // Create Jenis Pengguna (User Types)
        $jenisPenggunaEntiti = DB::table('jenis_pengguna')->insertGetId([
            'jenis_pengguna' => 'Entiti (Agensi)',
            'keterangan' => 'Agensi yang mendaftar dan menguruskan risiko',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $jenisPenggunaSektor = DB::table('jenis_pengguna')->insertGetId([
            'jenis_pengguna' => 'Ketua Sektor',
            'keterangan' => 'Ketua sektor yang mengurus entiti dalam bidang',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $jenisPengguna = DB::table('jenis_pengguna')->insertGetId([
            'jenis_pengguna' => 'Pengurusan',
            'keterangan' => 'Pihak pengurusan untuk semakan dan sahkan risiko',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $jenisPenggunaAdmin = DB::table('jenis_pengguna')->insertGetId([
            'jenis_pengguna' => 'Sistem Admin',
            'keterangan' => 'Pentadbir sistem dengan akses penuh',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        // Create Sectors
        $sector1 = Sektor::create([
            'nama_sektor' => 'Kewangan',
            'ketua_sektor' => 'Ahmad Bin Kadir',
            'keterangan_sektor' => 'Mengelola risiko kewangan dan operasional',
            'maklumat_perhubungan_sektor' => 'ahmad.kadir@example.com | 60-3-1234-5678',
        ]);

        $sector2 = Sektor::create([
            'nama_sektor' => 'Kesihatan',
            'ketua_sektor' => 'Siti Fatimah Bt Ismail',
            'keterangan_sektor' => 'Mengelola risiko operasional dan supply chain',
            'maklumat_perhubungan_sektor' => 'siti.fatimah@example.com | 60-3-1234-5679',
        ]);

        // Create Entities (Agensi)
        $entity1 = Agensi::create([
            'nama_agensi' => 'Bank Nasional Malaysia',
            'sektor_id' => $sector1->id,
            'no_tel_agensi' => '60-3-2000-0000',
            'website' => 'www.bnm.gov.my',
            'nama_pic' => 'Datuk Seri Tan Sri Ahmad',
            'no_tel_pic' => '60-3-2000-0001',
            'emel_pic' => 'datuk@bnm.gov.my',
            'jenis_perniagaan_perhubungan' => 'Bank Sentral',
        ]);

        $entity2 = Agensi::create([
            'nama_agensi' => 'Institut Kanser Negara',
            'sektor_id' => $sector2->id,
            'no_tel_agensi' => '60-3-3000-0000',
            'website' => 'www.ikn.gov.my',
            'nama_pic' => 'Encik Mohamed Bin Abdullah',
            'no_tel_pic' => '60-3-3000-0001',
            'emel_pic' => 'encik@ikn.gov.my',
            'jenis_perniagaan_perhubungan' => 'Pusat Rujukan Khusus Pesakit Kanser',
        ]);

        $entity3 = Agensi::create([
            'nama_agensi' => 'Bank Negara Malaysia',
            'sektor_id' => $sector1->id,
            'no_tel_agensi' => '60-3-4000-0000',
            'website' => 'www.bnm.gov.my',
            'nama_pic' => 'Tan Sri Wan Zulkiflee Wan Ariffin',
            'no_tel_pic' => '60-3-4000-0001',
            'emel_pic' => 'wanzulkiflee@bnm.gov.my',
            'jenis_perniagaan_perhubungan' => 'Perbadanan Minyak & Gas',
        ]);

        // Create Risk Categories
        $catRisiko1 = KategoriRisiko::create([
            'kategori_risiko' => 'Kekuatan Algoritma Kriptografi',
        ]);

        $catRisiko2 = KategoriRisiko::create([
            'kategori_risiko' => 'Keterlihatan Aset Kriptografi',
        ]);

        $catRisiko3 = KategoriRisiko::create([
            'kategori_risiko' => 'Pengurusan Kunci',
        ]);

        // Create Sub Categories
        $subCat1 = SubKategoriRisiko::create([
            'kategori_risiko_id' => $catRisiko1->id,
            'sub_kategori_risiko' => 'Klasik vs Hybrid',
        ]);

        $subCat2 = SubKategoriRisiko::create([
            'kategori_risiko_id' => $catRisiko2->id,
            'sub_kategori_risiko' => 'Pendaftaran Inventori',
        ]);

        $subCat3 = SubKategoriRisiko::create([
            'kategori_risiko_id' => $catRisiko3->id,
            'sub_kategori_risiko' => 'Penyimpanan Kunci',
        ]);

        // Create Risk Reasons
        $catPunca1 = KategoriPuncaRisiko::create([
            'kategori_punca_risiko' => 'Ancaman Strategik Kuantum',
        ]);

        $catPunca2 = KategoriPuncaRisiko::create([
            'kategori_punca_risiko' => 'Jaminan Algoritma',
        ]);

        $punca1 = PuncaRisiko::create([
            'punca_risiko' => 'Pelaksanaan komputer kuantum relevan terhadap kriptografi (CRQC) menjelang 2030',
            'kategori_punca_risiko_id' => $catPunca1->id,
            'pelan_mitigasi' => 'Bangunkan pelan migrasi PQC nasional, laksanakan inventori kripto, dan tetapkan garis masa peralihan algoritma',
        ]);

        $punca2 = PuncaRisiko::create([
            'punca_risiko' => 'Penggunaan skim berasaskan kata laluan sahaja',
            'kategori_punca_risiko_id' => $catPunca2->id,
            'pelan_mitigasi' => 'Perkenalkan MFA atau mekanisme berasaskan sijil/kunci, kuatkan derivasi kata laluan, dan hadkan penggunaan password sahaja',
        ]);

        // Create Risks
        $risk1 = Risiko::create([
            'nama_risiko' => 'Algoritma masih menggunakan RSA/ECC tanpa mod hibrid',
            'sub_kategori_risiko_id' => $subCat1->id,
        ]);

        $risk2 = Risiko::create([
            'nama_risiko' => 'Algoritma tiada disenaraikan dalam MySEAL',
            'sub_kategori_risiko_id' => $subCat2->id,
        ]);

        $risk3 = Risiko::create([
            'nama_risiko' => 'Private key disimpan dalam software sahaja',
            'sub_kategori_risiko_id' => $subCat3->id,
        ]);

        // Create Test Users (4 roles)

        // 1. Entiti User (from entity 1)
        User::create([
            'Jenis_Pengguna' => $jenisPenggunaEntiti,
            'ID_Agensi' => $entity1->id,
            'Kata_Laluan' => bcrypt('Test@123456'),
        ]);

        // 2. Ketua Sektor User (for sector 1)
        User::create([
            'Jenis_Pengguna' => $jenisPenggunaSektor,
            'ID_Agensi' => null,
            'Kata_Laluan' => bcrypt('Test@123456'),
        ]);

        // 3. Pengurusan User (Risk Management)
        User::create([
            'Jenis_Pengguna' => $jenisPengguna,
            'ID_Agensi' => null,
            'Kata_Laluan' => bcrypt('Test@123456'),
        ]);

        // 4. Admin User
        User::create([
            'Jenis_Pengguna' => $jenisPenggunaAdmin,
            'ID_Agensi' => null,
            'Kata_Laluan' => bcrypt('Test@123456'),
        ]);

        // Create Inventori (Assets)
        $asset1 = Inventori::create([
            'jenis_aset' => 'Sistem Informasi Perbankan',
            'nama_aset' => 'Core Banking System v2.5',
            'lokasi_pemilik' => 'Data Center Utama - Kuala Lumpur',
            'sistem_legasi' => 'Ya - Menggunakan teknologi lama yang memerlukan modernisasi',
            'catatan' => 'Sistem ini memproses transaksi keuangan utama dan menyimpan data sensitif pelanggan',
        ]);

        $asset2 = Inventori::create([
            'jenis_aset' => 'Platform Telegram Kesihatan',
            'nama_aset' => 'Health Communication Platform v1.0',
            'lokasi_pemilik' => 'Cloud Infrastructure - AWS Region ap-southeast-1',
            'sistem_legasi' => 'Tidak - Aplikasi modern berbasis cloud',
            'catatan' => 'Platform komunikasi untuk pesan kesihatan kepada pasien, menggunakan enkripsi end-to-end',
        ]);

        $asset3 = Inventori::create([
            'jenis_aset' => 'Database Aset Kriptografi',
            'nama_aset' => 'Centralized Crypto Asset Registry',
            'lokasi_pemilik' => 'On-premise Data Center - Petaling Jaya',
            'sistem_legasi' => 'Sebahagian - Migrasi sedang berlangsung',
            'catatan' => 'Menyimpan inventori lengkap semua komponen kriptografi yang digunakan di organisasi',
        ]);

        // Create SBOM (Software Bill of Materials) for each asset
        $sbom1 = SBOM::create([
            'inventori_id' => $asset1->id,
            'komponen_versi' => 'OpenSSL 1.1.1k, Java 11.0.12, Spring Boot 2.5.4',
            'sub_komponen' => 'EVP_PKEY, X509_VERIFY, MessageDigest',
            'url' => 'https://www.openssl.org/source/',
            'mod_perkhidmatan' => 'Production',
            'language_framework' => 'Java, Spring Framework',
            'modules_libraries' => 'javax.crypto, java.security, org.springframework.security',
            'external_apis_services' => 'Payment Gateway API, SMS Notification Service',
            'in_house_vendor' => 'Internal Development Team',
            'nama_vendor' => 'Bank Nasional Malaysia - IT Division',
            'kepakaran_kriptografi' => 'RSA-2048, AES-256, SHA-256, TLS 1.2',
        ]);

        $sbom2 = SBOM::create([
            'inventori_id' => $asset2->id,
            'komponen_versi' => 'Signal Protocol Library 0.16.0, Node.js 16.13.0, Express 4.17.1',
            'sub_komponen' => 'X3DH Key Exchange, Double Ratchet Algorithm, HKDF',
            'url' => 'https://github.com/signalapp/libsignal-node',
            'mod_perkhidmatan' => 'Production',
            'language_framework' => 'Node.js, Express.js',
            'modules_libraries' => 'signal-protocol, crypto, bcrypt',
            'external_apis_services' => 'Firebase Cloud Messaging, Twilio SMS',
            'in_house_vendor' => 'Cloud Team',
            'nama_vendor' => 'Institut Kanser Negara - IT Development',
            'kepakaran_kriptografi' => 'ECDH, AES-GCM, SHA-512, HKDF-SHA256',
        ]);

        $sbom3 = SBOM::create([
            'inventori_id' => $asset3->id,
            'komponen_versi' => 'PostgreSQL 13.5, pgcrypto extension, Python 3.9.7',
            'sub_komponen' => 'PL/pgSQL functions, Cryptographic Hash Functions, Key Derivation',
            'url' => 'https://www.postgresql.org/about/licence/',
            'mod_perkhidmatan' => 'Production',
            'language_framework' => 'PL/pgSQL, Python 3.9',
            'modules_libraries' => 'pgcrypto, cryptography, pycryptodome',
            'external_apis_services' => 'REST API Backend, LDAP for Authentication',
            'in_house_vendor' => 'Database Administration Team',
            'nama_vendor' => 'Quantum Risk Management Organization',
            'kepakaran_kriptografi' => 'RSA, ECDSA, MD5, SHA-1, SHA-256, SCRYPT',
        ]);

        // Create CBOM (Cryptographic Bill of Materials) for each SBOM
        $cbom1 = CBOM::create([
            'sbom_id' => $sbom1->id,
            'algoritma_kriptografi' => 'RSA-2048, AES-256, SHA-256',
            'panjang_kunci' => '2048-bit (RSA), 256-bit (AES)',
            'tujuan_penggunaan' => 'Enkripsi data transaksi, TLS komunikasi server, Hash integritas dokumen',
            'library_modules' => 'org.apache.commons.crypto, com.nimbusds.jose, io.jsonwebtoken',
            'kategori_data' => 'Financial Records, Customer PII, Transaction Logs',
            'sokongan_crypto_agility' => 'Partial - RSA dapat ditingkatkan ke 4096-bit, AES tetap kompatibel dengan panjang kunci berbeda',
        ]);

        $cbom2 = CBOM::create([
            'sbom_id' => $sbom2->id,
            'algoritma_kriptografi' => 'ECDH, AES-GCM, SHA-512, HKDF',
            'panjang_kunci' => '256-bit (ECDH/Curve25519), 256-bit (AES-GCM)',
            'tujuan_penggunaan' => 'End-to-end encryption untuk messaging, Secure key exchange, Authentication',
            'library_modules' => 'signal-protocol, node-crypto, libsodium bindings',
            'kategori_data' => 'Medical Messages, Health Records, User Authentication',
            'sokongan_crypto_agility' => 'High - Signal Protocol mendukung upgrade algoritma tanpa breaking changes',
        ]);

        $cbom3 = CBOM::create([
            'sbom_id' => $sbom3->id,
            'algoritma_kriptografi' => 'SCRYPT (key derivation), SHA-256 (hashing)',
            'panjang_kunci' => 'Variable - SCRYPT parameters: N=16384, r=8, p=1',
            'tujuan_penggunaan' => 'Password hashing untuk akses database, Integritas data kriptografi',
            'library_modules' => 'pgcrypto (crypt, digest), cryptography.hazmat.primitives',
            'kategori_data' => 'Cryptographic Component Registry, Key Metadata, Configuration Data',
            'sokongan_crypto_agility' => 'Medium - Dapat migrasi ke Argon2, namun memerlukan rehash semua password yang tersimpan',
        ]);

        // Create sample Risk Registers with actual CBOM IDs from the created records
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

        $this->command->info('Test data seeded successfully!');
        $this->command->info('Test Users:');
        $this->command->info('  Entiti User: ahmad.anwar@bnm.gov.my / Test@123456');
        $this->command->info('  Sector Head: dr.ahmad@sektor-keuangan.gov.my / Test@123456');
        $this->command->info('  Risk Manager: rashid.ibrahim@pengurusan.gov.my / Test@123456');
        $this->command->info('  Admin: admin@system.gov.my / Test@123456');
    }
}
