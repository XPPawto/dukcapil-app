# Persiapan Sebelum Mulai

> Belum install VS Code / Docker / Git? Baca **`00-instalasi-software.md`** dulu, baru lanjut ke sini.

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
- **Kurung kurawal `{` dan `}`** — anggap seperti **amplop pembungkus**. Setiap `public function nama(...) { ... }` itu satu "amplop": `{` di awal, `}` di akhir, dan isi kode ada di dalamnya. Di panduan tugas, kamu **tidak akan pernah diminta menghapus/menambah `{` atau `}` sendiri** — instruksinya selalu "hapus baris ini sampai baris itu" yang sudah pasti aman di dalam amplop yang sama. Kalau ragu, hitung saja: jumlah `{` dan `}` di satu file harus selalu sama banyak.

## 4. Cara Kerja

1. Buka file yang disebut di panduan pakai **VS Code**.
2. Cari komentar `TODO(Magang X - ...)` di file itu (pakai Ctrl+F, ketik sebagian tulisan TODO-nya).
3. Setiap langkah di panduan akan bilang persis **baris mana sampai baris mana yang dihapus**, lalu kode apa yang ditulis menggantikannya. Copy-paste kode dari panduan, baca penjelasan di bawahnya biar ngerti maksudnya.
4. Simpan file (**Ctrl+S** — penting, sering kelupaan! Kalau titik di tab nama file masih ada, artinya belum tersimpan).
5. Coba di browser sesuai langkah "Cara Coba Sendiri" di panduan tugasmu.
6. Kalau muncul tulisan error, jangan panik — baca `00-Troubleshooting-FAQ.pdf`, hampir semua error pemula sudah dibahas di sana lengkap dengan cara bacanya. Tanya mentor kalau sudah coba dan tetap stuck lebih dari 15 menit.

## 5. Simpan & Kirim Pekerjaan (GitHub Desktop)

Sebelum mulai ngoding, buat "cabang" (branch) sendiri biar progress kamu tidak tercampur/tabrakan dengan punya teman:

1. Buka **GitHub Desktop**, pastikan repository `dukcapil-app` yang aktif (lihat nama repo di kiri atas aplikasi).
2. Klik dropdown **Current branch** di bagian atas, klik **New branch**.
3. Beri nama sesuai tugasmu: `magang-1-pengajuan` (Tugas 1), `magang-2-verifikasi` (Tugas 2), atau `magang-3-user-audit` (Tugas 3), lalu klik **Create branch**.

Setelah itu, kerjakan langkah-langkah di panduan tugasmu seperti biasa di VS Code. **Setiap kali satu bagian kecil selesai dan sudah dicoba jalan di browser** (jangan menunggu sampai semuanya selesai):

1. Buka **GitHub Desktop** — di sana otomatis muncul daftar file yang berubah.
2. Di kotak kiri bawah, tulis ringkasan apa yang barusan kamu kerjakan (contoh: "Isi fungsi simpan pengajuan KK").
3. Klik tombol biru **Commit to magang-1-pengajuan** (nama branch menyesuaikan).
4. Klik tombol **Push origin** di bagian atas untuk mengirim ke GitHub.

Ulangi 4 langkah commit+push ini tiap kali ada progress baru. Mentor yang akan menggabungkan (merge) hasil kerja kamu ke kode utama nanti — kamu tidak perlu melakukan itu sendiri.
