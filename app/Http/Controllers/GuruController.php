<?php

namespace App\Http\Controllers;

use App\Models\Guru;
use Illuminate\Http\Request;

class GuruController extends Controller
{
    public function showGuru()
    {
        $guruData = Guru::orderBy('nama_guru')->paginate(20);

        return view('pages.data_guru', compact('guruData'));
    }
}