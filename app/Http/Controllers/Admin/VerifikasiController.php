<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class VerifikasiController extends Controller
{
    public function index(Request $request)
    {
        // TODO(Magang 2 - Verifikasi Admin): ambil daftar semua permohonan (semua warga),
        // dukung filter status & pencarian (nomor tiket, atau NIK 16 digit lewat Citizen::findByNik()).
        // Panduan lengkap ada di docs/magang/02-verifikasi-admin.md

        return view('admin.verifikasi.index', [
            'submissions' => collect(),
            'search' => $request->query('cari', ''),
            'statusFilter' => $request->query('status', ''),
        ]);
    }

    public function show(string $ticket)
    {
        // TODO(Magang 2 - Verifikasi Admin): ambil satu permohonan (dengan relasi citizen & files)
        // berdasarkan nomor tiket ($ticket), lalu tampilkan detailnya untuk direview petugas.
        // Panduan lengkap ada di docs/magang/02-verifikasi-admin.md

        abort(404);
    }

    public function updateStatus(Request $request, string $ticket)
    {
        // TODO(Magang 2 - Verifikasi Admin): validasi status baru (IN_REVIEW/APPROVED/REJECTED)
        // + catatan, update permohonan, simpan file hasil PDF jika APPROVED, dan catat ke AuditLog
        // lewat AuditLog::record(). Panduan lengkap ada di docs/magang/02-verifikasi-admin.md

        return back()->with('status', 'Fitur verifikasi sedang dikerjakan tim magang.');
    }
}
