<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Guru;
use App\Models\Siswa;
use App\Models\Kelas;
use App\Models\Mapel;
use App\Models\TahunAjaran;
use App\Models\Semester;
use App\Models\KelasSiswa;
use App\Models\Pengampu;
use App\Models\Nilai;
use App\Models\Presensi;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // =============================================
        // 1. TAHUN AJARAN & SEMESTER
        // =============================================
        $ta = TahunAjaran::create([
            'nama' => '2025/2026',
            'tanggal_mulai' => '2025-07-14',
            'tanggal_selesai' => '2026-06-20',
            'is_aktif' => true,
        ]);

        $smtGanjil = Semester::create([
            'tahun_ajaran_id' => $ta->id,
            'semester' => 'Ganjil',
            'is_aktif' => false,
        ]);

        $smtGenap = Semester::create([
            'tahun_ajaran_id' => $ta->id,
            'semester' => 'Genap',
            'is_aktif' => true,
        ]);

        // =============================================
        // 2. GURU
        // =============================================
        $guruData = [
            ['nip' => '198501012010011001', 'nama_guru' => 'Drs. Ahmad Fauzi, M.Pd.',    'jenis_kelamin' => 'Laki-laki',  'no_hp' => '081234567801'],
            ['nip' => '198602022011012002', 'nama_guru' => 'Sri Wahyuni, S.Pd.',           'jenis_kelamin' => 'Perempuan',  'no_hp' => '081234567802'],
            ['nip' => '198703032012011003', 'nama_guru' => 'Bambang Supriyadi, S.Pd.',     'jenis_kelamin' => 'Laki-laki',  'no_hp' => '081234567803'],
            ['nip' => '198804042013012004', 'nama_guru' => 'Dewi Kartika Sari, M.Pd.',     'jenis_kelamin' => 'Perempuan',  'no_hp' => '081234567804'],
            ['nip' => '198905052014011005', 'nama_guru' => 'Rudi Hermawan, S.Pd.',          'jenis_kelamin' => 'Laki-laki',  'no_hp' => '081234567805'],
            ['nip' => '199006062015012006', 'nama_guru' => 'Rina Fitriani, S.Pd.',          'jenis_kelamin' => 'Perempuan',  'no_hp' => '081234567806'],
            ['nip' => '199107072016011007', 'nama_guru' => 'Hendra Wijaya, M.Pd.',          'jenis_kelamin' => 'Laki-laki',  'no_hp' => '081234567807'],
            ['nip' => '199208082017012008', 'nama_guru' => 'Siti Aminah, S.Pd.',            'jenis_kelamin' => 'Perempuan',  'no_hp' => '081234567808'],
        ];

        $gurus = [];
        foreach ($guruData as $g) {
            $gurus[] = Guru::create($g);
        }

        // =============================================
        // 3. USER (Admin + Guru accounts)
        // =============================================
        User::create([
            'nama' => 'Administrator',
            'username' => '12345678', // Username admin diganti menjadi format NIP (angka)
            'email' => 'admin@sekolah.sch.id',
            'password' => Hash::make('12345678'), // Password admin disamakan dengan username (format NIP)
            'role' => 'admin',
            'guru_id' => null,
        ]);

        // Buat akun login untuk semua guru
        foreach ($gurus as $i => $guru) {
            User::create([
                'nama' => $guru->nama_guru,
                'username' => $guru->nip, // Menggunakan NIP sebagai username default
                'email' => 'guru' . ($i + 1) . '@sekolah.sch.id',
                'password' => Hash::make($guru->nip), // Menggunakan NIP sebagai password default
                'role' => 'guru',
                'guru_id' => $guru->id,
            ]);
        }

        // =============================================
        // 4. KELAS
        // =============================================
        $kelasData = [
            ['kode_kelas' => 'X-MIPA-1',  'nama_kelas' => 'X MIPA 1',    'tingkat' => 'X'],
            ['kode_kelas' => 'X-MIPA-2',  'nama_kelas' => 'X MIPA 2',    'tingkat' => 'X'],
            ['kode_kelas' => 'X-IPS-1',   'nama_kelas' => 'X IPS 1',     'tingkat' => 'X'],
            ['kode_kelas' => 'XI-MIPA-1', 'nama_kelas' => 'XI MIPA 1',   'tingkat' => 'XI'],
            ['kode_kelas' => 'XI-MIPA-2', 'nama_kelas' => 'XI MIPA 2',   'tingkat' => 'XI'],
            ['kode_kelas' => 'XI-IPS-1',  'nama_kelas' => 'XI IPS 1',    'tingkat' => 'XI'],
            ['kode_kelas' => 'XII-MIPA-1','nama_kelas' => 'XII MIPA 1',  'tingkat' => 'XII'],
            ['kode_kelas' => 'XII-IPS-1', 'nama_kelas' => 'XII IPS 1',   'tingkat' => 'XII'],
        ];

        $kelasList = [];
        foreach ($kelasData as $i => $k) {
            // Berikan wali kelas (Guru 0-7) untuk kelas 0-7 secara berurutan
            $k['wali_id'] = $gurus[$i]->id;
            $kelasList[] = Kelas::create($k);
        }

        // =============================================
        // 5. MAPEL
        // =============================================
        $mapelData = [
            ['kode_mapel' => 'MTK-W',   'nama_mapel' => 'Matematika Wajib',    'kelompok' => 'Wajib'],
            ['kode_mapel' => 'BIN',      'nama_mapel' => 'Bahasa Indonesia',    'kelompok' => 'Wajib'],
            ['kode_mapel' => 'BING',     'nama_mapel' => 'Bahasa Inggris',      'kelompok' => 'Wajib'],
            ['kode_mapel' => 'FIS',      'nama_mapel' => 'Fisika',              'kelompok' => 'Peminatan'],
            ['kode_mapel' => 'KIM',      'nama_mapel' => 'Kimia',               'kelompok' => 'Peminatan'],
            ['kode_mapel' => 'BIO',      'nama_mapel' => 'Biologi',             'kelompok' => 'Peminatan'],
            ['kode_mapel' => 'EKO',      'nama_mapel' => 'Ekonomi',             'kelompok' => 'Peminatan'],
            ['kode_mapel' => 'PJOK',     'nama_mapel' => 'Penjas',              'kelompok' => 'Wajib'],
            ['kode_mapel' => 'PAI',      'nama_mapel' => 'Pendidikan Agama',    'kelompok' => 'Wajib'],
            ['kode_mapel' => 'MULOK',    'nama_mapel' => 'Bahasa Daerah',       'kelompok' => 'Muatan Lokal'],
        ];

        $mapels = [];
        foreach ($mapelData as $m) {
            $mapels[] = Mapel::create($m);
        }

        // =============================================
        // 6. SISWA
        // =============================================
        $namaSiswa = [
            ['nis' => '2025001', 'nama_siswa' => 'Budi Santoso',          'jenis_kelamin' => 'Laki-laki'],
            ['nis' => '2025002', 'nama_siswa' => 'Siti Nurhaliza',        'jenis_kelamin' => 'Perempuan'],
            ['nis' => '2025003', 'nama_siswa' => 'Ahmad Hidayat',         'jenis_kelamin' => 'Laki-laki'],
            ['nis' => '2025004', 'nama_siswa' => 'Dewi Lestari',          'jenis_kelamin' => 'Perempuan'],
            ['nis' => '2025005', 'nama_siswa' => 'Rinto Harahap',         'jenis_kelamin' => 'Laki-laki'],
            ['nis' => '2025006', 'nama_siswa' => 'Putri Ayu Lestari',     'jenis_kelamin' => 'Perempuan'],
            ['nis' => '2025007', 'nama_siswa' => 'Fajar Ramadhan',        'jenis_kelamin' => 'Laki-laki'],
            ['nis' => '2025008', 'nama_siswa' => 'Maya Saleha',           'jenis_kelamin' => 'Perempuan'],
            ['nis' => '2025009', 'nama_siswa' => 'Eka Prasetyo',          'jenis_kelamin' => 'Laki-laki'],
            ['nis' => '2025010', 'nama_siswa' => 'Ratna Kusuma',          'jenis_kelamin' => 'Perempuan'],
            ['nis' => '2025011', 'nama_siswa' => 'Gilang Ramadan',        'jenis_kelamin' => 'Laki-laki'],
            ['nis' => '2025012', 'nama_siswa' => 'Hesti Purwanti',        'jenis_kelamin' => 'Perempuan'],
            ['nis' => '2025013', 'nama_siswa' => 'Ivan Gunawan',          'jenis_kelamin' => 'Laki-laki'],
            ['nis' => '2025014', 'nama_siswa' => 'Julia Maharani',        'jenis_kelamin' => 'Perempuan'],
            ['nis' => '2025015', 'nama_siswa' => 'Citra Kirana',          'jenis_kelamin' => 'Perempuan'],
            ['nis' => '2025016', 'nama_siswa' => 'Dimas Prayoga',         'jenis_kelamin' => 'Laki-laki'],
            ['nis' => '2025017', 'nama_siswa' => 'Anisa Rahma',           'jenis_kelamin' => 'Perempuan'],
            ['nis' => '2025018', 'nama_siswa' => 'Samuel Simorangkir',    'jenis_kelamin' => 'Laki-laki'],
            ['nis' => '2025019', 'nama_siswa' => 'Fitriani Dewi',         'jenis_kelamin' => 'Perempuan'],
            ['nis' => '2025020', 'nama_siswa' => 'Rizky Maulana',         'jenis_kelamin' => 'Laki-laki'],
        ];

        $siswaList = [];
        foreach ($namaSiswa as $s) {
            $siswaList[] = Siswa::create($s);
        }

        // =============================================
        // 7. KELAS_SISWA (Penempatan siswa ke kelas)
        // =============================================
        // Siswa 1-5  → X MIPA 1
        // Siswa 6-10 → X MIPA 2
        // Siswa 11-15 → XI MIPA 1
        // Siswa 16-20 → XII MIPA 1
        $placement = [
            [0, [0,1,2,3,4]],     // X MIPA 1: siswa 1-5
            [1, [5,6,7,8,9]],     // X MIPA 2: siswa 6-10
            [3, [10,11,12,13,14]],// XI MIPA 1: siswa 11-15
            [6, [15,16,17,18,19]],// XII MIPA 1: siswa 16-20
        ];

        foreach ($placement as [$kelasIdx, $siswaIdxs]) {
            foreach ($siswaIdxs as $sIdx) {
                KelasSiswa::create([
                    'siswa_id' => $siswaList[$sIdx]->id,
                    'kelas_id' => $kelasList[$kelasIdx]->id,
                    'semester_id' => $smtGenap->id,
                ]);
            }
        }

        // =============================================
        // 8. PENGAMPU (Penugasan guru mengajar)
        // =============================================
        $pengampuData = [
            // Guru Ahmad Fauzi → Matematika di X MIPA 1 & X MIPA 2
            ['guru' => 0, 'mapel' => 0, 'kelas' => 0, 'kkm' => 75],
            ['guru' => 0, 'mapel' => 0, 'kelas' => 1, 'kkm' => 75],
            // Guru Sri Wahyuni → Bahasa Indonesia di X MIPA 1 & XI MIPA 1
            ['guru' => 1, 'mapel' => 1, 'kelas' => 0, 'kkm' => 75],
            ['guru' => 1, 'mapel' => 1, 'kelas' => 3, 'kkm' => 75],
            // Guru Bambang → Bahasa Inggris di X MIPA 2 & XII MIPA 1
            ['guru' => 2, 'mapel' => 2, 'kelas' => 1, 'kkm' => 70],
            ['guru' => 2, 'mapel' => 2, 'kelas' => 6, 'kkm' => 70],
            // Guru Dewi Kartika → Fisika di X MIPA 1 & XI MIPA 1
            ['guru' => 3, 'mapel' => 3, 'kelas' => 0, 'kkm' => 70],
            ['guru' => 3, 'mapel' => 3, 'kelas' => 3, 'kkm' => 70],
            // Guru Rudi → Kimia di X MIPA 1
            ['guru' => 4, 'mapel' => 4, 'kelas' => 0, 'kkm' => 70],
            // Guru Rina → Biologi di XI MIPA 1
            ['guru' => 5, 'mapel' => 5, 'kelas' => 3, 'kkm' => 70],
            // Guru Hendra → Penjas di X MIPA 1 & XII MIPA 1
            ['guru' => 6, 'mapel' => 7, 'kelas' => 0, 'kkm' => 75],
            ['guru' => 6, 'mapel' => 7, 'kelas' => 6, 'kkm' => 75],
        ];

        $pengampuList = [];
        foreach ($pengampuData as $p) {
            $pengampuList[] = Pengampu::create([
                'guru_id' => $gurus[$p['guru']]->id,
                'mapel_id' => $mapels[$p['mapel']]->id,
                'kelas_id' => $kelasList[$p['kelas']]->id,
                'semester_id' => $smtGenap->id,
                'kkm' => $p['kkm'],
            ]);
        }

        // =============================================
        // 9. NILAI (Nilai siswa)
        // =============================================
        // Isi nilai untuk Pengampu pertama (Matematika X MIPA 1) → siswa 1-5
        $nilaiSeed = [
            ['tugas' => 85, 'uh' => 80, 'uts' => 75, 'uas' => 88, 'praktik' => 90, 'proyek' => 85, 'portofolio' => 88, 'spiritual' => 'A', 'sosial' => 'B'],
            ['tugas' => 92, 'uh' => 90, 'uts' => 95, 'uas' => 92, 'praktik' => 95, 'proyek' => 94, 'portofolio' => 92, 'spiritual' => 'A', 'sosial' => 'A'],
            ['tugas' => 70, 'uh' => 65, 'uts' => 60, 'uas' => 72, 'praktik' => 75, 'proyek' => 70, 'portofolio' => 72, 'spiritual' => 'B', 'sosial' => 'B'],
            ['tugas' => 88, 'uh' => 85, 'uts' => 80, 'uas' => 82, 'praktik' => 85, 'proyek' => 88, 'portofolio' => 84, 'spiritual' => 'A', 'sosial' => 'A'],
            ['tugas' => 75, 'uh' => 78, 'uts' => 82, 'uas' => 70, 'praktik' => 80, 'proyek' => 75, 'portofolio' => 78, 'spiritual' => 'B', 'sosial' => 'B'],
        ];

        foreach ($nilaiSeed as $i => $n) {
            Nilai::create([
                'pengampu_id' => $pengampuList[0]->id,  // Matematika X MIPA 1
                'siswa_id' => $siswaList[$i]->id,
                'tugas' => $n['tugas'],
                'ulangan_harian' => $n['uh'],
                'uts' => $n['uts'],
                'uas' => $n['uas'],
                'praktik' => $n['praktik'],
                'proyek' => $n['proyek'],
                'portofolio' => $n['portofolio'],
                'sikap_spiritual' => $n['spiritual'],
                'sikap_sosial' => $n['sosial'],
            ]);
        }

        // Nilai untuk Pengampu ketiga (Bahasa Indonesia X MIPA 1) → siswa 1-5
        $nilaiBin = [
            ['tugas' => 80, 'uh' => 82, 'uts' => 78, 'uas' => 85, 'praktik' => 82, 'proyek' => 80, 'portofolio' => 85, 'spiritual' => 'A', 'sosial' => 'B'],
            ['tugas' => 90, 'uh' => 88, 'uts' => 92, 'uas' => 90, 'praktik' => 88, 'proyek' => 90, 'portofolio' => 89, 'spiritual' => 'A', 'sosial' => 'A'],
            ['tugas' => 72, 'uh' => 68, 'uts' => 65, 'uas' => 70, 'praktik' => 70, 'proyek' => 72, 'portofolio' => 68, 'spiritual' => 'B', 'sosial' => 'C'],
            ['tugas' => 85, 'uh' => 88, 'uts' => 82, 'uas' => 86, 'praktik' => 84, 'proyek' => 86, 'portofolio' => 82, 'spiritual' => 'A', 'sosial' => 'A'],
            ['tugas' => 78, 'uh' => 75, 'uts' => 80, 'uas' => 76, 'praktik' => 78, 'proyek' => 76, 'portofolio' => 80, 'spiritual' => 'B', 'sosial' => 'B'],
        ];

        foreach ($nilaiBin as $i => $n) {
            Nilai::create([
                'pengampu_id' => $pengampuList[2]->id,  // Bahasa Indonesia X MIPA 1
                'siswa_id' => $siswaList[$i]->id,
                'tugas' => $n['tugas'],
                'ulangan_harian' => $n['uh'],
                'uts' => $n['uts'],
                'uas' => $n['uas'],
                'praktik' => $n['praktik'],
                'proyek' => $n['proyek'],
                'portofolio' => $n['portofolio'],
                'sikap_spiritual' => $n['spiritual'],
                'sikap_sosial' => $n['sosial'],
            ]);
        }

        // =============================================
        // 10. PRESENSI (Presensi harian)
        // =============================================
        // Presensi untuk Matematika X MIPA 1, beberapa tanggal
        $tanggalPresensi = ['2026-04-07', '2026-04-14', '2026-04-21'];
        $statusOptions = ['hadir', 'hadir', 'hadir', 'hadir', 'hadir', 'izin', 'tidak_hadir', 'sakit'];

        foreach ($tanggalPresensi as $tgl) {
            for ($i = 0; $i < 5; $i++) {
                $status = ($i === 3 && $tgl === '2026-04-14') ? 'izin' :
                          (($i === 4 && $tgl === '2026-04-21') ? 'sakit' : 'hadir');

                Presensi::create([
                    'pengampu_id' => $pengampuList[0]->id,
                    'siswa_id' => $siswaList[$i]->id,
                    'tanggal' => $tgl,
                    'status' => $status,
                    'keterangan' => $status === 'izin' ? 'Izin keluarga' :
                                   ($status === 'sakit' ? 'Sakit demam' : null),
                ]);
            }
        }

        $this->command->info('✅ Seeder berhasil! Data dummy sudah di-generate.');
        $this->command->info('   📊 ' . Guru::count() . ' guru');
        $this->command->info('   📊 ' . Siswa::count() . ' siswa');
        $this->command->info('   📊 ' . Kelas::count() . ' kelas');
        $this->command->info('   📊 ' . Mapel::count() . ' mapel');
        $this->command->info('   📊 ' . Pengampu::count() . ' pengampu');
        $this->command->info('   📊 ' . Nilai::count() . ' nilai');
        $this->command->info('   📊 ' . Presensi::count() . ' presensi');
        $this->command->info('   📊 ' . User::count() . ' user (Admin: 12345678/12345678, Guru: Login menggunakan NIP)');
    }
}
