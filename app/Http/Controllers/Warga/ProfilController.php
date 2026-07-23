<?php

namespace App\Http\Controllers\Warga;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ProfilController extends Controller
{
    public function edit()
    {
        $profil = [
            'nama' => session('warga_nama', 'Suratno Wijaya'),
            'login_id' => 'suratnowijaya',
            'nik' => '1671052501850003',
            'tanggal_lahir' => '25 Januari 1985',
            'email' => 'suratno.w@gmail.com',
        ];

        return view('warga.profil', compact('profil'));
    }

    public function updateEmail(Request $request)
    {
        $request->validate(['email' => ['required', 'email']]);

        return redirect()->route('warga.profil')->with('status', 'Email berhasil diperbarui.');
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'password_lama' => ['required'],
            'password_baru' => ['required', 'min:8', 'confirmed'],
        ]);

        return redirect()->route('warga.profil')->with('status', 'Password berhasil diubah.');
    }
}
