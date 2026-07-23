<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class RegisterController extends Controller
{
    public function create()
    {
        return view('auth.register');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_lengkap' => ['required', 'string', 'min:3', 'max:100'],
            'nik' => ['required', 'digits:16'],
            'tanggal_lahir' => ['required', 'date'],
            'email' => ['required', 'email'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'persetujuan' => ['accepted'],
        ]);

        $loginId = strtolower(str_replace(' ', '', $validated['nama_lengkap']));

        return redirect()
            ->route('register.success')
            ->with('login_id', $loginId)
            ->with('nama', $validated['nama_lengkap']);
    }

    public function success()
    {
        if (! session('login_id')) {
            return redirect()->route('register');
        }

        return view('auth.register-success', [
            'loginId' => session('login_id'),
            'nama' => session('nama'),
        ]);
    }
}
