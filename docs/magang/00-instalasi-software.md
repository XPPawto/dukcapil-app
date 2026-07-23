# Instalasi Software (Lakukan Ini Dulu)

Sebelum bisa mulai kerja, install 5 software ini di laptop kamu. Ikuti urutannya dari atas ke bawah. Total waktu kira-kira 30-45 menit tergantung kecepatan internet.

**Catatan penting:** project ini jalan pakai **Docker**, jadi kamu **TIDAK PERLU install PHP, MySQL, atau Node.js manual** di laptop. Semua itu sudah otomatis berjalan di dalam Docker begitu nanti kamu ketik satu perintah. Ini sengaja, supaya versi PHP/MySQL di laptop kamu, teman kamu, dan mentor semuanya **sama persis** — jadi tidak ada masalah "di laptop saya bisa jalan, di laptop kamu kok error".

## Checklist Ringkas

| # | Software | Kegunaan | Wajib? |
|---|---|---|---|
| 1 | Visual Studio Code | Editor untuk buka & edit kode | Wajib |
| 2 | Docker Desktop | Menjalankan aplikasinya (PHP, MySQL, dst otomatis) | Wajib |
| 3 | Git | "Mesin" penyimpan versi kode (dipakai di belakang layar oleh GitHub Desktop) | Wajib |
| 4 | Akun GitHub | Tempat kode project ini disimpan online | Wajib |
| 5 | GitHub Desktop | Aplikasi klik-klik untuk simpan & kirim kode ke GitHub | Wajib |

> Kenapa GitHub Desktop wajib, bukan opsional? Karena kalau kirim kode (push) lewat command line, GitHub sekarang minta "kode keamanan" khusus (token) yang cukup ribet dibuat untuk pemula. GitHub Desktop membereskan itu otomatis lewat login biasa — jauh lebih gampang buat yang baru belajar.

## 1. Visual Studio Code (Editor Kode)

1. Buka **https://code.visualstudio.com/**
2. Klik tombol download berwarna biru (otomatis mendeteksi Windows).
3. Buka file installer yang sudah terdownload (nama file seperti `VSCodeUserSetup-x64-....exe`).
4. Ikuti proses instalasi: centang **"Add to PATH"** dan **"Add 'Open with Code' action"**, lalu klik Next terus sampai Install → Finish.
5. Buka VS Code. Di sisi kiri ada baris ikon vertikal — cari ikon **4 kotak kecil** (namanya **Extensions**), klik itu. Di kotak pencarian yang muncul, ketik nama extension di bawah ini satu-satu, lalu klik tombol biru **Install** yang muncul di hasil pencarian teratas:
   - `PHP Intelephense` (bantu auto-lengkap kode PHP, warna ikon ungu)
   - `Docker` (by Microsoft, ikon paus biru)

## 2. Docker Desktop (Menjalankan Aplikasi)

1. Buka **https://www.docker.com/products/docker-desktop/**
2. Klik **Download for Windows**.
3. Buka file installer (`Docker Desktop Installer.exe`), ikuti instruksinya (pilihan default aman, klik Next/OK terus).
4. Kalau muncul permintaan mengaktifkan **WSL2**, ikuti link/instruksi yang muncul di layar (biasanya cuma perlu restart laptop 1 kali, lalu instalasi Docker lanjut otomatis).
5. Setelah laptop restart, buka **Docker Desktop** dari Start Menu. Tunggu 1-2 menit sampai ada tulisan **"Engine running"** di pojok kiri bawah aplikasi, dan ikon paus 🐳 di taskbar (pojok kanan bawah layar) berwarna solid (bukan abu-abu/pudar) — itu tandanya Docker sudah siap dipakai. Biarkan Docker Desktop tetap terbuka (boleh diminimize) selama kerja.

## 3. Git

Ini "mesin" yang bekerja di belakang layar setiap kali kamu menyimpan progress lewat GitHub Desktop (langkah 5). Kamu tidak akan mengetik perintah git manual, tapi tetap wajib diinstall duluan.

1. Buka **https://git-scm.com/downloads**
2. Klik **Windows**, download akan mulai otomatis.
3. Buka file installer, klik Next terus dengan pilihan **default** (jangan ubah apa-apa), lalu Install → Finish.

## 4. Akun GitHub

1. Buka **https://github.com/join**
2. Daftar pakai email kamu, ikuti langkahnya sampai selesai (verifikasi email dari kotak masuk kamu).
3. Kasih tahu mentor **username GitHub** kamu, supaya diundang (invite) sebagai kolaborator ke repository project ini. Tunggu email undangan dari GitHub, klik **Accept invitation** di email itu.

## 5. GitHub Desktop (Cara Simpan & Kirim Kode)

Ini yang akan kamu pakai setiap hari untuk menyimpan progress dan mengirimkannya ke GitHub — semua lewat klik, tanpa mengetik perintah.

1. Buka **https://desktop.github.com/**
2. Download & install (Next-Next-Install seperti biasa).
3. Buka GitHub Desktop, klik **Sign in to GitHub.com**, login pakai akun dari langkah 4 (browser akan terbuka untuk konfirmasi, klik **Authorize**).
4. Kalau diminta "Configure Git", isi **Name** dan **Email** dengan nama & email kamu, lalu **Continue**.

## Langkah Terakhir: Ambil Kode Project (Clone)

Setelah semua di atas terinstall dan mentor sudah mengundang kamu ke repository (cek email undangannya sudah di-Accept):

1. Buka **GitHub Desktop**.
2. Klik menu **File → Clone repository...**
3. Klik tab **GitHub.com**, cari/klik repository **`XPPawto/dukcapil-app`** di daftar (kalau tidak muncul, pastikan undangan sudah di-Accept, lalu tutup-buka lagi GitHub Desktop).
4. Perhatikan kotak **"Local path"** — itu lokasi foldernya akan disimpan di laptop kamu (boleh dibiarkan default). Klik **Clone**.
5. Setelah selesai, klik tombol **"Open in Visual Studio Code"** di layar GitHub Desktop — folder project otomatis terbuka di VS Code.

Selanjutnya lanjut ke panduan **00-Persiapan.pdf** untuk cara menjalankan aplikasinya dan akun login yang dipakai. Cara commit & push lewat GitHub Desktop dijelaskan di bagian akhir **00-Persiapan.pdf**.

## Cek Semua Sudah Siap

- [ ] VS Code bisa dibuka, extension PHP Intelephense & Docker sudah terinstall
- [ ] Docker Desktop status **"Engine running"**
- [ ] Akun GitHub sudah dibuat, dan undangan ke repository sudah di-**Accept**
- [ ] GitHub Desktop sudah login dan berhasil clone folder `dukcapil-app`
- [ ] Folder `dukcapil-app` bisa terbuka otomatis di VS Code lewat tombol "Open in Visual Studio Code"

Kalau ada langkah yang gagal atau error, tanya mentor — jangan dipaksakan lanjut sendiri. Kalau muncul pesan error dan bingung artinya apa, cek juga **00-Troubleshooting-FAQ.pdf**.
