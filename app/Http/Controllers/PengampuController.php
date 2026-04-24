<?php

namespace App\Http\Controllers;

use App\Models\Pengampu;
use App\Models\Guru;
use App\Models\Mapel;
use App\Models\Kelas;
use Illuminate\Http\Request;

class PengampuController extends Controller
{
    public function showPengampu() {
        $pengampus = Pengampu::with(['guru', 'mapel', 'kelas'])->get();
        $gurus = Guru::where('status', 'Aktif')->get();
        $mapels = Mapel::where('status', 'Aktif')->get();
        $kelas = Kelas::where('status', 'Aktif')->get();
        
        return view('pages.pengampu', compact('pengampus', 'gurus', 'mapels', 'kelas'));
    }
    public function index()
{
    $pengampus = Pengampu::all();
    $mapels = Mapel::all();
    $gurus = Guru::all();
    $kelas = Kelas::all();

    return view('pages.pengampu', compact(
        'pengampus',
        'mapels',
        'gurus',
        'kelas'
    ));
}
public function store(Request $request)
{
    Pengampu::create([
        'mapel_id' => $request->mapel_id,
        'guru_id' => $request->guru_id,
        'kelas_id' => $request->kelas_id
    ]);

    return redirect()->back();
}
}
