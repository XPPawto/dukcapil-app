<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\Citizen;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    public function create()
    {
        return view('auth.login');
    }

    public function store(Request $request)
    {
        $credentials = $request->validate([
            'identifier' => ['required', 'string'],
            'password' => ['required', 'string'],
        ]);

        $identifier = trim($credentials['identifier']);
        $password = $credentials['password'];

        $admin = Admin::where('username', $identifier)->first();

        if ($admin && $admin->status === 'active' && Hash::check($password, $admin->password)) {
            Auth::guard('admin')->login($admin);
            $request->session()->regenerate();

            return redirect()->route('admin.dashboard')->with('status', 'Berhasil masuk ke Dashboard Admin.');
        }

        if (ctype_digit($identifier) && strlen($identifier) === 16) {
            $citizen = Citizen::findByNik($identifier);

            if ($citizen) {
                if ($citizen->isLockedOut()) {
                    return back()
                        ->withErrors(['identifier' => 'Akun Anda terkunci sementara karena terlalu banyak percobaan gagal. Silakan coba lagi nanti atau hubungi petugas.'])
                        ->onlyInput('identifier');
                }

                if ($citizen->status === 'locked' && ! $citizen->isLockedOut()) {
                    $citizen->forceFill(['status' => 'active', 'failed_login_attempts' => 0, 'locked_until' => null])->save();
                }

                if ($citizen->status === 'active' && Hash::check($password, $citizen->password)) {
                    $citizen->forceFill(['failed_login_attempts' => 0, 'locked_until' => null])->save();

                    Auth::guard('citizen')->login($citizen);
                    $request->session()->regenerate();

                    return redirect()->route('warga.dashboard')->with('status', 'Berhasil masuk. Selamat datang kembali!');
                }

                if ($citizen->status === 'active') {
                    $attempts = $citizen->failed_login_attempts + 1;

                    if ($attempts >= 5) {
                        $citizen->forceFill([
                            'failed_login_attempts' => $attempts,
                            'status' => 'locked',
                            'locked_until' => now()->addMinutes(15),
                        ])->save();

                        return back()
                            ->withErrors(['identifier' => 'Terlalu banyak percobaan gagal. Akun Anda dikunci selama 15 menit.'])
                            ->onlyInput('identifier');
                    }

                    $citizen->forceFill(['failed_login_attempts' => $attempts])->save();
                }
            }
        }

        return back()
            ->withErrors(['identifier' => 'NIK/Username atau Password salah.'])
            ->onlyInput('identifier');
    }

    public function destroy(Request $request)
    {
        Auth::guard('citizen')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('welcome')->with('status', 'Anda telah keluar dari akun.');
    }
}
