# Tugas 2: Verifikasi Admin/Petugas

> Baca `00-persiapan.md` dulu kalau belum.

## Gambaran Besar

Petugas/admin perlu bisa melihat **semua permohonan yang masuk dari semua warga**, membuka detailnya, lalu **menyetujui (APPROVED)** atau **menolak (REJECTED)** dengan catatan. Kalau disetujui, petugas juga bisa upload file hasil (PDF) untuk warga.

Tampilan halamannya sudah jadi di `resources/views/admin/verifikasi/`, kamu tidak perlu ubah. Tugasmu ada di satu file:

**`app/Http/Controllers/Admin/VerifikasiController.php`**

Ada 3 bagian (method) bertanda `TODO(Magang 2 - ...)`: `index()`, `show()`, `updateStatus()`.

## Langkah 1 — Daftar Semua Permohonan (`index`)

Buka `app/Http/Controllers/Admin/VerifikasiController.php`. Tambahkan baris `use` ini di bawah `namespace`:

```php
use App\Models\Citizen;
use App\Models\Submission;
```

Cari `TODO(Magang 2 - Verifikasi Admin)` di method `index()`. Ganti isinya jadi:

```php
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
```

**Penjelasan:** beda dengan sisi warga (yang cuma lihat punya sendiri), di sini petugas lihat **semua** permohonan (`Submission::with('citizen')` — tanpa filter "punya siapa"). Pencarian bisa pakai nomor tiket, atau NIK 16 digit (kalau yang diketik 16 angka, dicari lewat `Citizen::findByNik()` dulu untuk tahu ID warganya).

## Langkah 2 — Detail Satu Permohonan (`show`)

Cari `TODO(Magang 2 - Verifikasi Admin)` di method `show()`. Ganti isinya jadi:

```php
$submission = Submission::with(['citizen', 'files'])
    ->where('ticket_number', $ticket)
    ->firstOrFail();

return view('admin.verifikasi.detail', compact('submission'));
```

**Penjelasan:** ambil 1 permohonan lengkap dengan data warganya (`citizen`) dan file-file yang diupload (`files`), berdasarkan nomor tiket di URL.

## Langkah 3 — Update Status (Setujui/Tolak) (`updateStatus`)

Tambahkan baris `use` ini juga di atas file (dekat yang tadi):

```php
use App\Models\AuditLog;
use App\Models\SubmissionFile;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
```

Cari `TODO(Magang 2 - Verifikasi Admin)` di method `updateStatus()`. Ganti isinya jadi:

```php
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
```

**Penjelasan:**
- `catatan` **wajib diisi kalau status REJECTED** (`required_if:status,REJECTED`) — supaya warga tahu alasan ditolak.
- Kalau disetujui dan petugas upload PDF hasil, filenya disimpan dan dicatat di `submission_files` (mirip cara warga upload file di Tugas 1).
- `AuditLog::record(...)` mencatat "siapa melakukan apa" — ini **sudah ada fungsinya**, kamu tinggal panggil, tidak perlu bikin sendiri. Ini penting supaya tindakan admin bisa diaudit/dilacak (lihat juga Tugas 3).

## Cara Coba Sendiri (Testing Manual)

1. Pastikan sudah ada minimal 1 permohonan di database — kalau Tugas 1 (Pengajuan Dokumen) sudah selesai dikerjakan temanmu, ajukan 1 dokumen dari sisi warga dulu. Kalau belum, minta mentor bantu isi data contoh langsung ke database.
2. Login sebagai petugas: `uptdzona3@petugas.com` / `uptdzona3pegawai` (lihat `00-persiapan.md`).
3. Buka menu **Verifikasi**, pastikan daftar permohonan muncul.
4. Coba filter status dan cari pakai nomor tiket / NIK warga.
5. Klik salah satu permohonan, buka halaman detail, cek data & file warga muncul dengan benar.
6. Coba **Tolak** dengan catatan kosong — harus muncul error minta catatan diisi. Lalu coba tolak dengan catatan diisi — harus berhasil.
7. Coba **Setujui** salah satu permohonan lain, upload file PDF hasil — pastikan berhasil dan file bisa dibuka lagi.
8. Login sebagai admin (`uptdzona3@admin.com`), buka menu **Audit Log** — pastikan tindakan tolak/setuju tadi tercatat di sana (kalau Tugas 3 sudah jadi).
