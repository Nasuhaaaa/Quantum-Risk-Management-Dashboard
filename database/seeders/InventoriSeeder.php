<?php

namespace Database\Seeders;

use App\Models\Agensi;
use App\Models\Inventori;
use Illuminate\Database\Seeder;

class InventoriSeeder extends Seeder
{
    public function run(): void
    {
        $assets = [
            [
                'nama_agensi' => 'Bank Negara Malaysia',
                'jenis_aset' => 'Sistem Perbankan Teras',
                'nama_aset' => 'Core Banking System v2.5',
                'lokasi_pemilik' => 'Data Center Utama - Kuala Lumpur',
                'sistem_legasi' => 'Ya - Menggunakan teknologi lama yang memerlukan modernisasi',
                'catatan' => 'Sistem ini memproses transaksi keuangan utama dan menyimpan data sensitif pelanggan.',
            ],
            [
                'nama_agensi' => 'Institut Kanser Negara',
                'jenis_aset' => 'Platform Komunikasi Kesihatan',
                'nama_aset' => 'Health Communication Platform v1.0',
                'lokasi_pemilik' => 'Cloud Infrastructure - AWS Region ap-southeast-1',
                'sistem_legasi' => 'Tidak - Aplikasi modern berasaskan cloud',
                'catatan' => 'Platform komunikasi untuk pesanan dan notifikasi kesihatan, menggunakan enkripsi end-to-end.',
            ],
            [
                'nama_agensi' => 'Telekom Malaysia Berhad',
                'jenis_aset' => 'Pusat Data dan Rangkaian',
                'nama_aset' => 'National Network Operations Center v3.1',
                'lokasi_pemilik' => 'Pusat Data Cyberjaya',
                'sistem_legasi' => 'Sebahagian - Migrasi sedang berlangsung',
                'catatan' => 'Mengurus jaringan nasional, pusat data dan infrastruktur komunikasi kritikal.',
            ],
            [
                'nama_agensi' => 'Kementerian Pertahanan Malaysia',
                'jenis_aset' => 'Sistem Operasi Pertahanan',
                'nama_aset' => 'Defence Mission Control System v4.0',
                'lokasi_pemilik' => 'Pusat Operasi Pertahanan - Kuala Lumpur',
                'sistem_legasi' => 'Ya - Beberapa modul masih bergantung pada infrastruktur lama',
                'catatan' => 'Sistem operasi pertahanan yang menyokong pemantauan dan komunikasi misi kritikal.',
            ],

        ];

        foreach ($assets as $asset) {
            $agency = Agensi::where('nama_agensi', $asset['nama_agensi'])->first();

            if (!$agency) {
                continue;
            }

            Inventori::firstOrCreate(
                ['nama_aset' => $asset['nama_aset']],
                [
                    'agensi_id' => $agency->id,
                    'jenis_aset' => $asset['jenis_aset'],
                    'nama_aset' => $asset['nama_aset'],
                    'lokasi_pemilik' => $asset['lokasi_pemilik'],
                    'sistem_legasi' => $asset['sistem_legasi'],
                    'catatan' => $asset['catatan'],
                ]
            );
        }

        $this->command->info('Inventori seeded successfully!');
    }
}
