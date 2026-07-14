<?php

namespace Database\Seeders;

use App\Models\Sektor;
use Illuminate\Database\Seeder;

class SektorSeeder extends Seeder
{
    public function run(): void
    {
        $sectors = [
            [
                'nama_sektor' => 'Kewangan dan Perbankan',
                'ketua_sektor' => 'Pn. Aisyah Binti Rahman',
                'keterangan_sektor' => 'Sektor kritikal NCII yang meliputi perbankan, insurans dan pembayaran digital.',
                'maklumat_perhubungan_sektor' => 'aisyah.rahman@example.com | 03-8888-1001',
            ],
            [
                'nama_sektor' => 'Kesihatan',
                'ketua_sektor' => 'Dr. Hafizah Binti Yusof',
                'keterangan_sektor' => 'Sektor kesihatan kritikal untuk penjagaan pesakit, hospital dan sistem penjagaan kesihatan.',
                'maklumat_perhubungan_sektor' => 'hafizah.yusof@example.com | 03-8888-1002',
            ],
            [
                'nama_sektor' => 'Pendidikan Tinggi',
                'ketua_sektor' => 'Prof. Madya Mohd Razif Bin Ismail',
                'keterangan_sektor' => 'Institusi pendidikan tinggi yang menyokong ekosistem ilmu, data dan operasi kritikal.',
                'maklumat_perhubungan_sektor' => 'razif.ismail@example.com | 03-8888-1003',
            ],
            [
                'nama_sektor' => 'Pertahanan dan Keselamatan',
                'ketua_sektor' => 'Kol. Ahmad Faiz Bin Salleh',
                'keterangan_sektor' => 'Sektor pertahanan dan keselamatan berasaskan infrastruktur kritikal negara.',
                'maklumat_perhubungan_sektor' => 'ahmad.faiz@example.com | 03-8888-1004',
            ],
            [
                'nama_sektor' => 'Pengangkutan dan Logistik',
                'ketua_sektor' => 'En. Mior Azlan Bin Mior Hamzah',
                'keterangan_sektor' => 'Sektor pengangkutan, logistik dan rantaian bekalan yang kritikal kepada operasi negara.',
                'maklumat_perhubungan_sektor' => 'mior.azlan@example.com | 03-8888-1005',
            ],
            [
                'nama_sektor' => 'Telekomunikasi dan Digital',
                'ketua_sektor' => 'Pn. Nur Aina Binti Rahman',
                'keterangan_sektor' => 'Sektor komunikasi, data centre dan infrastruktur digital yang menyokong perkhidmatan awam.',
                'maklumat_perhubungan_sektor' => 'aina.rahman@example.com | 03-8888-1006',
            ],
            [
                'nama_sektor' => 'Tenaga dan Utiliti',
                'ketua_sektor' => 'En. Zulhakim Bin Ismail',
                'keterangan_sektor' => 'Sektor elektrik, gas dan utiliti yang menyokong operasi kritikal dan keselamatan negara.',
                'maklumat_perhubungan_sektor' => 'zulhakim.ismail@example.com | 03-8888-1007',
            ],
            [
                'nama_sektor' => 'Air dan Sanitasi',
                'ketua_sektor' => 'Pn. Siti Norshahida Binti Aziz',
                'keterangan_sektor' => 'Sektor air, sanitasi dan infrastruktur perkhidmatan awam yang kritikal.',
                'maklumat_perhubungan_sektor' => 'shahida.aziz@example.com | 03-8888-1008',
            ],
            [
                'nama_sektor' => 'Kerajaan dan Pentadbiran Awam',
                'ketua_sektor' => 'Pn. Rosmawati Binti Hashim',
                'keterangan_sektor' => 'Sektor kerajaan dan agensi awam yang mengurus perkhidmatan kritikal negara.',
                'maklumat_perhubungan_sektor' => 'rosmawati.hashim@example.com | 03-8888-1009',
            ],
            [
                'nama_sektor' => 'Industri dan Pembuatan Kritikal',
                'ketua_sektor' => 'En. Shahrul Nizam Bin Ahmad',
                'keterangan_sektor' => 'Sektor industri, pembuatan dan rantaian bekalan kritikal kepada ekonomi negara.',
                'maklumat_perhubungan_sektor' => 'shahrul.nizam@example.com | 03-8888-1010',
            ],
        ];

        foreach ($sectors as $sector) {
            Sektor::firstOrCreate(
                ['nama_sektor' => $sector['nama_sektor']],
                $sector
            );
        }

        $this->command->info('Sektor seeded successfully!');
    }
}
