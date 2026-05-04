<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UbahKataSandiController extends Controller
{
    public function showUbahKataSandi() {
        return view('pages.ubah_kata_sandi');
    }

    public function updatePassword(Request $request) {
        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|min:8|confirmed',
        ]);

        $user = auth()->user();

        // Cek apakah password lama cocok
        if (!\Illuminate\Support\Facades\Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'Kata sandi saat ini tidak cocok.']);
        }

        // Update password baru
        $user->update([
            'password' => \Illuminate\Support\Facades\Hash::make($request->new_password)
        ]);

        return back()->with('status', 'Kata sandi berhasil diperbarui!');
    }
}
