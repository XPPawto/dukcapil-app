<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AuditLog;
use App\Models\Citizen;
use App\Models\Submission;
use App\Models\SubmissionFile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class VerifikasiController extends Controller
{
    public function index(Request $request)
    {
        $query = Submission::with('citizen')->latest();

        if ($status = $request->query('status')) {
            $query->where('status', $status);
        }

        if ($search = $request->query('cari')) {
            if (ctype_digit($search) && strlen($search) === 16) {
                $citizen = Citizen::findByNik($search);
                $query->where('citizen_id', $citizen?->id ?? 0);
            } else {
                $query->where('ticket_number', 'like', "%{$search}%");
            }
        }

        return view('admin.verifikasi.index', [
            'submissions' => $query->get(),
            'search' => $search ?? '',
            'statusFilter' => $status ?? '',
        ]);
    }

    public function show(string $ticket)
    {
        $submission = Submission::with(['citizen', 'files'])
            ->where('ticket_number', $ticket)
            ->firstOrFail();

        return view('admin.verifikasi.detail', compact('submission'));
    }

    public function updateStatus(Request $request, string $ticket)
    {
        $submission = Submission::where('ticket_number', $ticket)->firstOrFail();

        $validated = $request->validate([
            'status' => ['required', 'in:IN_REVIEW,APPROVED,REJECTED'],
            'catatan' => ['required_if:status,REJECTED', 'nullable', 'string', 'max:1000'],
            'hasil_pdf' => ['nullable', 'file', 'mimes:pdf', 'max:5120'],
        ]);

        $admin = Auth::guard('admin')->user();

        DB::transaction(function () use ($submission, $validated, $admin, $request) {
            $submission->update([
                'status' => $validated['status'],
                'note' => $validated['catatan'] ?? null,
                'reviewed_by' => $admin->id,
                'reviewed_at' => now(),
            ]);

            if ($validated['status'] === 'APPROVED' && $request->hasFile('hasil_pdf')) {
                $file = $request->file('hasil_pdf');
                $storageKey = "submissions/{$submission->id}/result-".Str::uuid().'.pdf';
                $file->storeAs('', $storageKey, 'local');

                SubmissionFile::create([
                    'submission_id' => $submission->id,
                    'file_type' => 'result',
                    'field_name' => 'hasil_pdf',
                    'storage_key' => $storageKey,
                    'original_name' => $file->getClientOriginalName(),
                    'mime_type' => $file->getMimeType(),
                    'size' => $file->getSize(),
                    'uploaded_by_type' => 'admin',
                    'uploaded_by_id' => $admin->id,
                ]);
            }

            AuditLog::record(
                $admin,
                'update_submission_status',
                'submission',
                $submission->id,
                "Tiket {$submission->ticket_number} → {$validated['status']}",
                $request
            );
        });

        return redirect()
            ->route('admin.verifikasi.index')
            ->with('status', "Status pengajuan {$ticket} berhasil diperbarui.");
    }
}
