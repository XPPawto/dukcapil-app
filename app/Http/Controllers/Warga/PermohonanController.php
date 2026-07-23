<?php

namespace App\Http\Controllers\Warga;

use App\Http\Controllers\Controller;
use App\Models\Submission;
use App\Models\SubmissionFile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Symfony\Component\HttpFoundation\Response;

class PermohonanController extends Controller
{
    private const FILE_RULES = ['file', 'mimes:jpg,jpeg,png,pdf', 'max:2048'];

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

        [$formFields, $fileFields] = match ($jenis) {
            'kk' => [
                [
                    'alasan' => ['required', 'string'],
                    'kepala_nama' => ['required', 'string', 'max:100'],
                    'kepala_nik' => ['required', 'digits:16'],
                    'anggota' => ['nullable', 'array'],
                    'anggota.*.nama' => ['nullable', 'string', 'max:100'],
                    'anggota.*.nik' => ['nullable', 'digits:16'],
                    'anggota.*.hubungan' => ['nullable', 'string', 'max:50'],
                ],
                [
                    'berkas_kk_asli' => array_merge(['required'], self::FILE_RULES),
                    'berkas_buku_nikah' => array_merge(['required'], self::FILE_RULES),
                    'berkas_ktp_pelapor' => array_merge(['required'], self::FILE_RULES),
                    'berkas_ket_lahir' => array_merge(['nullable'], self::FILE_RULES),
                ],
            ],
            'akta-lahir' => [
                [
                    'nama_anak' => ['required', 'string', 'max:100'],
                    'tempat_lahir' => ['required', 'string', 'max:100'],
                    'tanggal_lahir_anak' => ['required', 'date'],
                    'jenis_kelamin' => ['required', Rule::in(['L', 'P'])],
                    'nama_ayah' => ['required', 'string', 'max:100'],
                    'nama_ibu' => ['required', 'string', 'max:100'],
                    'nik_ayah' => ['required', 'digits:16'],
                    'nik_ibu' => ['required', 'digits:16'],
                ],
                [
                    'berkas_kk' => array_merge(['required'], self::FILE_RULES),
                    'berkas_ket_lahir' => array_merge(['required'], self::FILE_RULES),
                ],
            ],
            'akta-mati' => [
                [
                    'nama_jenazah' => ['required', 'string', 'max:100'],
                    'nik_jenazah' => ['required', 'digits:16'],
                    'tanggal_meninggal' => ['required', 'date'],
                    'jam_meninggal' => ['required'],
                    'lokasi_meninggal' => ['required', 'string', 'max:150'],
                    'penyebab' => ['nullable', 'string', 'max:150'],
                ],
                [
                    'berkas_ket_kematian' => array_merge(['required'], self::FILE_RULES),
                    'berkas_kk_ktp' => array_merge(['required'], self::FILE_RULES),
                ],
            ],
        };

        $validated = $request->validate([...$formFields, ...$fileFields]);

        $formData = collect($validated)->except(array_keys($fileFields))->all();
        $citizen = Auth::guard('citizen')->user();
        $ticket = Submission::generateTicketNumber($jenis);

        $submission = DB::transaction(function () use ($jenis, $formData, $citizen, $ticket, $fileFields, $request) {
            $submission = Submission::create([
                'ticket_number' => $ticket,
                'citizen_id' => $citizen->id,
                'service_type' => $jenis,
                'form_data' => $formData,
                'status' => 'SUBMITTED',
            ]);

            foreach (array_keys($fileFields) as $field) {
                if (! $request->hasFile($field)) {
                    continue;
                }

                $this->storeUploadedFile($submission, $request->file($field), $field, $citizen);
            }

            return $submission;
        });

        return redirect()
            ->route('warga.permohonan.riwayat')
            ->with('status', "Permohonan berhasil dikirim. Nomor tiket Anda: {$submission->ticket_number}. Simpan nomor ini untuk melacak status.");
    }

    private function storeUploadedFile(Submission $submission, $file, string $field, $citizen): void
    {
        $storageKey = "submissions/{$submission->id}/".Str::uuid().'.'.$file->getClientOriginalExtension();
        $file->storeAs('', $storageKey, 'local');

        SubmissionFile::create([
            'submission_id' => $submission->id,
            'file_type' => 'upload',
            'field_name' => $field,
            'storage_key' => $storageKey,
            'original_name' => $file->getClientOriginalName(),
            'mime_type' => $file->getMimeType(),
            'size' => $file->getSize(),
            'uploaded_by_type' => 'citizen',
            'uploaded_by_id' => $citizen->id,
        ]);
    }

    public function riwayat(Request $request)
    {
        $query = Auth::guard('citizen')->user()->submissions()->latest();

        if ($status = $request->query('status')) {
            $query->where('status', $status);
        }

        if ($search = $request->query('cari')) {
            $query->where('ticket_number', 'like', "%{$search}%");
        }

        return view('warga.permohonan.riwayat', [
            'submissions' => $query->get(),
            'search' => $search ?? '',
            'statusFilter' => $status ?? '',
        ]);
    }

    public function show(string $ticket)
    {
        $submission = Auth::guard('citizen')->user()
            ->submissions()
            ->where('ticket_number', $ticket)
            ->with(['files', 'citizen'])
            ->firstOrFail();

        return view('warga.permohonan.detail', compact('submission'));
    }
}
