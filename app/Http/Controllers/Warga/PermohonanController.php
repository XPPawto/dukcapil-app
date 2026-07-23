<?php

namespace App\Http\Controllers\Warga;

use App\Http\Controllers\Controller;
use App\Support\DemoData;
use Illuminate\Http\Request;

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
        $prefix = ['kk' => 'KK', 'akta-lahir' => 'AL', 'akta-mati' => 'AM'][$jenis] ?? 'PM';
        $ticket = $prefix.'-'.now()->format('Ymd').'-'.random_int(1000, 9999);

        return redirect()
            ->route('warga.permohonan.riwayat')
            ->with('status', "Permohonan berhasil dikirim. Nomor tiket Anda: {$ticket}. Simpan nomor ini untuk melacak status.");
    }

    public function riwayat(Request $request)
    {
        $submissions = collect(DemoData::submissions());

        if ($status = $request->query('status')) {
            $submissions = $submissions->where('status', $status);
        }

        if ($search = $request->query('cari')) {
            $submissions = $submissions->filter(
                fn ($item) => str_contains(strtolower($item['ticket_number']), strtolower($search))
            );
        }

        return view('warga.permohonan.riwayat', [
            'submissions' => $submissions->values(),
            'search' => $search ?? '',
            'statusFilter' => $status ?? '',
        ]);
    }

    public function show(string $ticket)
    {
        $submission = collect(DemoData::submissions())
            ->firstWhere('ticket_number', $ticket) ?? DemoData::submissions()[0];

        return view('warga.permohonan.detail', compact('submission'));
    }
}
