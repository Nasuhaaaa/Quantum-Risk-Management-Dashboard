<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\SBOM;
use App\Models\Inventori;

class SbomSeeder extends Seeder
{
    public function run(): void
    {
        $asset1 = Inventori::where('nama_aset', 'Core Banking System v2.5')->first();
        $asset2 = Inventori::where('nama_aset', 'Health Communication Platform v1.0')->first();
        $asset3 = Inventori::where('nama_aset', 'Centralized Crypto Asset Registry')->first();

        SBOM::create([
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

        SBOM::create([
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

        SBOM::create([
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

        $this->command->info('SBOM seeded successfully!');
    }
}
