<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\CBOM;
use App\Models\SBOM;

class CbomSeeder extends Seeder
{
    public function run(): void
    {
        $sbom1 = SBOM::where('kepakaran_kriptografi', 'RSA-2048, AES-256, SHA-256, TLS 1.2')->first();
        $sbom2 = SBOM::where('kepakaran_kriptografi', 'ECDH, AES-GCM, SHA-512, HKDF-SHA256')->first();
        $sbom3 = SBOM::where('kepakaran_kriptografi', 'RSA, ECDSA, MD5, SHA-1, SHA-256, SCRYPT')->first();

        CBOM::create([
            'sbom_id' => $sbom1->id,
            'algoritma_kriptografi' => 'RSA-2048, AES-256, SHA-256',
            'panjang_kunci' => '2048-bit (RSA), 256-bit (AES)',
            'tujuan_penggunaan' => 'Enkripsi data transaksi, TLS komunikasi server, Hash integritas dokumen',
            'library_modules' => 'org.apache.commons.crypto, com.nimbusds.jose, io.jsonwebtoken',
            'kategori_data' => 'Financial Records, Customer PII, Transaction Logs',
            'sokongan_crypto_agility' => 'Partial - RSA dapat ditingkatkan ke 4096-bit, AES tetap kompatibel dengan panjang kunci berbeda',
        ]);

        CBOM::create([
            'sbom_id' => $sbom2->id,
            'algoritma_kriptografi' => 'ECDH, AES-GCM, SHA-512, HKDF',
            'panjang_kunci' => '256-bit (ECDH/Curve25519), 256-bit (AES-GCM)',
            'tujuan_penggunaan' => 'End-to-end encryption untuk messaging, Secure key exchange, Authentication',
            'library_modules' => 'signal-protocol, node-crypto, libsodium bindings',
            'kategori_data' => 'Medical Messages, Health Records, User Authentication',
            'sokongan_crypto_agility' => 'High - Signal Protocol mendukung upgrade algoritma tanpa breaking changes',
        ]);

        CBOM::create([
            'sbom_id' => $sbom3->id,
            'algoritma_kriptografi' => 'SCRYPT (key derivation), SHA-256 (hashing)',
            'panjang_kunci' => 'Variable - SCRYPT parameters: N=16384, r=8, p=1',
            'tujuan_penggunaan' => 'Password hashing untuk akses database, Integritas data kriptografi',
            'library_modules' => 'pgcrypto (crypt, digest), cryptography.hazmat.primitives',
            'kategori_data' => 'Cryptographic Component Registry, Key Metadata, Configuration Data',
            'sokongan_crypto_agility' => 'Medium - Dapat migrasi ke Argon2, namun memerlukan rehash semua password yang tersimpan',
        ]);

        $this->command->info('CBOM seeded successfully!');
    }
}
