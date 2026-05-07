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
use App\Models\WaliKelas;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        DB::beginTransaction();
        try {
            // =============================================
            // 1. TAHUN AJARAN & SEMESTER
            // =============================================
            // =============================================
            // 1. TAHUN AJARAN & SEMESTER
            // =============================================
            $ta = TahunAjaran::updateOrCreate(
                ['nama' => '2025/2026'],
                [
                    'tanggal_mulai' => '2025-07-14',
                    'tanggal_selesai' => '2026-06-20',
                    'is_aktif' => true,
                ]
            );

            // Buat Ganjil & Genap agar konsisten dengan fitur filter
            $smtGanjil = Semester::updateOrCreate(
                ['tahun_ajaran_id' => $ta->id, 'semester' => 'Ganjil'],
                ['is_aktif' => false]
            );

            $smtGenap = Semester::updateOrCreate(
                ['tahun_ajaran_id' => $ta->id, 'semester' => 'Genap'],
                ['is_aktif' => true]
            );

            // =============================================
            // 2. GURU
            // =============================================
            $guruData = [
                ['nip' => '198501012010011001', 'nama_guru' => 'Drs. Ahmad Fauzi, M.Pd.',    'jenis_kelamin' => 'Laki-laki',  'no_hp' => '081234567801'],
                ['nip' => '198602022011012002', 'nama_guru' => 'Sri Wahyuni, S.Pd.',           'jenis_kelamin' => 'Perempuan',  'no_hp' => '081234567802'],
                ['nip' => '198703032012011003', 'nama_guru' => 'Bambang Supriyadi, S.Pd.',     'jenis_kelamin' => 'Laki-laki',  'no_hp' => '081234567803'],
                ['nip' => '198804042013012004', 'nama_guru' => 'Dewi Kartika Sari, M.Pd.',     'jenis_kelamin' => 'Perempuan',  'no_hp' => '081234567804'],
            ];

            $gurus = [];
            foreach ($guruData as $g) {
                $gurus[] = Guru::updateOrCreate(['nip' => $g['nip']], $g);
            }

            // =============================================
            // 3. USER
            // =============================================
            User::updateOrCreate(
                ['username' => '12345678'],
                [
                    'nama' => 'Administrator',
                    'email' => 'admin@sekolah.sch.id',
                    'password' => Hash::make('12345678'),
                    'role' => 'admin',
                ]
            );

            foreach ($gurus as $guru) {
                User::updateOrCreate(
                    ['username' => $guru->nip],
                    [
                        'nama' => $guru->nama_guru,
                        'email' => strtolower(explode(' ', $guru->nama_guru)[0]) . '@sekolah.sch.id',
                        'password' => Hash::make($guru->nip),
                        'role' => 'guru',
                        'guru_id' => $guru->id,
                    ]
                );
            }

            // =============================================
            // 4. KELAS & WALI KELAS (Histori)
            // =============================================
            $kelasData = [
                ['kode_kelas' => 'X-MIPA-1',  'nama_kelas' => 'X MIPA 1',    'tingkat' => 'X'],
                ['kode_kelas' => 'X-MIPA-2',  'nama_kelas' => 'X MIPA 2',    'tingkat' => 'X'],
                ['kode_kelas' => 'XI-MIPA-1', 'nama_kelas' => 'XI MIPA 1',   'tingkat' => 'XI'],
            ];

            $kelasList = [];
            foreach ($kelasData as $i => $k) {
                $kelas = Kelas::updateOrCreate(['kode_kelas' => $k['kode_kelas']], $k);
                $kelasList[] = $kelas;
                
                // Assign Wali Kelas
                WaliKelas::updateOrCreate(
                    ['kelas_id' => $kelas->id, 'semester_id' => $smtGenap->id],
                    ['guru_id' => $gurus[$i]->id]
                );
            }

            // =============================================
            // 5. MAPEL
            // =============================================
            $mapelList = [
                Mapel::updateOrCreate(['kode_mapel' => 'MTK'], ['nama_mapel' => 'Matematika', 'kelompok' => 'Wajib']),
                Mapel::updateOrCreate(['kode_mapel' => 'BIN'], ['nama_mapel' => 'Bahasa Indonesia', 'kelompok' => 'Wajib']),
            ];

            // =============================================
            // 6. SISWA
            // =============================================
            $siswaList = [];
            for ($i = 1; $i <= 10; $i++) {
                $nis = '202500' . $i;
                $siswaList[] = Siswa::updateOrCreate(
                    ['nis' => $nis],
                    [
                        'nama_siswa' => 'Siswa Contoh ' . $i,
                        'jenis_kelamin' => $i % 2 == 0 ? 'Perempuan' : 'Laki-laki',
                        'status' => 'Aktif'
                    ]
                );
            }

            // =============================================
            // 7. KELAS_SISWA (Penempatan)
            // =============================================
            $ksList = [];
            foreach ($siswaList as $index => $siswa) {
                $kelasIdx = $index < 5 ? 0 : 1; 
                $ksList[] = KelasSiswa::updateOrCreate(
                    ['siswa_id' => $siswa->id, 'semester_id' => $smtGenap->id],
                    ['kelas_id' => $kelasList[$kelasIdx]->id]
                );
            }

            // =============================================
            // 8. PENGAMPU
            // =============================================
            $pengampuList = [
                Pengampu::updateOrCreate(
                    ['guru_id' => $gurus[0]->id, 'mapel_id' => $mapelList[0]->id, 'kelas_id' => $kelasList[0]->id, 'semester_id' => $smtGenap->id],
                    ['kkm' => 75, 'status' => 'Aktif']
                ),
                Pengampu::updateOrCreate(
                    ['guru_id' => $gurus[1]->id, 'mapel_id' => $mapelList[1]->id, 'kelas_id' => $kelasList[0]->id, 'semester_id' => $smtGenap->id],
                    ['kkm' => 75, 'status' => 'Aktif']
                ),
            ];

            // =============================================
            // 9. NILAI (Vertikal)
            // =============================================
            $jenisNilai = ['p_tugas', 'p_uh', 'p_uts', 'p_uas', 'k_praktik', 's_spiritual', 's_sosial'];
            
            foreach ($ksList as $ks) {
                if ($ks->kelas_id == $kelasList[0]->id) {
                    foreach ($pengampuList as $pengampu) {
                        foreach ($jenisNilai as $jenis) {
                            $skor = strpos($jenis, 's_') === 0 ? rand(3, 4) : rand(70, 95);
                            Nilai::updateOrCreate(
                                ['kelas_siswa_id' => $ks->id, 'pengampu_id' => $pengampu->id, 'jenis_nilai' => $jenis],
                                ['skor' => $skor]
                            );
                        }
                        // Tambahkan catatan
                        Nilai::updateOrCreate(
                            ['kelas_siswa_id' => $ks->id, 'pengampu_id' => $pengampu->id, 'jenis_nilai' => 'catatan'],
                            ['skor' => 0, 'catatan_guru' => 'Siswa menunjukkan perkembangan yang sangat baik.']
                        );
                    }
                }
            }
            
            DB::commit();
            $this->command->info('✅ Database berhasil di-seed dengan struktur Normalized!');

        } catch (\Exception $e) {
            DB::rollBack();
            $this->command->error('❌ Gagal seeding: ' . $e->getMessage());
        }
    }
}
