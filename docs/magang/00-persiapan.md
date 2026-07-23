# Persiapan Sebelum Mulai

Baca ini dulu sebelum buka panduan tugas kamu (01, 02, atau 03). Isinya cara menjalankan aplikasi di komputer dan istilah-istilah dasar yang akan sering muncul.

## 1. Menjalankan Aplikasi

Aplikasi ini jalan pakai **Docker**, jadi kamu tidak perlu install PHP/MySQL manual di komputer.

1. Pastikan **Docker Desktop** sudah terbuka (cek ada ikon paus di taskbar/system tray).
2. Buka folder project ini di terminal (klik kanan folder project → "Open in Terminal", atau buka Git Bash lalu `cd` ke folder project).
3. Ketik perintah ini lalu Enter:
   ```
   docker compose up -d
   ```
4. Tunggu 1-2 menit. Setelah selesai, buka browser dan ketik: **http://localhost:8000**
5. Kalau berhasil, akan muncul halaman depan aplikasi "Registrasi Pelayanan Dukcapil".

Kalau mau mematikan aplikasi: `docker compose down`. Kalau habis mengubah kode dan mau lihat perubahannya, biasanya cukup **refresh browser** — tidak perlu restart docker (kecuali diberitahu lain oleh mentor).

## 2. Akun untuk Login

| Peran | Cara login | Username | Password |
|---|---|---|---|
| Admin (super_admin) | NIK/Email + Password | `uptdzona3@admin.com` | `uptdzona3password` |
| Petugas (admin) | NIK/Email + Password | `uptdzona3@petugas.com` | `uptdzona3pegawai` |
| Warga | Daftar akun sendiri di `/register` | NIK 16 digit | (bikin sendiri saat daftar) |

Semua login (admin, petugas, warga) pakai **1 form yang sama** di halaman `/login`. Sistem otomatis tahu itu admin atau warga.

Untuk daftar akun warga, NIK harus mulai dengan kode `1671 03` (Kecamatan Plaju / Seberang Ulu II, Kota Palembang), contoh NIK yang valid: `1671030602990005`. 6 digit setelah kode wilayah adalah tanggal lahir (DDMMYY), jadi harus cocok dengan tanggal lahir yang diisi di form.

## 3. Istilah Dasar yang Akan Sering Kamu Temui

Kamu tidak perlu paham semua ini secara mendalam, cukup tahu maksudnya waktu baca panduan:

- **Route** — "alamat" halaman, misalnya `/beranda/permohonan`. Terdaftar di file `routes/web.php`. **Kamu tidak perlu edit file ini**, sudah disiapkan.
- **Controller** — file PHP yang isinya "logika": apa yang terjadi waktu sebuah halaman dibuka atau form dikirim. Ini yang akan kamu edit.
- **Model** — file PHP yang mewakili satu tabel di database (misalnya `Submission` = tabel permohonan, `Citizen` = tabel warga). Sudah lengkap, kamu tinggal **pakai**, tidak perlu edit.
- **View / Blade (`.blade.php`)** — file tampilan (HTML + sedikit kode PHP). Desainnya sudah jadi, kamu **tidak perlu edit** kecuali diminta di panduan.
- **`TODO(Magang ...)`** — komentar di dalam kode yang menandai "bagian ini belum selesai, ini tugas kamu". Cari komentar ini pakai Ctrl+F di editor kamu (VS Code) untuk tahu persis di mana harus menulis kode.
- **`$request`** — data yang dikirim user lewat form (misalnya isian nama, NIK, file yang diupload).
- **`validate()`** — cara Laravel mengecek apakah data dari form sudah benar (misalnya wajib diisi, harus angka, dst). Kalau tidak valid, otomatis dikembalikan ke form dengan pesan error, kamu tidak perlu bikin manual.

## 4. Cara Kerja

1. Buka file yang disebut di panduan pakai **VS Code**.
2. Cari komentar `TODO(Magang X - ...)` di file itu (pakai Ctrl+F).
3. Ganti/tambahkan kode persis seperti yang ada di panduan — **copy-paste**, lalu baca penjelasan di bawahnya biar ngerti maksudnya.
4. Simpan file (Ctrl+S), lalu coba di browser sesuai langkah "Cara Coba Sendiri" di panduan.
5. Kalau ada tulisan error merah di browser, baca pesan errornya pelan-pelan — biasanya menyebutkan nama file dan baris keberapa yang salah. Tanya mentor kalau stuck lebih dari 15 menit, jangan dipendam sendiri.

## 5. Simpan Pekerjaan (Git)

Sebelum mulai, buat branch sendiri biar tidak tabrakan dengan punya teman:

```
git checkout -b magang-1-pengajuan
```
(ganti angka sesuai nomor tugasmu: `magang-2-verifikasi`, `magang-3-user-audit`)

Setelah selesai satu bagian dan sudah dicoba jalan di browser:
```
git add .
git commit -m "Tulis di sini apa yang kamu kerjakan"
```
Lakukan ini beberapa kali sesuai progress, jangan menunggu sampai semua selesai. Mentor yang akan menggabungkan (merge) hasil kerja kamu nanti.
