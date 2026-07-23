<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Citizen;
use Illuminate\Http\Request;

class UserController extends Controller
{
    private const STATUS_MAP = [
        'active' => 'Aktif',
        'inactive' => 'Tidak Aktif',
        'locked' => 'Terkunci',
    ];

    public function index(Request $request)
    {
        // TODO(Magang 3 - Manajemen User): ambil daftar semua warga terdaftar,
        // dukung filter status & pencarian (nama, atau NIK 16 digit lewat Citizen::hashNik()).
        // Panduan lengkap ada di docs/magang/03-manajemen-user-audit-log.md

        return view('admin.users.index', [
            'citizens' => collect(),
            'statusLabels' => self::STATUS_MAP,
            'search' => $request->query('cari', ''),
            'statusFilter' => $request->query('status', ''),
        ]);
    }

    public function resetPassword(Request $request, Citizen $citizen)
    {
        // TODO(Magang 3 - Manajemen User): minta admin memasukkan ulang password-nya sendiri
        // (step-up auth via Hash::check), lalu set password baru untuk $citizen dan catat ke AuditLog.
        // Panduan lengkap ada di docs/magang/03-manajemen-user-audit-log.md

        return back()->with('status', 'Fitur reset password sedang dikerjakan tim magang.');
    }

    public function unlock(Request $request, Citizen $citizen)
    {
        // TODO(Magang 3 - Manajemen User): minta admin memasukkan ulang password-nya sendiri,
        // lalu buka kembali akun $citizen (status, failed_login_attempts, locked_until) dan catat ke AuditLog.
        // Panduan lengkap ada di docs/magang/03-manajemen-user-audit-log.md

        return back()->with('status', 'Fitur buka kunci akun sedang dikerjakan tim magang.');
    }
}
