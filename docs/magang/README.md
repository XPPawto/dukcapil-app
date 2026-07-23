# Panduan Mentor — Pembagian Tugas Magang

Dokumen ini untuk kamu (mentor), bukan untuk anak magang. Isinya cara kerjanya dibagi dan cara mengawasinya.

## Dokumen untuk Dikasih ke Anak Magang

Kasih tiap orang file `00-instalasi-software`, `00-persiapan`, `00-troubleshooting-faq`, dan panduan tugasnya masing-masing (`01`/`02`/`03`) — versi `.pdf` di folder `docs/magang/pdf/`. Urutan bacanya: instalasi software → persiapan → panduan tugas, dengan troubleshooting-faq dibuka kapan pun mereka nemu error.

## Struktur Saat Ini

Branch `main` sudah sengaja dikembalikan ke kondisi ~40% jadi: autentikasi (login/register terpadu, NIK, guest), layout & desain, struktur database (migration + seeder), dan model-model (`Citizen`, `Admin`, `Submission`, `AuditLog`, dll) semuanya **sudah lengkap dan jalan** — ini fondasi yang wajar disiapkan oleh lead/mentor. Yang **belum jalan** (ditandai komentar `TODO(Magang N - ...)`) adalah 3 fitur inti, sengaja dipecah biar bisa dikerjakan paralel oleh 3 orang tanpa saling tabrakan file:

| # | Fitur | File yang disentuh | Panduan |
|---|---|---|---|
| 1 | Pengajuan Dokumen (sisi warga) | `app/Http/Controllers/Warga/PermohonanController.php` | `docs/magang/01-pengajuan-dokumen.md` |
| 2 | Verifikasi Admin/Petugas | `app/Http/Controllers/Admin/VerifikasiController.php` | `docs/magang/02-verifikasi-admin.md` |
| 3 | Manajemen User & Audit Log | `app/Http/Controllers/Admin/UserController.php`, `AuditLogController.php` | `docs/magang/03-manajemen-user-audit-log.md` |

Solusi lengkap (kode aslinya, sebelum dikosongkan) tersimpan aman di branch **`reference-full`** — jangan dikasih ke anak magang, ini cuma untuk kamu cocokkan/nilai hasil kerja mereka. Cara lihat:
```
git checkout reference-full
```
Kembali ke kondisi kerja: `git checkout main`.

## Urutan yang Disarankan

Tugas 2 & 3 sedikit lebih enak dikerjakan **setelah** Tugas 1 selesai (supaya ada data pengajuan asli buat dicoba), tapi ketiganya bisa mulai bareng-bareng karena tidak saling menyentuh file. Kalau mau, Tugas 1 dan 3 boleh dimulai duluan, Tugas 2 nyusul begitu ada data dari Tugas 1 untuk dicoba.

Perkiraan tingkat kesulitan, dari yang **paling susah ke paling mudah**:

1. **Tugas 1 — Pengajuan Dokumen** (paling susah): 3 jenis dokumen dengan aturan validasi form yang beda-beda, plus logika upload banyak file sekaligus per jenis dokumen.
2. **Tugas 2 — Verifikasi Admin**: alurnya lebih sederhana (approve/reject + 1 file opsional), tapi tetap ada percabangan status dan upload file hasil.
3. **Tugas 3 — Manajemen User & Audit Log** (paling mudah): pola CRUD paling lurus, tidak ada percabangan status yang rumit, dan pola "step-up auth" di 2 method-nya (`resetPassword`, `unlock`) mirip satu sama lain.

Kalau mau menyesuaikan dengan kemampuan masing-masing anak magang, cocokkan yang paling percaya diri/berpengalaman ke Tugas 1, dan yang paling baru belajar ke Tugas 3.

## Alur Kerja Git

Tiap anak magang kerja di branch sendiri (`magang-1-pengajuan`, `magang-2-verifikasi`, `magang-3-user-audit`) dari `main`, sudah dijelaskan di `docs/magang/00-persiapan.md`. Karena file yang disentuh masing-masing tidak tumpang tindih, kamu bisa merge ketiga branch itu ke `main` tanpa konflik berarti.

## Cara Cek Hasil Kerja

- Bandingkan controller yang mereka isi dengan versi asli di `reference-full` (`git diff main reference-full -- app/Http/Controllers/...`).
- Jalankan langkah "Cara Coba Sendiri" di tiap panduan (01/02/03) sendiri untuk verifikasi ulang.
- View (`.blade.php`) sudah punya empty-state (`@forelse ... @empty`) untuk semua daftar, jadi sebelum dikerjakan halaman tetap tampil rapi (cuma kosong) — bukan error. Ini sengaja, supaya progress terlihat bertahap.
