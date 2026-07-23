<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Support\DemoData;
use Illuminate\Http\Request;

class VerifikasiController extends Controller
{
    public function index(Request $request)
    {
        $submissions = collect(DemoData::submissions());

        if ($status = $request->query('status')) {
            $submissions = $submissions->where('status', $status);
        }

        if ($search = $request->query('cari')) {
            $needle = strtolower($search);
            $submissions = $submissions->filter(
                fn ($item) => str_contains(strtolower($item['ticket_number']), $needle)
                    || str_contains(strtolower($item['nik']), $needle)
            );
        }

        return view('admin.verifikasi.index', [
            'submissions' => $submissions->values(),
            'search' => $search ?? '',
            'statusFilter' => $status ?? '',
        ]);
    }

    public function show(string $ticket)
    {
        $submission = collect(DemoData::submissions())
            ->firstWhere('ticket_number', $ticket) ?? DemoData::submissions()[0];

        return view('admin.verifikasi.detail', compact('submission'));
    }

    public function updateStatus(Request $request, string $ticket)
    {
        $request->validate([
            'status' => ['required', 'in:IN_REVIEW,APPROVED,REJECTED'],
            'catatan' => ['required_if:status,REJECTED', 'nullable', 'string'],
        ]);

        return redirect()
            ->route('admin.verifikasi.index')
            ->with('status', "Status pengajuan {$ticket} berhasil diperbarui.");
    }
}
