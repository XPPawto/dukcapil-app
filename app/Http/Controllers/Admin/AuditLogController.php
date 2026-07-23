<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Auth;

class AuditLogController extends Controller
{
    public function index()
    {
        abort_unless(Auth::guard('admin')->user()->role === 'super_admin', 403);

        // TODO(Magang 3 - Manajemen User): ambil daftar AuditLog terbaru, dipaginasi.
        // Panduan lengkap ada di docs/magang/03-manajemen-user-audit-log.md

        return view('admin.audit-logs.index', [
            'logs' => new LengthAwarePaginator([], 0, 30),
        ]);
    }
}
