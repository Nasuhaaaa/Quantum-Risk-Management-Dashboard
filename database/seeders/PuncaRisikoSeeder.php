<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\PuncaRisiko;
use App\Models\KategoriPuncaRisiko;

class PuncaRisikoSeeder extends Seeder
{
    public function run(): void
    {
        $this->seedCategory1();
        $this->seedCategory2();
        $this->seedCategory3();
        $this->seedCategory4();
        $this->seedCategory5();
        $this->seedCategory6();
        $this->seedCategory7();
        $this->seedCategory8();
        $this->seedCategory9();
        $this->seedCategory10();
        $this->seedCategory11();
        $this->seedCategory12();

        $this->command->info('PuncaRisiko seeded successfully!');
    }

    private function seedCategory1()
    {
        $cat = KategoriPuncaRisiko::where('kategori_punca_risiko', 'Ancaman Strategik Kuantum')->first();
        if (!$cat) return;

        $data = [
            ['punca' => 'Pelaksanaan komputer kuantum relevan terhadap kriptografi (CRQC) menjelang 2030', 'pelan' => 'Bangunkan pelan migrasi PQC nasional, laksanakan inventori kripto, dan tetapkan garis masa peralihan algoritma.'],
            ['punca' => 'Algoritma legasi tidak lagi selamat terhadap serangan kuantum', 'pelan' => 'Kenal pasti penggunaan algoritma legasi, rancang penggantian kepada algoritma tahan-kuantum, dan kuatkuasakan polisi larangan penggunaan baharu.'],
            ['punca' => 'Ketergantungan kepada fungsi cincang terdedah kepada algoritma BHT', 'pelan' => 'Nilai penggunaan hash sedia ada, tingkatkan kepada SHA-2/3 yang sesuai, dan rancang mitigasi panjang kunci serta penggunaan skema PQC.'],
            ['punca' => 'Penyimpanan data jangka panjang terdedah kepada Harvest Now Decrypt Later', 'pelan' => 'Klasifikasikan data jangka panjang, guna penyulitan kuat/PQC untuk data sensitif, dan hadkan tempoh penyimpanan serta lindungi arkib.'],
        ];

        foreach ($data as $item) {
            PuncaRisiko::firstOrCreate([
                'punca_risiko' => $item['punca'],
                'kategori_punca_risiko_id' => $cat->id,
                'pelan_mitigasi' => $item['pelan'],
            ]);
        }
    }

    private function seedCategory2()
    {
        $cat = KategoriPuncaRisiko::where('kategori_punca_risiko', 'Jaminan Algoritma')->first();
        if (!$cat) return;

        $data = [
            ['punca' => 'Penggunaan skim berasaskan kata laluan sahaja', 'pelan' => 'Perkenalkan MFA atau mekanisme berasaskan sijil/kunci, kuatkan derivasi kata laluan, dan hadkan penggunaan password sahaja.'],
            ['punca' => 'Sijil digital menggunakan algoritma terancam (RSA/ECC)', 'pelan' => 'Audit semua sijil, rancang peralihan kepada algoritma moden/PQC, dan tetapkan tarikh henti penggunaan algoritma lemah.'],
        ];

        foreach ($data as $item) {
            PuncaRisiko::firstOrCreate([
                'punca_risiko' => $item['punca'],
                'kategori_punca_risiko_id' => $cat->id,
                'pelan_mitigasi' => $item['pelan'],
            ]);
        }
    }

    private function seedCategory3()
    {
        $cat = KategoriPuncaRisiko::where('kategori_punca_risiko', 'Kawalan Akses Kripto')->first();
        if (!$cat) return;

        $data = [
            ['punca' => 'Kelemahan kawalan akses kepada material kunci', 'pelan' => 'Hadkan akses berdasarkan peranan, guna HSM atau peti simpanan kunci selamat, dan rekod semua akses.'],
            ['punca' => 'Akses berlebihan kepada material kriptografi', 'pelan' => 'Laksanakan prinsip keistimewaan minimum, semak akses secara berkala, dan hapus akses tidak perlu.'],
        ];

        foreach ($data as $item) {
            PuncaRisiko::firstOrCreate([
                'punca_risiko' => $item['punca'],
                'kategori_punca_risiko_id' => $cat->id,
                'pelan_mitigasi' => $item['pelan'],
            ]);
        }
    }

