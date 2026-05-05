<?php

namespace App\Http\Controllers;

use App\Models\Mapel;
use Illuminate\Http\Request;

class MapelController extends Controller
{
    public function showMapel(Request $request)
    {
        $query = Mapel::query();

        if ($request->filled('search')) {
            $query->where('nama_mapel', 'like', '%' . $request->search . '%')
                  ->orWhere('kode_mapel', 'like', '%' . $request->search . '%');
        }

        if ($request->filled('kelompok')) {
            $query->where('kelompok', $request->kelompok);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $mapelData = $query->orderBy('nama_mapel')->paginate(20)->withQueryString();

        return view('pages.data_mapel', compact('mapelData'));
    }
}
