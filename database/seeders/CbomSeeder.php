<?php

namespace Database\Seeders;

use App\Models\CBOM;
use App\Models\SBOM;
use Illuminate\Database\Seeder;

class CbomSeeder extends Seeder
{
    public function run(): void
    {
        $cbomData = [
            [
                'nama_aset' => 'Core Banking System v2.5',
                'algoritma_kriptografi' => 'RSA-2048, AES-256, SHA-256, TLS 1.3',
                'panjang_kunci' => '2048-bit (RSA), 256-bit (AES)',
                'tujuan_penggunaan' => 'Enkripsi data transaksi, TLS komunikasi server, hash integriti dokumen, pengesahan token pelanggan',
                'library_modules' => 'org.apache.commons.crypto, com.nimbusds.jose, io.jsonwebtoken, bouncycastle',
                'kategori_data' => 'Rekod Kewangan, PII Pelanggan, Log Transaksi',
                'sokongan_crypto_agility' => 'Sederhana - RSA boleh dinaik taraf ke 4096-bit dan AES serasi dengan panjang kunci yang berbeza',
            ],
            [
                'nama_aset' => 'Health Communication Platform v1.0',
                'algoritma_kriptografi' => 'ECDH, AES-GCM, SHA-512, HKDF',
                'panjang_kunci' => '256-bit (ECDH/Curve25519), 256-bit (AES-GCM)',
                'tujuan_penggunaan' => 'Enkripsi hujung-ke-hujung, pertukaran kunci selamat, pengesahan pengguna dan notifikasi',
                'library_modules' => 'signal-protocol, node-crypto, libsodium bindings, jose',
                'kategori_data' => 'Mesej Kesihatan, Rekod Kesihatan, Pengesahan Pengguna',
                'sokongan_crypto_agility' => 'Tinggi - protokol boleh dikemas kini tanpa perubahan besar pada arsitektur',
            ],
            [
                'nama_aset' => 'National Network Operations Center v3.1',
                'algoritma_kriptografi' => 'RSA, ECDSA, SHA-256, SCRYPT',
                'panjang_kunci' => '2048-bit (RSA), 256-bit (ECDSA), pembolehubah untuk SCRYPT',
                'tujuan_penggunaan' => 'Pengesahan identiti, hashing kata laluan, integriti data dan penyulitan konfigurasi',
                'library_modules' => 'pgcrypto (crypt, digest), cryptography.hazmat.primitives, pycryptodome',
                'kategori_data' => 'Rekod Rangkaian, Metadata Kunci, Data Konfigurasi',
                'sokongan_crypto_agility' => 'Sederhana - boleh dipindahkan ke Argon2 dengan semakan semula data yang disimpan',
            ],
            [
                'nama_aset' => 'Defence Mission Control System v4.0',
                'algoritma_kriptografi' => 'AES-256, HMAC-SHA256, ECDSA, ECC',
                'panjang_kunci' => '256-bit (AES), 256-bit (ECC)',
                'tujuan_penggunaan' => 'Perlindungan mesej sensitif, pengesahan peranti dan pengurusan kunci keselamatan',
                'library_modules' => 'openssl, pkcs11, protobuf, libsodium',
                'kategori_data' => 'Mesej Misi, Kunci Keselamatan, Data Operasi',
                'sokongan_crypto_agility' => 'Tinggi - sokongan modul HSM dan algoritma yang boleh dikemas kini',
            ],
        ];

        foreach ($cbomData as $item) {
            $sbom = SBOM::whereHas('inventori', function ($query) use ($item) {
                $query->where('nama_aset', $item['nama_aset']);
            })->first();

            if (!$sbom) {
                continue;
            }

            CBOM::firstOrCreate(
                ['sbom_id' => $sbom->id],
                [
                    'sbom_id' => $sbom->id,
                    'algoritma_kriptografi' => $item['algoritma_kriptografi'],
                    'panjang_kunci' => $item['panjang_kunci'],
                    'tujuan_penggunaan' => $item['tujuan_penggunaan'],
                    'library_modules' => $item['library_modules'],
                    'kategori_data' => $item['kategori_data'],
                    'sokongan_crypto_agility' => $item['sokongan_crypto_agility'],
                ]
            );
        }

        $this->command->info('CBOM seeded successfully!');
    }
}