    private function seedCategory4()
    {
        $cat = KategoriPuncaRisiko::where('kategori_punca_risiko', 'Kelemahan Implementasi')->first();
        if (!$cat) return;

        $data = [
            ['punca' => 'Kesilapan konfigurasi oleh pentadbir sistem', 'pelan' => 'Guna konfigurasi automatik/templat piawai, jalankan semakan rakan setara, dan audit konfigurasi berkala.'],
            ['punca' => 'Penggunaan perpustakaan kriptografi yang lapuk', 'pelan' => 'Pantau versi perpustakaan, kemas kini secara berkala, dan gunakan sumber rasmi yang disokong.'],
            ['punca' => 'Kunci berkod keras dalam aplikasi', 'pelan' => 'Alihkan kunci ke stor rahsia selamat, guna pengurusan rahsia berpusat, dan ubah kod aplikasi.'],
            ['punca' => 'Penggunaan RNG yang lemah', 'pelan' => 'Guna RNG kriptografi yang disahkan, semak konfigurasi sistem, dan uji kualiti nombor rawak.'],
            ['punca' => 'Ketiadaan perlindungan terhadap serangan saluran sisi', 'pelan' => 'Gunakan modul kripto diperakui, lindungi peranti fizikal, dan aktifkan mitigasi side-channel jika tersedia.'],
        ];

        foreach ($data as $item) {
            PuncaRisiko::firstOrCreate([
                'punca_risiko' => $item['punca'],
                'kategori_punca_risiko_id' => $cat->id,
                'pelan_mitigasi' => $item['pelan'],
            ]);
        }
    }

    private function seedCategory5()
    {
        $cat = KategoriPuncaRisiko::where('kategori_punca_risiko', 'Keterlihatan Aset Kriptografi')->first();
        if (!$cat) return;

        $data = [
            ['punca' => 'Ketiadaan inventori aset kriptografi', 'pelan' => 'Laksanakan penemuan aset kripto automatik (CBOM), bina repositori pusat, dan kemas kini secara berkala.'],
            ['punca' => 'Konfigurasi kriptografi tidak konsisten merentas sistem', 'pelan' => 'Tetapkan baseline konfigurasi kripto organisasi, guna templat piawai, dan jalankan audit pematuhan berkala.'],
            ['punca' => 'Kurang dokumentasi seni bina kriptografi', 'pelan' => 'Dokumentasikan seni bina kripto semasa, lukis rajah aliran kunci/data, dan simpan dalam repositori pusat.'],
            ['punca' => 'Bayangan IT menggunakan kripto tidak diluluskan', 'pelan' => 'Laksanakan dasar kawalan perisian, imbas rangkaian untuk Shadow IT, dan kuatkuasakan kelulusan pusat.'],
            ['punca' => 'Ketiadaan pemetaan kebergantungan kriptografi', 'pelan' => 'Petakan semua kebergantungan kripto dalam aplikasi/sistem dan kemas kini secara berkala.'],
        ];

        foreach ($data as $item) {
            PuncaRisiko::firstOrCreate([
                'punca_risiko' => $item['punca'],
                'kategori_punca_risiko_id' => $cat->id,
                'pelan_mitigasi' => $item['pelan'],
            ]);
        }
    }

    private function seedCategory6()
    {
        $cat = KategoriPuncaRisiko::where('kategori_punca_risiko', 'Keupayaan & Sumber Manusia')->first();
        if (!$cat) return;

        $data = [
            ['punca' => 'Kurang kepakaran dalaman berkaitan PQC', 'pelan' => 'Laksanakan latihan PQC, bangunkan program pensijilan dalaman, dan libatkan pakar luar untuk pemindahan ilmu.'],
            ['punca' => 'Kakitangan teknikal tidak mahir ketangkasan kripto', 'pelan' => 'Sediakan latihan teknikal khusus, bengkel hands-on, dan garis panduan pembangunan selamat.'],
            ['punca' => 'Ketergantungan kepada individu utama', 'pelan' => 'Laksanakan pelan penggantian, dokumentasi pengetahuan, dan pengagihan tugas kepada lebih seorang pegawai.'],
        ];

        foreach ($data as $item) {
            PuncaRisiko::firstOrCreate([
                'punca_risiko' => $item['punca'],
                'kategori_punca_risiko_id' => $cat->id,
                'pelan_mitigasi' => $item['pelan'],
            ]);
        }
    }

