<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Citizen;
use App\Rules\ValidNik;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules\Password;
use Illuminate\Validation\ValidationException;

class RegisterController extends Controller
{
    public function create()
    {
        return view('auth.register');
    }

    public function store(Request $request)
    {
        $request->validate([
            'lahir_tanggal' => ['required', 'integer', 'between:1,31'],
            'lahir_bulan' => ['required', 'integer', 'between:1,12'],
            'lahir_tahun' => ['required', 'integer', 'between:'.(now()->year - 100).','.now()->year],
        ]);

        [$tanggal, $bulan, $tahun] = [
            (int) $request->lahir_tanggal,
            (int) $request->lahir_bulan,
            (int) $request->lahir_tahun,
        ];

        if (! checkdate($bulan, $tanggal, $tahun)) {
            throw ValidationException::withMessages([
                'tanggal_lahir' => 'Tanggal lahir yang dipilih tidak valid.',
            ]);
        }

        $request->merge([
            'tanggal_lahir' => sprintf('%04d-%02d-%02d', $tahun, $bulan, $tanggal),
        ]);

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
