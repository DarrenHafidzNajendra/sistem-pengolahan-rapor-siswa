<?php

namespace App\Http\Controllers;

use App\Models\TahunAjaran;
use App\Models\Semester;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AkademikController extends Controller
{
    public function index()
    {
        $tahunAjaran = TahunAjaran::with('semester')->orderBy('nama', 'desc')->get();
        return view('pages.akademik', compact('tahunAjaran'));
    }

    public function storeTahunAjaran(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|unique:tahun_ajaran,nama',
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'required|date|after:tanggal_mulai',
        ]);

        TahunAjaran::create([
            'nama' => $request->nama,
            'tanggal_mulai' => $request->tanggal_mulai,
            'tanggal_selesai' => $request->tanggal_selesai,
            'is_aktif' => false
        ]);

        return redirect()->back()->with('success', 'Tahun ajaran berhasil ditambahkan.');
    }

    public function storeSemester(Request $request)
    {
        $request->validate([
            'tahun_ajaran_id' => 'required|exists:tahun_ajaran,id',
            'semester' => 'required|in:Ganjil,Genap',
        ]);

        // Cek apakah semester tersebut sudah ada di tahun ajaran tersebut
        $exists = Semester::where('tahun_ajaran_id', $request->tahun_ajaran_id)
            ->where('semester', $request->semester)
            ->exists();

        if ($exists) {
            return redirect()->back()->with('error', 'Semester tersebut sudah ada untuk tahun ajaran ini.');
        }

        Semester::create([
            'tahun_ajaran_id' => $request->tahun_ajaran_id,
            'semester' => $request->semester,
            'is_aktif' => false
        ]);

        return redirect()->back()->with('success', 'Semester berhasil ditambahkan.');
    }

    public function setAktif($id)
    {
        $semester = Semester::findOrFail($id);

        DB::beginTransaction();
        try {
            // Nonaktifkan semua semester dan tahun ajaran
            Semester::query()->update(['is_aktif' => false]);
            TahunAjaran::query()->update(['is_aktif' => false]);

            // Aktifkan semester terpilih dan tahun ajaran terkaitnya
            $semester->update(['is_aktif' => true]);
            $semester->tahunAjaran->update(['is_aktif' => true]);

            DB::commit();
            return redirect()->back()->with('success', "Semester {$semester->semester} {$semester->tahunAjaran->nama} sekarang aktif.");
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Gagal mengaktifkan semester: ' . $e->getMessage());
        }
    }

    public function nonaktifkanTa($id)
    {
        $ta = TahunAjaran::findOrFail($id);

        DB::beginTransaction();
        try {
            $ta->update(['is_aktif' => false]);
            $ta->semester()->update(['is_aktif' => false]);

            DB::commit();
            return redirect()->back()->with('success', "Tahun ajaran {$ta->nama} berhasil dinonaktifkan.");
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Gagal menonaktifkan tahun ajaran.');
        }
    }

    public function setAktifTa($id)
    {
        $ta = TahunAjaran::findOrFail($id);
        
        // Cari semester ganjil pada tahun tersebut, jika tidak ada buat default
        $semester = $ta->semester()->where('semester', 'Ganjil')->first();
        
        if (!$semester) {
            return redirect()->back()->with('error', 'Tahun ajaran ini belum memiliki semester Ganjil. Silakan tambah semester terlebih dahulu.');
        }

        DB::beginTransaction();
        try {
            // Reset semua
            Semester::query()->update(['is_aktif' => false]);
            TahunAjaran::query()->update(['is_aktif' => false]);

            // Aktifkan tahun ajaran dan semester ganjilnya
            $ta->update(['is_aktif' => true]);
            $semester->update(['is_aktif' => true]);

            DB::commit();
            return redirect()->back()->with('success', "Tahun ajaran {$ta->nama} diaktifkan dengan Semester Ganjil.");
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Gagal mengaktifkan tahun ajaran.');
        }
    }
}
