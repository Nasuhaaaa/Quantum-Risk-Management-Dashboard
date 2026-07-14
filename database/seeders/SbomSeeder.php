<?php

namespace Database\Seeders;

use App\Models\Inventori;
use App\Models\SBOM;
use Illuminate\Database\Seeder;

class SbomSeeder extends Seeder
{
    public function run(): void
    {
        $sbomData = [
            [
                'nama_aset' => 'Core Banking System v2.5',
                'komponen_versi' => 'OpenSSL 3.0.12, Java 17 LTS, Spring Boot 3.2.5',
                'sub_komponen' => 'EVP_PKEY, X509_VERIFY, MessageDigest, TLS Session',
                'url' => 'https://www.openssl.org/source/',
                'mod_perkhidmatan' => 'Production',
                'language_framework' => 'Java, Spring Framework, Hibernate',
                'modules_libraries' => 'javax.crypto, java.security, org.springframework.security, bouncycastle',
                'external_apis_services' => 'Payment Gateway API, SMS Notification Service, Core Banking Connector',
                'in_house_vendor' => 'Internal Development Team',
                'nama_vendor' => 'Bank Negara Malaysia - IT Division',
                'kepakaran_kriptografi' => 'Ya',
            ],
            [
                'nama_aset' => 'Health Communication Platform v1.0',
                'komponen_versi' => 'Signal Protocol Library 0.18.0, Node.js 20.11.1, Express 4.19.2',
                'sub_komponen' => 'X3DH Key Exchange, Double Ratchet Algorithm, HKDF',
                'url' => 'https://github.com/signalapp/libsignal-node',
                'mod_perkhidmatan' => 'Production',
                'language_framework' => 'Node.js, Express.js, React',
                'modules_libraries' => 'signal-protocol, crypto, bcrypt, jose',
                'external_apis_services' => 'Firebase Cloud Messaging, Twilio SMS, Azure AD B2C',
                'in_house_vendor' => 'Cloud Team',
                'nama_vendor' => 'Institut Kanser Negara - IT Development',
                'kepakaran_kriptografi' => 'Ya',
            ],
            [
                'nama_aset' => 'National Network Operations Center v3.1',
                'komponen_versi' => 'PostgreSQL 15.4, pgcrypto extension, Python 3.11.8',
                'sub_komponen' => 'PL/pgSQL functions, Cryptographic Hash Functions, Key Derivation',
                'url' => 'https://www.postgresql.org/about/licence/',
                'mod_perkhidmatan' => 'Production',
                'language_framework' => 'PL/pgSQL, Python 3.11',
                'modules_libraries' => 'pgcrypto, cryptography, pycryptodome',
                'external_apis_services' => 'REST API Backend, LDAP for Authentication, SIEM Integration',
                'in_house_vendor' => 'Database Administration Team',
                'nama_vendor' => 'Telekom Malaysia Berhad - Network Engineering',
                'kepakaran_kriptografi' => 'Ya',
            ],
            [
                'nama_aset' => 'Defence Mission Control System v4.0',
                'komponen_versi' => 'OpenSSL 3.0.8, Qt 6.5, C++17',
                'sub_komponen' => 'PKCS#11, Hardware Security Module Integration, Secure Session Manager',
                'url' => 'https://www.openssl.org/source/',
                'mod_perkhidmatan' => 'Production',
                'language_framework' => 'C++, Qt Framework',
                'modules_libraries' => 'openssl, pkcs11, protobuf',
                'external_apis_services' => 'Secure Messaging Gateway, Satellite Link Service',
                'in_house_vendor' => 'Defence Engineering Division',
                'nama_vendor' => 'Kementerian Pertahanan Malaysia - R&D',
                'kepakaran_kriptografi' => 'Ya',
            ],
        ];

        foreach ($sbomData as $item) {
            $asset = Inventori::where('nama_aset', $item['nama_aset'])->first();

            if (!$asset) {
                continue;
            }

            SBOM::firstOrCreate(
                ['inventori_id' => $asset->id],
                [
                    'inventori_id' => $asset->id,
                    'komponen_versi' => $item['komponen_versi'],
                    'sub_komponen' => $item['sub_komponen'],
                    'url' => $item['url'],
                    'mod_perkhidmatan' => $item['mod_perkhidmatan'],
                    'language_framework' => $item['language_framework'],
                    'modules_libraries' => $item['modules_libraries'],
                    'external_apis_services' => $item['external_apis_services'],
                    'in_house_vendor' => $item['in_house_vendor'],
                    'nama_vendor' => $item['nama_vendor'],
                    'kepakaran_kriptografi' => $item['kepakaran_kriptografi'],
                ]
            );
        }

        $this->command->info('SBOM seeded successfully!');
    }
}
