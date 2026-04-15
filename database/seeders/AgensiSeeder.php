<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Agensi;
use App\Models\Sektor;

class AgensiSeeder extends Seeder
{
    public function run(): void
    {
        $sector1 = Sektor::where('nama_sektor', 'Kewangan')->first();
        $sector2 = Sektor::where('nama_sektor', 'Kesihatan')->first();

        Agensi::create([
            'nama_agensi' => 'Bank Nasional Malaysia',
            'sektor_id' => $sector1->id,
            'no_tel_agensi' => '60-3-2000-0000',
            'website' => 'www.bnm.gov.my',
            'nama_pic' => 'Datuk Seri Tan Sri Ahmad',
            'no_tel_pic' => '60-3-2000-0001',
            'emel_pic' => 'datuk@bnm.gov.my',
            'jenis_perniagaan_perhubungan' => 'Bank Sentral',
        ]);

        Agensi::create([
            'nama_agensi' => 'Institut Kanser Negara',
            'sektor_id' => $sector2->id,
            'no_tel_agensi' => '60-3-3000-0000',
            'website' => 'www.ikn.gov.my',
            'nama_pic' => 'Encik Mohamed Bin Abdullah',
            'no_tel_pic' => '60-3-3000-0001',
            'emel_pic' => 'encik@ikn.gov.my',
            'jenis_perniagaan_perhubungan' => 'Pusat Rujukan Khusus Pesakit Kanser',
        ]);

        Agensi::create([
            'nama_agensi' => 'Bank Negara Malaysia',
            'sektor_id' => $sector1->id,
            'no_tel_agensi' => '60-3-4000-0000',
            'website' => 'www.bnm.gov.my',
            'nama_pic' => 'Tan Sri Wan Zulkiflee Wan Ariffin',
            'no_tel_pic' => '60-3-4000-0001',
            'emel_pic' => 'wanzulkiflee@bnm.gov.my',
            'jenis_perniagaan_perhubungan' => 'Perbadanan Minyak & Gas',
        ]);

        $this->command->info('Agensi seeded successfully!');
    }
}
