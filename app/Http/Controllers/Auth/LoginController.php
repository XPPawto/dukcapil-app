<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    public function create()
    {
        return view('auth.login');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'login_id' => ['required', 'string'],
            'password' => ['required', 'string'],
        ]);

        session(['warga_nama' => ucwords(preg_replace('/\d+$/', '', $validated['login_id']))]);

        return redirect()->route('warga.dashboard')->with('status', 'Berhasil masuk. Selamat datang kembali!');
    }

    public function destroy(Request $request)
    {
        $request->session()->forget('warga_nama');

        return redirect()->route('welcome')->with('status', 'Anda telah keluar dari akun.');
    }
}