    private function seedCategory7()
    {
        $cat = KategoriPuncaRisiko::where('kategori_punca_risiko', 'Migrasi PQC & Ketangkasan Kripto')->first();
        if (!$cat) return;

        $data = [
            ['punca' => 'Vendor atau sistem pihak ketiga belum Sedia-PQC (PQC-ready)', 'pelan' => 'Masukkan keperluan PQC dalam kontrak/vendor assessment, laksanakan pelan peralihan vendor, dan uji keserasian awal.'],
            ['punca' => 'Kelewatan pelan hala tuju migrasi kriptografi organisasi', 'pelan' => 'Sediakan roadmap rasmi dengan milestone, tetapkan pemilik projek, dan pantau kemajuan melalui jawatankuasa tadbir urus.'],
            ['punca' => 'Integrasi sistem legasi menyukarkan penggantian algoritma', 'pelan' => 'Kenal pasti sistem legasi kritikal, bina lapisan abstraksi kripto, dan rancang naik taraf atau penggantian berperingkat.'],
            ['punca' => 'Ketiadaan ujian kebolehoperasian PQC', 'pelan' => 'Sediakan persekitaran ujian PQC, jalankan ujian interoperabiliti antara sistem, dan dokumentasikan keputusan.'],
            ['punca' => 'Risiko downgrade attack semasa fasa hybrid', 'pelan' => 'Laksana kawalan anti-downgrade, kuatkuasakan konfigurasi minimum algoritma, dan pantau trafik untuk cubaan downgrade.'],
            ['punca' => 'Proses perolehan tidak mengambil kira keperluan PQC', 'pelan' => 'Masukkan klausa PQC dan ketangkasan kripto dalam spesifikasi perolehan dan penilaian teknikal.'],
            ['punca' => 'Integrasi API tidak menggunakan enkripsi kalis kuantum', 'pelan' => 'Nilai API kritikal, guna TLS moden/konfigurasi hibrid, dan rancang naik taraf kepada sokongan PQC.'],
        ];

        foreach ($data as $item) {
            PuncaRisiko::firstOrCreate([
                'punca_risiko' => $item['punca'],
                'kategori_punca_risiko_id' => $cat->id,
                'pelan_mitigasi' => $item['pelan'],
            ]);
        }
    }

    private function seedCategory8()
    {
        $cat = KategoriPuncaRisiko::where('kategori_punca_risiko', 'Operasi & Respons Insiden')->first();
        if (!$cat) return;

        $data = [
            ['punca' => 'Ketiadaan pelan respons insiden kompromi kriptografi', 'pelan' => 'Bangunkan pelan respons insiden kripto, sertakan prosedur penggantian kunci segera dan komunikasi pihak berkepentingan.'],
        ];

        foreach ($data as $item) {
            PuncaRisiko::firstOrCreate([
                'punca_risiko' => $item['punca'],
                'kategori_punca_risiko_id' => $cat->id,
                'pelan_mitigasi' => $item['pelan'],
            ]);
        }
    }

    private function seedCategory9()
    {
        $cat = KategoriPuncaRisiko::where('kategori_punca_risiko', 'Pengurusan Kunci')->first();
        if (!$cat) return;

        $data = [
            ['punca' => 'Pengurusan kunci tidak berpusat atau tidak terkawal', 'pelan' => 'Implementasi Sistem Pengurusan Kunci Berpusat (KMS) dengan HSM yang diperakui FIPS 140-3'],
            ['punca' => 'Pengurusan kitarhayat kunci tidak lengkap', 'pelan' => 'Takrifkan prosedur jana, edaran, simpan, putar dan lupus kunci, serta automasikan pengurusan kunci jika boleh.'],
            ['punca' => 'Kegagalan putar kunci secara berkala', 'pelan' => 'Tetapkan polisi putaran kunci automatik, pantau pematuhan, dan beri amaran sebelum tamat tempoh.'],
            ['punca' => 'Sandar mengandungi kunci tanpa perlindungan', 'pelan' => 'Sulitkan semua sandaran, asingkan penyimpanan kunci, dan hadkan akses kepada sandaran.'],
            ['punca' => 'Token atau kelayakan tidak dilindungi', 'pelan' => 'Simpan token dalam stor selamat, gunakan penyulitan dan hadkan akses aplikasi.'],
            ['punca' => 'Ketiadaan jejak audit bagi operasi kunci', 'pelan' => 'Aktifkan logging terperinci operasi kunci dan semak log secara berkala.'],
            ['punca' => 'Kegagalan menguji pemulihan material kunci', 'pelan' => 'Jalankan ujian pemulihan berkala dan dokumentasikan prosedur pemulihan.'],
        ];

        foreach ($data as $item) {
            PuncaRisiko::firstOrCreate([
                'punca_risiko' => $item['punca'],
                'kategori_punca_risiko_id' => $cat->id,
                'pelan_mitigasi' => $item['pelan'],
            ]);
        }
    }

