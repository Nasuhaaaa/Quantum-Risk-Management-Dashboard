<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Inventori;
use App\Models\Agensi;

class InventoriSeeder extends Seeder
{
    public function run(): void
    {
        $entity1 = Agensi::where('nama_agensi', 'Bank Nasional Malaysia')->first();
        $entity2 = Agensi::where('nama_agensi', 'Institut Kanser Negara')->first();
        $entity3 = Agensi::where('nama_agensi', 'Bank Negara Malaysia')->first();

        Inventori::create([
            'agensi_id' => $entity1->id,
            'jenis_aset' => 'Sistem Informasi Perbankan',
            'nama_aset' => 'Core Banking System v2.5',
            'lokasi_pemilik' => 'Data Center Utama - Kuala Lumpur',
            'sistem_legasi' => 'Ya - Menggunakan teknologi lama yang memerlukan modernisasi',
            'catatan' => 'Sistem ini memproses transaksi keuangan utama dan menyimpan data sensitif pelanggan',
        ]);

        Inventori::create([
            'agensi_id' => $entity2->id,
            'jenis_aset' => 'Platform Telegram Kesihatan',
            'nama_aset' => 'Health Communication Platform v1.0',
            'lokasi_pemilik' => 'Cloud Infrastructure - AWS Region ap-southeast-1',
            'sistem_legasi' => 'Tidak - Aplikasi modern berbasis cloud',
            'catatan' => 'Platform komunikasi untuk pesan kesihatan kepada pasien, menggunakan enkripsi end-to-end',
        ]);

        Inventori::create([
            'agensi_id' => $entity3->id,
            'jenis_aset' => 'Database Aset Kriptografi',
            'nama_aset' => 'Centralized Crypto Asset Registry',
            'lokasi_pemilik' => 'On-premise Data Center - Petaling Jaya',
            'sistem_legasi' => 'Sebahagian - Migrasi sedang berlangsung',
            'catatan' => 'Menyimpan inventori lengkap semua komponen kriptografi yang digunakan di organisasi',
        ]);

        $this->command->info('Inventori seeded successfully!');
    }
}
