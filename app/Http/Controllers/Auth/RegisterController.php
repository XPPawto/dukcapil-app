<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Citizen;
use App\Rules\ValidNik;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules\Password;

class RegisterController extends Controller
{
    public function create()
    {
        return view('auth.register');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_lengkap' => ['required', 'string', 'min:3', 'max:100', 'regex:/^[\pL\s\'\.\-]+$/u'],
            'nik' => ['required', new ValidNik],
            'tanggal_lahir' => ['required', 'date', 'before:today'],
            'email' => ['required', 'email', 'unique:citizens,email'],
            'password' => ['required', 'confirmed', Password::min(8)->mixedCase()->numbers()],
            'persetujuan' => ['accepted'],
        ], [
            'nama_lengkap.regex' => 'Nama hanya boleh berisi huruf, spasi, dan tanda baca umum.',
        ]);

        $citizen = Citizen::create([
            'full_name' => $validated['nama_lengkap'],
            'nik' => $validated['nik'],
            'nik_hash' => Citizen::hashNik($validated['nik']),
            'dob' => $validated['tanggal_lahir'],
            'email' => $validated['email'],
            'password' => $validated['password'],
            'status' => 'active',
        ]);

        return redirect()
            ->route('register.success')
            ->with('nama', $citizen->full_name);
    }

    public function success()
    {
        if (! session('nama')) {
            return redirect()->route('register');
        }

        return view('auth.register-success', [
            'nama' => session('nama'),
        ]);
    }
}
