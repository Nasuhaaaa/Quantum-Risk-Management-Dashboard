<?php

namespace Database\Seeders;

use App\Models\Agensi;
use App\Models\Sektor;
use Illuminate\Database\Seeder;

class AgensiSeeder extends Seeder
{
    public function run(): void
    {
        $sectors = [
            'Kewangan dan Perbankan' => Sektor::where('nama_sektor', 'Kewangan dan Perbankan')->first(),
            'Kesihatan' => Sektor::where('nama_sektor', 'Kesihatan')->first(),
            'Telekomunikasi dan Digital' => Sektor::where('nama_sektor', 'Telekomunikasi dan Digital')->first(),
            'Pertahanan dan Keselamatan' => Sektor::where('nama_sektor', 'Pertahanan dan Keselamatan')->first(),
            'Pengangkutan dan Logistik' => Sektor::where('nama_sektor', 'Pengangkutan dan Logistik')->first(),
            'Kerajaan dan Pentadbiran Awam' => Sektor::where('nama_sektor', 'Kerajaan dan Pentadbiran Awam')->first(),
            'Pendidikan' => Sektor::where('nama_sektor', 'Pendidikan')->first(),
            'Tenaga dan Utiliti' => Sektor::where('nama_sektor', 'Tenaga dan Utiliti')->first(),
            'Air dan Sanitasi' => Sektor::where('nama_sektor', 'Air dan Sanitasi')->first(),
        ];

        $agencies = [
            [
                'nama_agensi' => 'Bank Negara Malaysia',
                'sektor_name' => 'Kewangan dan Perbankan',
                'no_tel_agensi' => '03-8888-5001',
                'website' => 'https://www.bnm.gov.my',
                'nama_pic' => 'Datuk Abdul Rasheed Ghaffour',
                'no_tel_pic' => '03-8888-5002',
                'emel_pic' => 'governance@bnm.gov.my',
                'jenis_perniagaan_perhubungan' => 'Bank Pusat',
            ],
            [
                'nama_agensi' => 'Bank Simpanan Nasional',
                'sektor_name' => 'Kewangan dan Perbankan',
                'no_tel_agensi' => '03-2614-5001',
                'website' => 'https://www.bsn.com.my',
                'nama_pic' => 'En. Mohd Shahril Bin Mohamed',
                'no_tel_pic' => '03-2614-5002',
                'emel_pic' => 'risk@bsn.com.my',
                'jenis_perniagaan_perhubungan' => 'Bank Pembangunan',
            ],
            [
                'nama_agensi' => 'Institut Kanser Negara',
                'sektor_name' => 'Kesihatan',
                'no_tel_agensi' => '03-8892-5001',
                'website' => 'https://www.ikn.gov.my',
                'nama_pic' => 'Dr. Mohd Azman Bin Ahmad',
                'no_tel_pic' => '03-8892-5002',
                'emel_pic' => 'ciso@ikn.gov.my',
                'jenis_perniagaan_perhubungan' => 'Pusat Rujukan Kesihatan',
            ],
            [
                'nama_agensi' => 'Telekom Malaysia Berhad',
                'sektor_name' => 'Telekomunikasi dan Digital',
                'no_tel_agensi' => '03-2244-5001',
                'website' => 'https://www.tm.com.my',
                'nama_pic' => 'Pn. Siti Norliza Binti Hamid',
                'no_tel_pic' => '03-2244-5002',
                'emel_pic' => 'security@tm.com.my',
                'jenis_perniagaan_perhubungan' => 'Penyedia Telekomunikasi',
            ],
            [
                'nama_agensi' => 'MIMOS Berhad',
                'sektor_name' => 'Telekomunikasi dan Digital',
                'no_tel_agensi' => '03-8995-5001',
                'website' => 'https://www.mimos.my',
                'nama_pic' => 'Dr. Noor Azlina Binti Yusof',
                'no_tel_pic' => '03-8995-5002',
                'emel_pic' => 'ciso@mimos.my',
                'jenis_perniagaan_perhubungan' => 'Pusat Penyelidikan Teknologi',
            ],
            [
                'nama_agensi' => 'Kementerian Pertahanan Malaysia',
                'sektor_name' => 'Pertahanan dan Keselamatan',
                'no_tel_agensi' => '03-2070-5001',
                'website' => 'https://www.mod.gov.my',
                'nama_pic' => 'Lt. Kol. Mohd Faizal Bin Hassan',
                'no_tel_pic' => '03-2070-5002',
                'emel_pic' => 'ciso@mod.gov.my',
                'jenis_perniagaan_perhubungan' => 'Agensi Kerajaan',
            ],
            [
                'nama_agensi' => 'Malaysia Airlines Berhad',
                'sektor_name' => 'Pengangkutan dan Logistik',
                'no_tel_agensi' => '03-7843-5001',
                'website' => 'https://www.malaysiaairlines.com',
                'nama_pic' => 'En. Azlan Bin Othman',
                'no_tel_pic' => '03-7843-5002',
                'emel_pic' => 'risk@malaysiaairlines.com',
                'jenis_perniagaan_perhubungan' => 'Syarikat Penerbangan',
            ],
            [
                'nama_agensi' => 'Jabatan Perdana Menteri',
                'sektor_name' => 'Kerajaan dan Pentadbiran Awam',
                'no_tel_agensi' => '03-8888-5003',
                'website' => 'https://www.pmo.gov.my',
                'nama_pic' => 'Pn. Rosmawati Binti Hashim',
                'no_tel_pic' => '03-8888-5004',
                'emel_pic' => 'security@pmo.gov.my',
                'jenis_perniagaan_perhubungan' => 'Agensi Kerajaan',
            ],
            [
                'nama_agensi' => 'Tenaga Nasional Berhad',
                'sektor_name' => 'Tenaga dan Utiliti',
                'no_tel_agensi' => '03-2264-5001',
                'website' => 'https://www.tnb.com.my',
                'nama_pic' => 'En. Zulhakim Bin Ismail',
                'no_tel_pic' => '03-2264-5002',
                'emel_pic' => 'ciso@tnb.com.my',
                'jenis_perniagaan_perhubungan' => 'Syarikat Tenaga',
            ],
            [
                'nama_agensi' => 'Syarikat Air Selangor',
                'sektor_name' => 'Air dan Sanitasi',
                'no_tel_agensi' => '03-5123-5001',
                'website' => 'https://www.syabas.com.my',
                'nama_pic' => 'Pn. Siti Norshahida Binti Aziz',
                'no_tel_pic' => '03-5123-5002',
                'emel_pic' => 'ciso@syabas.com.my',
                'jenis_perniagaan_perhubungan' => 'Syarikat Air',
            ],
        ];

        foreach ($agencies as $agencyData) {
            $sector = $sectors[$agencyData['sektor_name']] ?? null;

            if (!$sector) {
                continue;
            }

            Agensi::firstOrCreate(
                ['nama_agensi' => $agencyData['nama_agensi']],
                [
                    'sektor_id' => $sector->id,
                    'no_tel_agensi' => $agencyData['no_tel_agensi'],
                    'website' => $agencyData['website'],
                    'nama_pic' => $agencyData['nama_pic'],
                    'no_tel_pic' => $agencyData['no_tel_pic'],
                    'emel_pic' => $agencyData['emel_pic'],
                    'jenis_perniagaan_perhubungan' => $agencyData['jenis_perniagaan_perhubungan'],
                ]
            );
        }

        $this->command->info('Agensi seeded successfully!');
    }
}
