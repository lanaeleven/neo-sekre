<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\User;
use App\Models\Direksi;
use App\Models\JenisSurat;
use App\Models\DistribusiSurat;
use App\Models\JenisInformasi;
use App\Models\JenisRegulasi;
use App\Models\TujuanDisposisi;
use Illuminate\Database\Seeder;
use App\Models\StrukturOrganisasi;
use App\Models\Unit;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        // 'email' => 'test@example.com',
        // ]);






        // SEEDING UNTUK TABEL JENIS SURAT 

        JenisSurat::create([
            'kodeJenisSurat' => 'B',
            'keterangan' => 'Umum'
        ]);

        JenisSurat::create([
            'kodeJenisSurat' => 'K',
            'keterangan' => 'Kepegawaian'
        ]);

        JenisSurat::create([
            'kodeJenisSurat' => 'Y',
            'keterangan' => 'YBWSA dan Lingkungannya'
        ]);

        JenisSurat::create([
            'kodeJenisSurat' => 'URT',
            'keterangan' => 'Internal Umum'
        ]);

        JenisSurat::create([
            'kodeJenisSurat' => 'KPTS',
            'keterangan' => 'Surat Keputusan'
        ]);

        JenisSurat::create([
            'kodeJenisSurat' => 'PKS',
            'keterangan' => 'Perjanjian Kerja Sama'
        ]);

        JenisSurat::create([
            'kodeJenisSurat' => 'ST',
            'keterangan' => 'Surat Tugas'
        ]);

        JenisSurat::create([
            'kodeJenisSurat' => 'PER',
            'keterangan' => 'Peraturan'
        ]);

        JenisSurat::create([
            'kodeJenisSurat' => 'KBJ',
            'keterangan' => 'Kebijakan'
        ]);

        // JenisSurat::create([
        //     'kodeJenisSurat' => 'SPO',
        //     'keterangan' => 'Prosedur'
        // ]);

        JenisSurat::create([
            'kodeJenisSurat' => 'TAG',
            'keterangan' => 'Tagihan'
        ]);

        JenisSurat::create([
            'kodeJenisSurat' => 'SE',
            'keterangan' => 'Surat Edaran'
        ]);

        // SEEDING UNTUK TABEL USER

        User::create([
            'username' => 'sekre',
            'nama' => 'Mr. X',
            'email' => 'maulanaelvn@gmail.com',
            'namaJabatan' => 'Sekretariat',
            'password' => Hash::make('1')
        ]);

        User::create([
            'username' => 'developer',
            'nama' => 'Developer',
            'email' => 'maulanaelvn@gmail.com',
            'namaJabatan' => 'Developer',
            'password' => Hash::make('Secret123!')
        ]);

        User::create([
            'username' => 'direktur',
            'nama' => 'Mr. X',
            'email' => 'maulanaelvn@gmail.com',
            'namaJabatan' => 'Direktur Rumah Sakit',
            'password' => Hash::make('1')
        ]);

        User::create([
            'username' => 'kabid pelayanan dan penunjang medik',
            'nama' => 'Mr. X',
            'email' => 'maulanaelvn@gmail.com',
            'namaJabatan' => 'Kepala Bidang Pelayanan dan Penunjang Medik',
            'password' => Hash::make('1')
        ]);

        User::create([
            'username' => 'kasi pelayanan medik',
            'nama' => 'Mr. X',
            'email' => 'maulanaelvn@gmail.com',
            'namaJabatan' => 'Kepala Seksi Pelayanan Medik',
            'password' => Hash::make('1')
        ]);

        User::create([
            'username' => 'kasi penunjang medik',
            'nama' => 'Mr. X',
            'email' => 'maulanaelvn@gmail.com',
            'namaJabatan' => 'Kepala Seksi Penunjang Medik dan Diklitbang',
            'password' => Hash::make('1')
        ]);

        User::create([
            'username' => 'kabid perawatan',
            'nama' => 'Mr. X',
            'email' => 'maulanaelvn@gmail.com',
            'namaJabatan' => 'Kepala Bidang Perawatan',
            'password' => Hash::make('1')
        ]);

        User::create([
            'username' => 'kasi keperawatan',
            'nama' => 'Mr. X',
            'email' => 'maulanaelvn@gmail.com',
            'namaJabatan' => 'Kepala Seksi Keperawatan',
            'password' => Hash::make('1')
        ]);

        User::create([
            'username' => 'sdi dan keu',
            'nama' => 'Mr. X',
            'email' => 'maulanaelvn@gmail.com',
            'namaJabatan' => 'Kepala Bagian SDI dan Keuangan',
            'password' => Hash::make('1')
        ]);

        User::create([
            'username' => 'sdi',
            'nama' => 'Mr. X',
            'email' => 'akunlana11@gmail.com',
            'namaJabatan' => 'Kepala Sub Bagian SDI dan Administrasi',
            'password' => Hash::make('1')
        ]);

        User::create([
            'username' => 'keu',
            'nama' => 'Mr. X',
            'email' => 'vuulaan@gmail.com',
            'namaJabatan' => 'Kepala Sub Bagian Akuntansi dan Keuangan',
            'password' => Hash::make('1')
        ]);

        User::create([
            'username' => 'kepala umum dakwah dan kemitraan',
            'nama' => 'Mr. X',
            'email' => 'maulanaelvn@gmail.com',
            'namaJabatan' => 'Kepala Bagian Umum, Dakwah, dan Kemitraan',
            'password' => Hash::make('1')
        ]);

        User::create([
            'username' => 'kasubag dakwah',
            'nama' => 'Mr. X',
            'email' => 'maulanaelvn@gmail.com',
            'namaJabatan' => 'Kepala Sub Bagian Dakwah',
            'password' => Hash::make('1')
        ]);

        User::create([
            'username' => 'kasubag kemitraan dan pkrs',
            'nama' => 'Mr. X',
            'email' => 'maulanaelvn@gmail.com',
            'namaJabatan' => 'Kepala Sub Bagian Kemitraan dan PKRS',
            'password' => Hash::make('1')
        ]);

        User::create([
            'username' => 'penjab umum',
            'nama' => 'Mr. X',
            'email' => 'maulanaelvn@gmail.com',
            'namaJabatan' => 'Penanggung Jawab Umum',
            'password' => Hash::make('1')
        ]);

        User::create([
            'username' => 'kains farmasi',
            'nama' => 'Mr. X',
            'email' => 'maulanaelvn@gmail.com',
            'namaJabatan' => 'Kepala Instalasi Farmasi',
            'password' => Hash::make('1')
        ]);

        User::create([
            'username' => 'penjab farmasi',
            'nama' => 'Mr. X',
            'email' => 'maulanaelvn@gmail.com',
            'namaJabatan' => 'Penanggung Jawab Farmasi',
            'password' => Hash::make('1')
        ]);

        User::create([
            'username' => 'kains psrs',
            'nama' => 'Mr. X',
            'email' => 'maulanaelvn@gmail.com',
            'namaJabatan' => 'Kepala Instalasi PSRS',
            'password' => Hash::make('1')
        ]);

        User::create([
            'username' => 'penjab psrs',
            'nama' => 'Mr. X',
            'email' => 'maulanaelvn@gmail.com',
            'namaJabatan' => 'Penanggung Jawab PSRS',
            'password' => Hash::make('1')
        ]);

        User::create([
            'username' => 'kains rekam medis dan pendaftaran',
            'nama' => 'Mr. X',
            'email' => 'maulanaelvn@gmail.com',
            'namaJabatan' => 'Kepala Instalasi Rekam Medis dan Pendaftaran',
            'password' => Hash::make('1')
        ]);

        User::create([
            'username' => 'penjab pendaftaran dan rekam medis',
            'nama' => 'Mr. X',
            'email' => 'maulanaelvn@gmail.com',
            'namaJabatan' => 'Penanggung Jawab Pendaftaran dan Rekam Medis',
            'password' => Hash::make('1')
        ]);

        User::create([
            'username' => 'kains gizi',
            'nama' => 'Mr. X',
            'email' => 'maulanaelvn@gmail.com',
            'namaJabatan' => 'Kepala Instalasi Gizi',
            'password' => Hash::make('1')
        ]);

        User::create([
            'username' => 'penjab gizi',
            'nama' => 'Mr. X',
            'email' => 'maulanaelvn@gmail.com',
            'namaJabatan' => 'Penanggung Jawab Gizi',
            'password' => Hash::make('1')
        ]);

        User::create([
            'username' => 'kains ranap dan rajal',
            'nama' => 'Mr. X',
            'email' => 'maulanaelvn@gmail.com',
            'namaJabatan' => 'Kepala Instalasi Rawat Inap dan Rawat Jalan',
            'password' => Hash::make('1')
        ]);

        User::create([
            'username' => 'penjab rajal',
            'nama' => 'Mr. X',
            'email' => 'maulanaelvn@gmail.com',
            'namaJabatan' => 'Penanggung Jawab Rawat Jalan',
            'password' => Hash::make('1')
        ]);

        User::create([
            'username' => 'penjab ranap',
            'nama' => 'Mr. X',
            'email' => 'maulanaelvn@gmail.com',
            'namaJabatan' => 'Penanggung Jawab Rawat Inap',
            'password' => Hash::make('1')
        ]);

        User::create([
            'username' => 'kains igd',
            'nama' => 'Mr. X',
            'email' => 'maulanaelvn@gmail.com',
            'namaJabatan' => 'Kepala Instalasi Gawat Darurat',
            'password' => Hash::make('1')
        ]);

        User::create([
            'username' => 'karu igd',
            'nama' => 'Mr. X',
            'email' => 'maulanaelvn@gmail.com',
            'namaJabatan' => 'Kepala Ruang Instalasi Gawat Darurat',
            'password' => Hash::make('1')
        ]);

        User::create([
            'username' => 'kains icu',
            'nama' => 'Mr. X',
            'email' => 'maulanaelvn@gmail.com',
            'namaJabatan' => 'Kepala Instalasi Intensive Care Unit',
            'password' => Hash::make('1')
        ]);

        User::create([
            'username' => 'karu icu',
            'nama' => 'Mr. X',
            'email' => 'maulanaelvn@gmail.com',
            'namaJabatan' => 'Kepala Ruang Intensive Care Unit',
            'password' => Hash::make('1')
        ]);

        User::create([
            'username' => 'kains radiologi',
            'nama' => 'Mr. X',
            'email' => 'maulanaelvn@gmail.com',
            'namaJabatan' => 'Kepala Instalasi Radiologi',
            'password' => Hash::make('1')
        ]);

        User::create([
            'username' => 'penjab radiologi',
            'nama' => 'Mr. X',
            'email' => 'maulanaelvn@gmail.com',
            'namaJabatan' => 'Penanggung Jawab Radiologi',
            'password' => Hash::make('1')
        ]);

        User::create([
            'username' => 'kains ibs',
            'nama' => 'Mr. X',
            'email' => 'maulanaelvn@gmail.com',
            'namaJabatan' => 'Kepala Instalasi Bedah Sentral',
            'password' => Hash::make('1')
        ]);

        User::create([
            'username' => 'karu ibs',
            'nama' => 'Mr. X',
            'email' => 'maulanaelvn@gmail.com',
            'namaJabatan' => 'Kepala Ruang Instalasi Bedah Sentral',
            'password' => Hash::make('1')
        ]);

        User::create([
            'username' => 'kains lab',
            'nama' => 'Mr. X',
            'email' => 'maulanaelvn@gmail.com',
            'namaJabatan' => 'Kepala Instalasi Laboratorium',
            'password' => Hash::make('1')
        ]);

        User::create([
            'username' => 'penjab lab',
            'nama' => 'Mr. X',
            'email' => 'maulanaelvn@gmail.com',
            'namaJabatan' => 'Penanggung Jawab Instalasi Laboratorium',
            'password' => Hash::make('1')
        ]);

        User::create([
            'username' => 'kains dialis',
            'nama' => 'Mr. X',
            'email' => 'maulanaelvn@gmail.com',
            'namaJabatan' => 'Kepala Instalasi Dialis',
            'password' => Hash::make('1')
        ]);

        User::create([
            'username' => 'penjab dialis',
            'nama' => 'Mr. X',
            'email' => 'maulanaelvn@gmail.com',
            'namaJabatan' => 'Penanggung Jawab Dialis',
            'password' => Hash::make('1')
        ]);

        User::create([
            'username' => 'kains mcu',
            'nama' => 'Mr. X',
            'email' => 'maulanaelvn@gmail.com',
            'namaJabatan' => 'Kepala Instalasi MCU',
            'password' => Hash::make('1')
        ]);


        // SEEDING UNTUK TABEL DIREKSI

        Direksi::create([
            'namaDireksi' => 'Direktur'
        ]);

        \App\Models\SuratKeluar::factory(100)->create();
        \App\Models\Spo::factory(100)->create();


        // \App\Models\SuratMasuk::factory(100)->create();

        $total = 50; // misalnya ingin membuat 20 data
        $setengah = $total / 2;

        for ($i = 0; $i < $total; $i++) {
            \App\Models\SuratMasuk::factory()->create([
                'status' => $i < $setengah
                    ? 'Diarsipkan'
                    : 'Diteruskan ke Kepala Instalasi PSRS'
            ]);
        }


        // \App\Models\SuratMasuk::factory(30)->create();

        // \App\Models\Spo::factory(50)->create();
        // for ($i=1; $i < 21 ; $i++) { 
        //     DistribusiSurat::create([
        //         'idSuratMasuk' => $i,
        //         'idTujuanDisposisi' => 3,
        //         'idPengirimDisposisi' => 1,
        //         'tanggalDiteruskan' => fake()->dateTimeThisYear(),
        //         'status' => 'Diteruskan ke Direktur Rumah Sakit',
        //         'instruksi' => 'dadadadadada' 
        //     ]);

        //     DistribusiSurat::create([
        //         'idSuratMasuk' => $i,
        //         'idTujuanDisposisi' => 18,
        //         'idPengirimDisposisi' => 3,
        //         'tanggalDiteruskan' => fake()->dateTimeThisYear(),
        //         'status' => 'Diteruskan ke Kepala Instalasi PSRS',
        //         'instruksi' => 'dududududududu' 
        //     ]);            
        // }



        // SEEDER TABEL STRUKTUR ORGANISASI

        StrukturOrganisasi::create([
            'idUser' => 1,
            'idAtasan' => 1,
            'levelJabatan' => 1
        ]);

        StrukturOrganisasi::create([
            'idUser' => 2,
            'idAtasan' => 2,
            'levelJabatan' => 2
        ]);

        StrukturOrganisasi::create([
            'idUser' => 3,
            'idAtasan' => 3,
            'levelJabatan' => 2
        ]);

        StrukturOrganisasi::create([
            'idUser' => 4,
            'idAtasan' => 3,
            'levelJabatan' => 3
        ]);

        StrukturOrganisasi::create([
            'idUser' => 5,
            'idAtasan' => 4,
            'levelJabatan' => 4
        ]);

        StrukturOrganisasi::create([
            'idUser' => 6,
            'idAtasan' => 4,
            'levelJabatan' => 4
        ]);

        StrukturOrganisasi::create([
            'idUser' => 7,
            'idAtasan' => 3,
            'levelJabatan' => 3
        ]);

        StrukturOrganisasi::create([
            'idUser' => 8,
            'idAtasan' => 7,
            'levelJabatan' => 4
        ]);

        StrukturOrganisasi::create([
            'idUser' => 9,
            'idAtasan' => 3,
            'levelJabatan' => 3
        ]);

        StrukturOrganisasi::create([
            'idUser' => 10,
            'idAtasan' => 9,
            'levelJabatan' => 4
        ]);

        StrukturOrganisasi::create([
            'idUser' => 11,
            'idAtasan' => 9,
            'levelJabatan' => 4
        ]);

        StrukturOrganisasi::create([
            'idUser' => 12,
            'idAtasan' => 3,
            'levelJabatan' => 3
        ]);

        StrukturOrganisasi::create([
            'idUser' => 13,
            'idAtasan' => 12,
            'levelJabatan' => 4
        ]);

        StrukturOrganisasi::create([
            'idUser' => 14,
            'idAtasan' => 12,
            'levelJabatan' => 4
        ]);

        StrukturOrganisasi::create([
            'idUser' => 15,
            'idAtasan' => 12,
            'levelJabatan' => 4
        ]);

        StrukturOrganisasi::create([
            'idUser' => 16,
            'idAtasan' => 3,
            'levelJabatan' => 3
        ]);

        StrukturOrganisasi::create([
            'idUser' => 17,
            'idAtasan' => 16,
            'levelJabatan' => 4
        ]);

        StrukturOrganisasi::create([
            'idUser' => 18,
            'idAtasan' => 3,
            'levelJabatan' => 3
        ]);

        StrukturOrganisasi::create([
            'idUser' => 19,
            'idAtasan' => 18,
            'levelJabatan' => 4
        ]);

        StrukturOrganisasi::create([
            'idUser' => 20,
            'idAtasan' => 3,
            'levelJabatan' => 3
        ]);

        StrukturOrganisasi::create([
            'idUser' => 21,
            'idAtasan' => 20,
            'levelJabatan' => 4
        ]);

        StrukturOrganisasi::create([
            'idUser' => 22,
            'idAtasan' => 3,
            'levelJabatan' => 3
        ]);

        StrukturOrganisasi::create([
            'idUser' => 23,
            'idAtasan' => 22,
            'levelJabatan' => 4
        ]);

        StrukturOrganisasi::create([
            'idUser' => 24,
            'idAtasan' => 3,
            'levelJabatan' => 3
        ]);

        StrukturOrganisasi::create([
            'idUser' => 25,
            'idAtasan' => 24,
            'levelJabatan' => 4
        ]);

        StrukturOrganisasi::create([
            'idUser' => 26,
            'idAtasan' => 24,
            'levelJabatan' => 4
        ]);

        StrukturOrganisasi::create([
            'idUser' => 27,
            'idAtasan' => 3,
            'levelJabatan' => 3
        ]);

        StrukturOrganisasi::create([
            'idUser' => 28,
            'idAtasan' => 27,
            'levelJabatan' => 4
        ]);

        StrukturOrganisasi::create([
            'idUser' => 29,
            'idAtasan' => 3,
            'levelJabatan' => 3
        ]);

        StrukturOrganisasi::create([
            'idUser' => 30,
            'idAtasan' => 29,
            'levelJabatan' => 4
        ]);

        StrukturOrganisasi::create([
            'idUser' => 31,
            'idAtasan' => 3,
            'levelJabatan' => 3
        ]);

        StrukturOrganisasi::create([
            'idUser' => 32,
            'idAtasan' => 31,
            'levelJabatan' => 4
        ]);

        StrukturOrganisasi::create([
            'idUser' => 33,
            'idAtasan' => 3,
            'levelJabatan' => 3
        ]);

        StrukturOrganisasi::create([
            'idUser' => 34,
            'idAtasan' => 33,
            'levelJabatan' => 4
        ]);

        StrukturOrganisasi::create([
            'idUser' => 35,
            'idAtasan' => 3,
            'levelJabatan' => 3
        ]);

        StrukturOrganisasi::create([
            'idUser' => 36,
            'idAtasan' => 35,
            'levelJabatan' => 4
        ]);

        StrukturOrganisasi::create([
            'idUser' => 37,
            'idAtasan' => 3,
            'levelJabatan' => 3
        ]);

        StrukturOrganisasi::create([
            'idUser' => 38,
            'idAtasan' => 37,
            'levelJabatan' => 4
        ]);

        StrukturOrganisasi::create([
            'idUser' => 39,
            'idAtasan' => 3,
            'levelJabatan' => 3
        ]);



        // SEEDER UNIT

        Unit::create(['nama' => 'SDI & Administrasi']);
        Unit::create(['nama' => 'Keuangan & Akuntansi']);
        Unit::create(['nama' => 'Umum']);


        // SEEDER REGULASI

        JenisRegulasi::create(['kodeJenisRegulasi' => 'KPTS', 'keterangan' => 'Keputusan']);
        JenisRegulasi::create(['kodeJenisRegulasi' => 'PER', 'keterangan' => 'Persetujuan']);
        \App\Models\Regulasi::factory(100)->create();
        DB::table('unit_user')->insert([
            'user_id' => 10,
            'unit_id' => 1,
        ]);

        $dataSpoUnit = [];
        for ($i = 1; $i <= 100; $i++) {
            $dataSpoUnit[] = [
                'spo_id' => $i,
                'unit_id' => 1,
            ];
        }
        DB::table('spo_unit')->insert($dataSpoUnit);

        $dataRegulasiUnit = [];
        for ($i = 1; $i <= 100; $i++) {
            $dataRegulasiUnit[] = [
                'regulasi_id' => $i,
                'unit_id' => 1,
            ];
        }
        DB::table('regulasi_unit')->insert($dataRegulasiUnit);

        $dataSudahDiteruskan = [];
        for ($i = 1; $i <= 50; $i++) {
            $dataSudahDiteruskan[] = [
                'idSuratMasuk' => $i,
                'idTujuanDisposisi' => 11,
                'idPengirimDisposisi' => 10,
                'tanggalDiteruskan' => Carbon::now(),
                'status' => 'Diteruskan ke Kepala Sub Bagian Akuntansi dan Keuangan',
                'instruksi' => 'tes'
            ];
        }
        DB::table('distribusi_surat')->insert($dataSudahDiteruskan);


        
        \App\Models\PerjanjianKerjaSama::factory(100)->create();
        $dataPksUser = [];
        for ($i = 1; $i <= 100; $i++) {
            $dataPksUser[] = [
                'perjanjian_kerja_sama_id' => $i,
                'user_id' => 10,
            ];
        }
        DB::table('perjanjian_kerja_sama_user')->insert($dataPksUser);
        
        \App\Models\Undangan::factory(100)->create();
        $dataUndanganUser = [];
        for ($i = 1; $i <= 100; $i++) {
            $dataUndanganUser[] = [
                'undangan_id' => $i,
                'user_id' => 10,
            ];
        }
        DB::table('undangan_user')->insert($dataUndanganUser);
        
        JenisInformasi::create(['nama' => 'Pengumuman/Himbauan']);
        JenisInformasi::create(['nama' => 'Edaran']);
        
        \App\Models\Informasi::factory(100)->create();
        $dataInformasiUser = [];
        for ($i = 1; $i <= 100; $i++) {
            $dataInformasiUser[] = [
                'informasi_id' => $i,
                'user_id' => 10,
            ];
        }
        DB::table('informasi_user')->insert($dataInformasiUser);
    }
}
