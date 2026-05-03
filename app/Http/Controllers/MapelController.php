<?php

namespace App\Http\Controllers;

use App\Models\Mapel;
use Illuminate\Http\Request;

class MapelController extends Controller
{
    public function showMapel()
    {
        $mapelData = Mapel::orderBy('nama_mapel')->paginate(20);

        return view('pages.data_mapel', compact('mapelData'));
    }
}