    private function seedCategory10()
    {
        $cat = KategoriPuncaRisiko::where('kategori_punca_risiko', 'Perlindungan Data')->first();
        if (!$cat) return;

        $data = [
            ['punca' => 'Data sensitif tidak dikelaskan dengan betul', 'pelan' => 'Laksanakan polisi pengelasan data, labelkan data sensitif, dan kaitkan tahap pengelasan dengan kawalan penyulitan.'],
            ['punca' => 'Data transit melalui rangkaian tidak dipercayai', 'pelan' => 'Kuatkuasakan penggunaan TLS atau VPN untuk semua komunikasi sensitif.'],
        ];

        foreach ($data as $item) {
            PuncaRisiko::firstOrCreate([
                'punca_risiko' => $item['punca'],
                'kategori_punca_risiko_id' => $cat->id,
                'pelan_mitigasi' => $item['pelan'],
            ]);
        }
    }

    private function seedCategory11()
    {
        $cat = KategoriPuncaRisiko::where('kategori_punca_risiko', 'Rantaian Bekalan & Vendor')->first();
        if (!$cat) return;

        $data = [
            ['punca' => 'Ketergantungan kepada pembekal kripto tunggal', 'pelan' => 'Pelbagaikan vendor, nilai keserasian alternatif, dan sediakan pelan keluar vendor.'],
            ['punca' => 'Perubahan teknologi vendor tanpa notifikasi', 'pelan' => 'Masukkan keperluan notifikasi perubahan dalam kontrak dan pantau pengumuman vendor.'],
            ['punca' => 'Kegagalan menilai risiko rantaian bekalan', 'pelan' => 'Laksanakan penilaian keselamatan vendor berkala dan audit rantaian bekalan.'],
            ['punca' => 'Peranti legasi tidak menyokong algoritma moden', 'pelan' => 'Kenal pasti peranti terjejas, rancang penggantian atau lapisan perlindungan tambahan.'],
        ];

        foreach ($data as $item) {
            PuncaRisiko::firstOrCreate([
                'punca_risiko' => $item['punca'],
                'kategori_punca_risiko_id' => $cat->id,
                'pelan_mitigasi' => $item['pelan'],
            ]);
        }
    }

    private function seedCategory12()
    {
        $cat = KategoriPuncaRisiko::where('kategori_punca_risiko', 'Tadbir Urus & Polisi')->first();
        if (!$cat) return;

        $data = [
            ['punca' => 'Ketidakpatuhan kepada piawaian industri', 'pelan' => 'Petakan kawalan kepada piawaian (ISO/NIST), jalankan audit berkala, dan wujudkan pelan pembetulan pematuhan.'],
            ['punca' => 'Ketiadaan Business Impact Analysis berkaitan risiko kuantum', 'pelan' => 'Laksanakan BIA khusus kripto/kuantum, petakan impak kepada operasi, dan gunakan hasil untuk keutamaan mitigasi.'],
            ['punca' => 'Tiada polisi kriptografi organisasi yang formal', 'pelan' => 'Bangunkan polisi kriptografi rasmi diluluskan pengurusan, edarkan kepada semua unit, dan semak secara berkala.'],
            ['punca' => 'Ketiadaan struktur tadbir urus kriptografi', 'pelan' => 'Tubuhkan jawatankuasa kriptografi, lantik pemilik domain, dan tetapkan proses keputusan serta eskalasi.'],
            ['punca' => 'Proses kelulusan algoritma tidak dikawal', 'pelan' => 'Wujudkan senarai algoritma diluluskan, tetapkan proses kelulusan rasmi, dan kuatkuasakan melalui kawalan teknikal.'],
            ['punca' => 'Tiada proses penilaian risiko kripto berkala', 'pelan' => 'Tetapkan penilaian risiko tahunan atau berkala, gunakan metodologi piawai, dan rekod dalam daftar risiko.'],
            ['punca' => 'Kurang kesedaran pengurusan mengenai risiko kuantum', 'pelan' => 'Adakan taklimat pengurusan berkala, bentangkan risiko strategik, dan masukkan dalam agenda tadbir urus ICT.'],
        ];

        foreach ($data as $item) {
            PuncaRisiko::firstOrCreate([
                'punca_risiko' => $item['punca'],
                'kategori_punca_risiko_id' => $cat->id,
                'pelan_mitigasi' => $item['pelan'],
            ]);
        }
    }
}

