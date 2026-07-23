<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Support\DemoData;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $citizens = collect(DemoData::citizens());

        if ($status = $request->query('status')) {
            $citizens = $citizens->where('status', $status);
        }

        if ($search = $request->query('cari')) {
            $needle = strtolower($search);
            $citizens = $citizens->filter(
                fn ($item) => str_contains(strtolower($item['nama']), $needle)
                    || str_contains(strtolower($item['login_id']), $needle)
                    || str_contains(strtolower($item['nik']), $needle)
            );
        }

        return view('admin.users.index', [
            'citizens' => $citizens->values(),
            'search' => $search ?? '',
            'statusFilter' => $status ?? '',
        ]);
    }

    public function resetPassword(Request $request, int $id)
    {
        $request->validate([
            'admin_password' => ['required', 'string'],
            'password_baru' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        return redirect()
            ->route('admin.users.index')
            ->with('status', 'Password warga berhasil direset. Tindakan ini telah tercatat di Audit Log.');
    }

    public function unlock(Request $request, int $id)
    {
        $request->validate(['admin_password' => ['required', 'string']]);

        return redirect()
            ->route('admin.users.index')
            ->with('status', 'Akun warga berhasil dibuka kembali.');
    }
}
