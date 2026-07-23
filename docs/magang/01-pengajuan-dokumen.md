# Tugas 1: Pengajuan Dokumen (Sisi Warga)

> Baca `00-persiapan.md` dulu kalau belum.

## Gambaran Besar

Warga yang sudah login bisa mengajukan 3 jenis dokumen: **Kartu Keluarga (KK)**, **Akta Kelahiran**, **Akta Kematian**. Tugas kamu: bikin supaya waktu warga mengisi form dan klik "Kirim", data itu benar-benar **tersimpan ke database**, dan warga bisa **melihat riwayat** pengajuannya beserta **detailnya**.

Tampilan form-nya (halaman, tombol, desain) **sudah jadi semua** — file itu ada di `resources/views/warga/permohonan/`, kamu tidak perlu ubah. Tugasmu murni di satu file:

**`app/Http/Controllers/Warga/PermohonanController.php`**

Ada 3 bagian (method) yang perlu kamu isi, ditandai `TODO(Magang 1 - ...)`: `store()`, `riwayat()`, `show()`.

## Langkah 1 — Simpan Pengajuan (`store`)

Buka `app/Http/Controllers/Warga/PermohonanController.php`. Paling atas file, di bawah baris `namespace ...;`, tambahkan baris-baris `use` ini (kalau belum ada):

```php
use App\Models\Submission;
use App\Models\SubmissionFile;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
```
*(`use` itu seperti "import" — bilang ke PHP bahwa kita mau pakai class-class itu di file ini.)*

Lalu cari `TODO(Magang 1 - Pengajuan Dokumen)` yang ada di dalam method `store()`. Ganti isi method `store()` (di antara `{` dan `}`) dengan kode ini:

```php
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
            'berkas_kk_asli' => ['required', 'file', 'mimes:jpg,jpeg,png,pdf', 'max:2048'],
            'berkas_buku_nikah' => ['required', 'file', 'mimes:jpg,jpeg,png,pdf', 'max:2048'],
            'berkas_ktp_pelapor' => ['required', 'file', 'mimes:jpg,jpeg,png,pdf', 'max:2048'],
            'berkas_ket_lahir' => ['nullable', 'file', 'mimes:jpg,jpeg,png,pdf', 'max:2048'],
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
            'berkas_kk' => ['required', 'file', 'mimes:jpg,jpeg,png,pdf', 'max:2048'],
            'berkas_ket_lahir' => ['required', 'file', 'mimes:jpg,jpeg,png,pdf', 'max:2048'],
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
            'berkas_ket_kematian' => ['required', 'file', 'mimes:jpg,jpeg,png,pdf', 'max:2048'],
            'berkas_kk_ktp' => ['required', 'file', 'mimes:jpg,jpeg,png,pdf', 'max:2048'],
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

        $file = $request->file($field);
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

    return $submission;
});

return redirect()
    ->route('warga.permohonan.riwayat')
    ->with('status', "Permohonan berhasil dikirim. Nomor tiket Anda: {$submission->ticket_number}. Simpan nomor ini untuk melacak status.");
```

**Penjelasan sederhana:**
- Bagian `match ($jenis)` itu daftar "aturan wajib isi" yang beda-beda tergantung jenis dokumen (KK / akta lahir / akta mati) — field mana yang wajib, file apa yang wajib diupload.
- `$request->validate(...)` mengecek semua isian sesuai aturan itu. Kalau ada yang salah/kosong, otomatis balik ke form dengan pesan error merah — kamu tidak perlu bikin pesan errornya sendiri.
- `Submission::create(...)` menyimpan 1 baris data pengajuan baru ke database.
- Bagian `foreach` menyimpan tiap file yang diupload warga (KTP, KK, dll) ke folder penyimpanan dan mencatatnya di tabel `submission_files`.
- Terakhir, warga diarahkan ke halaman riwayat dengan pesan berisi nomor tiketnya.

## Langkah 2 — Riwayat Permohonan (`riwayat`)

Cari `TODO(Magang 1 - Pengajuan Dokumen)` di method `riwayat()`. Ganti isinya jadi:

```php
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
```

**Penjelasan:** ambil semua pengajuan **milik warga yang sedang login saja** (`Auth::guard('citizen')->user()`), urutkan dari yang terbaru. Kalau warga memilih filter status atau mengetik pencarian nomor tiket, query-nya disaring sesuai itu.

## Langkah 3 — Detail Satu Permohonan (`show`)

Cari `TODO(Magang 1 - Pengajuan Dokumen)` di method `show()`. Ganti isinya jadi:

```php
$submission = Auth::guard('citizen')->user()
    ->submissions()
    ->where('ticket_number', $ticket)
    ->with(['files', 'citizen'])
    ->firstOrFail();

return view('warga.permohonan.detail', compact('submission'));
```

**Penjelasan:** cari 1 pengajuan berdasarkan nomor tiket di URL, tapi **hanya kalau itu punya warga yang sedang login** (supaya warga A tidak bisa lihat punya warga B). `firstOrFail()` otomatis menampilkan halaman 404 kalau tiketnya tidak ditemukan.

## Cara Coba Sendiri (Testing Manual)

1. Jalankan `docker compose up -d`, buka http://localhost:8000
2. Klik **Daftar Akun**, isi form dengan NIK contoh `1671030602990005` dan tanggal lahir `6/2/1999` (harus cocok, lihat `00-persiapan.md`).
3. Login pakai NIK & password yang baru dibuat.
4. Klik **Ajukan Permohonan**, pilih salah satu jenis dokumen, isi form, upload file apa saja (foto/PDF, maks 2MB), klik Kirim.
5. Harusnya kamu diarahkan ke halaman **Riwayat** dan lihat pesan sukses dengan nomor tiket, dan pengajuan barusan muncul di tabel.
6. Klik pengajuan itu untuk lihat halaman **Detail** — pastikan data & file yang diupload muncul.
7. Coba juga fitur pencarian & filter status di halaman Riwayat.

Kalau semua langkah di atas jalan tanpa error merah, tugasmu selesai.
