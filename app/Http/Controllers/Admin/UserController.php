<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AuditLog;
use App\Models\Citizen;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class UserController extends Controller
{
    private const STATUS_MAP = [
        'active' => 'Aktif',
        'inactive' => 'Tidak Aktif',
        'locked' => 'Terkunci',
    ];

    public function index(Request $request)
    {
        $query = Citizen::query()->latest();

        if ($status = $request->query('status')) {
            $query->where('status', $status);
        }

        if ($search = $request->query('cari')) {
            if (ctype_digit($search) && strlen($search) === 16) {
                $query->where('nik_hash', Citizen::hashNik($search));
            } else {
                $query->where('full_name', 'like', "%{$search}%");
            }
        }

        return view('admin.users.index', [
            'citizens' => $query->get(),
            'statusLabels' => self::STATUS_MAP,
            'search' => $search ?? '',
            'statusFilter' => $status ?? '',
        ]);
    }

    public function resetPassword(Request $request, Citizen $citizen)
    {
        $admin = Auth::guard('admin')->user();

        $validated = $request->validate([
            'admin_password' => ['required', 'string'],
            'password_baru' => ['required', 'confirmed', Password::min(8)->mixedCase()->numbers()],
        ]);

        if (! Hash::check($validated['admin_password'], $admin->password)) {
            return back()->withErrors(['admin_password' => 'Password Anda salah. Reset dibatalkan.']);
        }

        $citizen->forceFill([
            'password' => $validated['password_baru'],
            'status' => 'active',
            'failed_login_attempts' => 0,
            'locked_until' => null,
        ])->save();

        AuditLog::record($admin, 'reset_password', 'citizen', $citizen->id, $citizen->full_name, $request);

        return redirect()
            ->route('admin.users.index')
            ->with('status', 'Password warga berhasil direset. Tindakan ini telah tercatat di Audit Log.');
    }

    public function unlock(Request $request, Citizen $citizen)
    {
        $admin = Auth::guard('admin')->user();

        $validated = $request->validate(['admin_password' => ['required', 'string']]);

        if (! Hash::check($validated['admin_password'], $admin->password)) {
            return back()->withErrors(['admin_password' => 'Password Anda salah. Tindakan dibatalkan.']);
        }

        $citizen->forceFill(['status' => 'active', 'failed_login_attempts' => 0, 'locked_until' => null])->save();

        AuditLog::record($admin, 'unlock_account', 'citizen', $citizen->id, $citizen->full_name, $request);

        return redirect()
            ->route('admin.users.index')
            ->with('status', 'Akun warga berhasil dibuka kembali.');
    }
}
