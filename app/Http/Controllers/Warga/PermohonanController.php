<?php

namespace App\Http\Controllers\Warga;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class PermohonanController extends Controller
{
    public function pilih()
    {
        return view('warga.permohonan.pilih');
    }

    public function formKk()
    {
        return view('warga.permohonan.form-kk');
    }

    public function formAktaLahir()
    {
        return view('warga.permohonan.form-akta-lahir');
    }

    public function formAktaMati()
    {
        return view('warga.permohonan.form-akta-mati');
    }

    public function store(Request $request, string $jenis)
    {
        abort_unless(in_array($jenis, ['kk', 'akta-lahir', 'akta-mati']), Response::HTTP_NOT_FOUND);

        // TODO(Magang 1 - Pengajuan Dokumen): validasi input sesuai $jenis layanan
        // (kk / akta-lahir / akta-mati), simpan ke tabel submissions + submission_files,
        // lalu redirect ke halaman riwayat dengan nomor tiketnya.
        // Panduan lengkap ada di docs/magang/01-pengajuan-dokumen.md

        return back()->with('status', 'Fitur pengajuan dokumen sedang dikerjakan tim magang.');
    }

    public function riwayat(Request $request)
    {
        // TODO(Magang 1 - Pengajuan Dokumen): ambil daftar permohonan milik warga yang
        // sedang login, dukung filter status & pencarian nomor tiket lewat query string.
        // Panduan lengkap ada di docs/magang/01-pengajuan-dokumen.md

        return view('warga.permohonan.riwayat', [
            'submissions' => collect(),
            'search' => $request->query('cari', ''),
            'statusFilter' => $request->query('status', ''),
        ]);
    }

    public function show(string $ticket)
    {
        // TODO(Magang 1 - Pengajuan Dokumen): ambil satu permohonan milik warga yang
        // sedang login berdasarkan nomor tiket ($ticket), lalu tampilkan detailnya.
        // Panduan lengkap ada di docs/magang/01-pengajuan-dokumen.md

        abort(404);
    }
}
