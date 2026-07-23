<?php

namespace App\Http\Controllers\Warga;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;

class ProfilController extends Controller
{
    public function edit()
    {
        $citizen = Auth::guard('citizen')->user();

        $profil = [
            'nama' => $citizen->full_name,
            'nik' => $citizen->maskedNik(),
            'tanggal_lahir' => $citizen->dob->translatedFormat('d F Y'),
            'email' => $citizen->email,
        ];

        return view('warga.profil', compact('profil'));
    }

    public function updateEmail(Request $request)
    {
        $citizen = Auth::guard('citizen')->user();

        $validated = $request->validate([
            'email' => ['required', 'email', Rule::unique('citizens', 'email')->ignore($citizen->id)],
        ]);

        $citizen->update(['email' => $validated['email']]);

        return redirect()->route('warga.profil')->with('status', 'Email berhasil diperbarui.');
    }

    public function updatePassword(Request $request)
    {
        $citizen = Auth::guard('citizen')->user();

        $validated = $request->validate([
            'password_lama' => ['required'],
            'password_baru' => ['required', 'confirmed', Password::min(8)->mixedCase()->numbers()],
        ]);

        if (! Hash::check($validated['password_lama'], $citizen->password)) {
            return back()->withErrors(['password_lama' => 'Password saat ini salah.']);
        }

        $citizen->update(['password' => $validated['password_baru']]);

        return redirect()->route('warga.profil')->with('status', 'Password berhasil diubah.');
    }
}
