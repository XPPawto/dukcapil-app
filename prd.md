# PRODUCT REQUIREMENT DOCUMENT (PRD)

## Sistem Informasi Pelayanan Mandiri Kependudukan Warga & Administration Dashboard

---

**Nama Proyek:** Sipenkar (Sistem Pelayanan Kependudukan) **Versi Dokumen:** 1.2.0 (Final — Disempurnakan) **Tanggal:** 23 Juli 2026 **Status:** Approved / Ready for Dev **Target Output:** Web Portal & PDF Generation **Otorisasi:** Paduka / Xpawto

---

## Daftar Isi

1. Ringkasan Eksekutif & Tujuan Proyek  
2. Riwayat Revisi & Perubahan Utama  
3. Ruang Lingkup & Target Pengguna  
4. Spesifikasi Autentikasi & Manajemen Akun Warga  
   - 4.1. Mekanisme Registrasi Warga  
   - 4.2. Mekanisme Login Warga (Login ID Unik)  
   - 4.3. Alur Reset/Lupa Password (Tanpa OTP) — Kritikal  
   - 4.4. Keamanan Sesi & Token  
5. Peran Pengguna (User Roles) & Matriks Hak Akses  
6. Alur Kerja Sistem (End-to-End User Flow)  
7. Persyaratan Layanan & Spesifikasi Input Data  
8. Spesifikasi Modul Dashboard Admin  
   - 8.1. Modul Verifikasi Pengajuan  
   - 8.2. Modul User Management  
   - 8.3. Audit Log & Reporting  
9. Matriks Status Pengajuan (Status Matrix)  
10. Spesifikasi API & Integrasi  
11. Skema Basis Data (ERD Ringkas)  
12. Kebutuhan Non-Fungsional (Non-Functional Requirements)  
13. Skenario Edge Cases & Penanganan Error  
14. Kriteria Penerimaan (User Acceptance Criteria — UAC)  
15. Metrik Keberhasilan (Success Metrics)  
16. Glosarium  
17. Lampiran & Referensi

---

## 1\. Ringkasan Eksekutif & Tujuan Proyek

Dokumen ini merincikan pembangunan **Platform Digital Pelayanan Kependudukan Terpadu (Sipenkar)**, yang dirancang untuk memodernisasi alur pengajuan dokumen kependudukan warga (Kartu Keluarga, Akta Kelahiran, Akta Kematian) secara mandiri berbasis web, sekaligus menyediakan pusat kendali verifikasi (Dashboard Admin) bagi petugas Dinas Kependudukan dan Pencatatan Sipil (Dukcapil).

### Tujuan Utama

1. **Efisiensi Operasional** — mengeliminasi antrean fisik dan pendaftaran manual.  
2. **Transparansi & Aksesibilitas** — status pengajuan real-time bagi warga.  
3. **Akuntabilitas & Tata Kelola** — alur verifikasi terstruktur dan terekam otomatis dalam audit log.  
4. **Digitalisasi Output** — penerbitan dokumen digital PDF berQR-code, siap cetak mandiri.  
5. **Manajemen Akun Terpusat** — Admin dapat mengelola akun warga, termasuk reset password manual di kantor tanpa OTP/email otomatis.  
6. **Kepatuhan Privasi Data** — pengelolaan data pribadi warga sesuai UU No. 27 Tahun 2022 tentang Pelindungan Data Pribadi (PDP).

---

## 2\. Riwayat Revisi & Perubahan Utama

### 2.1. Riwayat Versi

| Versi | Tanggal | Ringkasan Perubahan |
| :---- | :---- | :---- |
| 1.1.0 | — | Draf awal PRD dengan login berbasis NIK. |
| 1.1.1 | 23 Jul 2026 | Perubahan metode login ke Nama \+ Password; penambahan modul reset password manual & User Management. |
| **1.2.0** | **23 Jul 2026** | **Menutup celah kolisi nama pada login (Login ID unik); menambah re-autentikasi admin sebelum reset password; melengkapi skema database, standar API, dan kepatuhan UU PDP.** |

### 2.2. Ringkasan Perubahan dari Versi 1.1.0

| No. | Area Perubahan | Deskripsi Perubahan | Dampak pada Pengembangan |
| :---- | :---- | :---- | :---- |
| 1 | Metode Login | Login warga menggunakan **Login ID** (turunan otomatis dari Nama Lengkap, dijamin unik) dan **Password**, bukan NIK. | Backend mengubah logika autentikasi; frontend menampilkan Login ID kepada warga saat registrasi berhasil. |
| 2 | Validasi NIK (Regional) | Validasi NIK diperketat dengan aturan khusus wilayah Sumatera Selatan. | Fungsi validasi di frontend (feedback cepat) dan backend (keamanan, sumber kebenaran). |
| 3 | Proses Lupa Password | Reset password tidak menggunakan OTP/email; warga wajib datang ke kantor untuk verifikasi tatap muka; Admin mereset lewat modul baru dengan re-autentikasi. | Modul User Management \+ langkah konfirmasi password admin sendiri sebelum aksi reset dieksekusi. |
| 4 | Peran Admin | Admin memiliki akses ke fitur User Management (lihat daftar warga, reset password). | Hak akses baru untuk Role Admin; tabel audit log wajib untuk setiap aksi reset. |

---

## 3\. Ruang Lingkup & Target Pengguna

- **Ruang Lingkup Sistem:**  
  - Pengembangan aplikasi web (Frontend & Backend) dan API.  
  - Tidak termasuk integrasi real-time dengan sistem internal Dukcapil untuk validasi NIK (validasi dilakukan melalui algoritma mandiri berbasis format, bukan status kependudukan sesungguhnya).  
  - Penyediaan dashboard analitik dan manajemen pengguna.  
- **Target Pengguna:**  
  - **Utama:** WNI berdomisili di wilayah Sumatera Selatan (khususnya Kota Palembang, Plaju, Banyuasin–Mariana) yang membutuhkan dokumen kependudukan.  
  - **Sekunder:** Petugas/Admin Dukcapil, Super Admin.

---

## 4\. Spesifikasi Autentikasi & Manajemen Akun Warga

### 4.1. Mekanisme Registrasi Warga

| Field | Tipe Input | Aturan & Validasi |
| :---- | :---- | :---- |
| **Nama Lengkap** | Teks | Wajib. Min 3, maks 100 karakter. Hanya huruf, spasi, dan tanda baca nama umum (`'`, `.`, `-`). |
| **NIK (16 digit)** | Angka | Lihat detail validasi di 4.1.1 (kritis). |
| **Tanggal Lahir** | Tanggal | Wajib. Harus konsisten dengan digit tanggal lahir pada NIK (lihat 4.1.1 poin 4). Dipakai sebagai faktor disambiguasi Login ID. |
| **Email** | Email | Wajib. Format valid, unique. Dipakai hanya untuk notifikasi sistem (bukan untuk reset password). |
| **Password** | Password | Wajib. Min 8 karakter, kombinasi huruf kapital, huruf kecil, dan angka. Direkomendasikan menambah simbol (opsional, disarankan di UI). |

#### 4.1.1. Validasi NIK (Kritis)

1. Harus 16 digit angka, tanpa spasi/karakter lain.  
2. Kode Provinsi (2 digit pertama) harus **"16"** (Sumatera Selatan).  
3. Kode Kabupaten/Kota dan Kecamatan (digit ke-3 s.d. ke-6) harus terdaftar pada **tabel referensi wilayah layanan** (Palembang / Plaju / Banyuasin–Mariana). Tabel ini harus diambil dari kode wilayah administratif resmi (Kemendagri/Permendagri terbaru) dan disimpan sebagai data referensi yang bisa diperbarui tanpa deploy ulang aplikasi — **jangan hard-code** kode wilayah di source code.  
4. Validasi tanggal lahir (digit ke-7 s.d. ke-12, format DDMMYY):  
   - Laki-laki: tanggal (2 digit pertama) antara 01–31.  
   - Perempuan: tanggal ditambah 40 (41–71).  
   - Bulan (digit ke-9–10): 01–12. Tahun (digit ke-11–12): 2 digit terakhir tahun lahir, divalidasi silang terhadap field **Tanggal Lahir** yang diisi terpisah di form (harus cocok).  
5. 4 digit terakhir adalah nomor urut penerbitan — tidak divalidasi format khusus, hanya dipastikan numerik.  
6. NIK bersifat unique secara sistem (tidak boleh terdaftar dua kali).  
7. **Catatan keamanan:** validasi format NIK bukan pengganti verifikasi keabsahan dokumen kependudukan yang sebenarnya — tetap dilakukan verifikasi manual berkas oleh Admin pada tahap pengajuan layanan (lihat Bab 8.1).

### 4.2. Mekanisme Login Warga (Login ID Unik)

**Masalah pada versi sebelumnya:** login memakai Nama Lengkap secara langsung berisiko kolisi bila dua warga memiliki nama identik, karena Nama Lengkap tidak dijamin unik di dunia nyata (berbeda dengan NIK).

**Solusi (v1.2.0):** sistem tetap tidak memakai NIK sebagai kredensial, tetapi menghasilkan **Login ID** yang unik secara otomatis pada saat registrasi:

1. Login ID dibentuk dari slug Nama Lengkap (huruf kecil, tanpa spasi/simbol), contoh: `budisantoso`.  
2. Jika slug sudah dipakai warga lain, sistem menambahkan sufiks angka urut, contoh: `budisantoso2`, `budisantoso3`.  
3. Login ID ditampilkan ke warga tepat setelah registrasi berhasil (di layar dan dikirim ke email terdaftar sebagai catatan, bukan sebagai mekanisme reset), dan warga disarankan mencatatnya.  
4. Form login menampilkan label **"Login ID"** (bukan "Nama Lengkap") dan **"Password"**, dengan tautan bantuan kecil: *"Lupa Login ID Anda? Login ID sama dengan nama Anda tanpa spasi (+ nomor urut jika ada warga dengan nama sama)."*  
5. Login ID **tidak dapat diubah** oleh warga sendiri (untuk mencegah pengambilalihan Login ID orang lain); perubahan hanya melalui Admin dengan verifikasi tatap muka, dicatat di audit log.

**Keamanan Login:**

- Rate limiting: maksimal 5 percobaan gagal dalam 15 menit per akun **dan** per alamat IP.  
- Setelah melewati batas, akun terkunci sementara (mis. 15–30 menit) dengan mekanisme *exponential backoff* untuk percobaan berikutnya; log percobaan gagal dicatat untuk deteksi *brute force*.  
- Password tidak pernah ditampilkan/di-log dalam bentuk plain text di server manapun (aplikasi, load balancer, maupun log APM).

### 4.3. Alur Reset/Lupa Password (Tanpa OTP) — Kritikal

#### 4.3.1. Di Sisi Portal Warga (Frontend)

- Tombol "Lupa Password?" mengarahkan ke halaman informasi statis:  
    
  > *"Untuk keamanan data, perubahan password hanya dapat dilakukan secara langsung di kantor pelayanan dengan membawa identitas fisik (KTP/KK) dan menemui petugas Admin. Kami tidak menyediakan reset password melalui email atau SMS."*  
    
- **Tidak ada** form input apa pun di halaman ini, untuk mencegah percobaan brute force atau enumerasi akun.  
- Halaman ini juga menampilkan cara warga menemukan Login ID-nya bila lupa (lihat 4.2 poin 4), tanpa mengungkap apakah suatu Login ID valid/terdaftar (mencegah *account enumeration*).

#### 4.3.2. Di Sisi Admin (Backend & Dashboard)

1. Warga datang ke kantor membawa KTP/KK.  
2. Petugas memverifikasi identitas warga secara tatap muka.  
3. Petugas login ke Dashboard Admin dan membuka menu **User Management**.  
4. Petugas mencari akun warga berdasarkan Nama, Login ID, atau NIK.  
5. Petugas mengklik tombol **\[Ganti Password\]** pada baris data warga bersangkutan.  
6. **Re-autentikasi wajib:** sistem meminta Admin memasukkan ulang password akunnya sendiri (step-up authentication) sebelum modal reset dapat diakses — mencegah penyalahgunaan bila sesi Admin sedang ditinggal/diambil alih.  
7. Sistem menampilkan modal dengan field: **Password Baru** dan **Konfirmasi Password Baru**.  
8. Petugas memasukkan password baru (aturan kompleksitas sama seperti registrasi) dan menyimpannya.  
9. Sistem akan:  
   - Meng-hash password baru menggunakan Argon2id (direkomendasikan) atau Bcrypt (cost factor ≥ 12).  
   - Memperbarui data password di database.  
   - Mencabut (invalidate) seluruh sesi/token login aktif milik warga tersebut, memaksa login ulang dengan password baru.  
   - **Wajib** mencatat aksi ke *Audit Log*: ID Admin, ID Warga, Timestamp (UTC+7), IP Address Admin, User-Agent.  
10. Petugas menginformasikan password baru kepada warga secara lisan (tidak dikirim lewat chat/pesan tidak terenkripsi) dan menyarankan segera menggantinya via fitur ubah password di profil warga setelah login pertama.

### 4.4. Keamanan Sesi & Token

| Aspek | Ketentuan |
| :---- | :---- |
| Jenis Token | JSON Web Token (JWT), ditandatangani dengan algoritma asimetris (RS256). |
| Masa Berlaku Access Token | 15–30 menit. |
| Refresh Token | Masa berlaku 7 hari, disimpan sebagai HttpOnly \+ Secure cookie, rotasi setiap kali dipakai. |
| Penyimpanan Token (client) | Access token di memori aplikasi (bukan localStorage) untuk mengurangi risiko XSS. |
| Logout | Refresh token dicabut dari server (server-side revocation list) saat logout eksplisit atau reset password. |
| Sesi Admin | Timeout otomatis setelah 15 menit tanpa aktivitas; wajib login ulang untuk aksi sensitif (lihat 4.3.2 poin 6). |

---

## 5\. Peran Pengguna (User Roles) & Matriks Hak Akses

| Aktor / Role | Deskripsi Hak Akses | Fitur Utama | Hak Akses Modul |
| :---- | :---- | :---- | :---- |
| **Warga (Public User)** | Masyarakat umum yang membutuhkan pelayanan dokumen. Akses hanya pada data pribadi dan pengajuannya sendiri. | Registrasi, Login (Login ID \+ Pass), Pengajuan Permohonan, Upload Berkas, Tracking Status, Download PDF, Ubah Password (setelah login). | Profil Saya (Read/Update), Layanan (Create), Riwayat (Read). |
| **Admin / Petugas Capil** | Staf verifikator yang memvalidasi berkas & mengelola akun warga. | Dashboard Analytics, Verifikasi Dokumen (Approve/Reject), Update Status & Catatan, Manajemen User (List, Reset Password), Cetak/Upload PDF. | Dashboard (Read), Verifikasi (Read/Write), User Management (Read/Write), Laporan (Read). |
| **Super Admin / Kepala Dinas** | Pengelola sistem tingkat tinggi/pimpinan instansi. | Manajemen akun staf/admin (CRUD), Laporan Rekapitulasi, Auditing Log Sistem, Konfigurasi Layanan & Tabel Referensi Wilayah. | Semua Modul. |

> **Catatan:** seluruh pembatasan hak akses di atas **wajib** ditegakkan di backend (server-side authorization check per endpoint), bukan hanya disembunyikan di UI frontend.

---

## 6\. Alur Kerja Sistem (End-to-End User Flow)

### Sisi Warga

1. **Registrasi** — mengisi Nama, NIK (validasi Sumsel), Tanggal Lahir, Email, Password; menerima Login ID.  
2. **Login** — menggunakan Login ID dan Password.  
3. **Dashboard Warga** — ringkasan dan tombol \[Ajukan Permohonan Baru\].  
4. **Pemilihan Layanan & Unggah** — memilih layanan (KK/Akta Lahir/Akta Mati), mengisi form dinamis, mengunggah berkas (maks. 5 file, 2 MB per file).  
5. **Submit** — sistem memvalidasi data & file; menerbitkan Nomor Tiket dan status `SUBMITTED`.  
6. **Pelacakan** — status pengajuan real-time di halaman "Riwayat".

### Sisi Admin

1. **Login** ke Dashboard.  
2. **Dashboard** — KPI (Total, Pending, Diproses, Ditolak, Selesai).  
3. **Verifikasi** — membuka daftar `Pending`, memeriksa detail & preview berkas.  
4. **Tindakan Verifikasi** — approve/reject dengan catatan; status berubah ke `IN_REVIEW`, `APPROVED`, atau `REJECTED`.  
5. **Manajemen User (skenario khusus)** — reset password warga via User Management dengan re-autentikasi (lihat 4.3.2).  
6. **Penerbitan** — jika `APPROVED`, unggah/generate PDF hasil akhir; warga mengunduh dari portal.

---

## 7\. Persyaratan Layanan & Spesifikasi Input Data

| Jenis Layanan | Berkas Persyaratan (Upload) | Aturan Validasi & Format File | Data Input Form (Contoh) |
| :---- | :---- | :---- | :---- |
| **1\. Kartu Keluarga (KK) Baru/Perubahan** | Scan/Foto KK Asli; Fotokopi Buku Nikah; Scan KTP Pelapor & Saksi; Surat Keterangan Lahir (jika tambah anggota) | Format: JPG, PNG, PDF. Maks. 2 MB/berkas. NIK Pelapor harus 16 digit kode Sumsel. | Alasan Perubahan (Pindah/Nikah/Lahir), Data Kepala Keluarga, Data Anggota Keluarga. |
| **2\. Akta Kelahiran** | Scan KK yang mencantumkan nama anak; Scan Surat Keterangan Lahir dari Bidan/RS | NIK orang tua & anak harus valid. | Nama Anak, Tempat/Tanggal Lahir, Jenis Kelamin, Nama Orang Tua. |
| **3\. Akta Kematian** | Scan Surat Keterangan Kematian (RS/Kelurahan); Scan KK & KTP Jenazah | NIK Jenazah harus valid; input Tanggal/Jam/Lokasi Kematian. | Tanggal/Jam/Lokasi Meninggal, Penyebab Kematian (opsional). |

**Validasi keamanan berkas (berlaku untuk semua jenis layanan):**

- Verifikasi MIME-type asli file (bukan hanya ekstensi nama file).  
- Pemindaian antivirus/malware sebelum file disimpan permanen.  
- Nama file disimpan dengan penamaan acak/UUID di storage (nama asli disimpan sebagai metadata terpisah) untuk mencegah *path traversal* dan kebocoran informasi.  
- Akses ke file hanya melalui URL bertanda tangan (*signed URL*) dengan masa berlaku singkat, bukan URL publik permanen.

---

## 8\. Spesifikasi Modul Dashboard Admin

### 8.1. Modul Verifikasi Pengajuan

- **Statistik & KPI Dashboard:** widget Total, Pending, Diproses, Disetujui, Ditolak (dengan grafik).  
- **Tabel Inbox Verifikasi:** Centang, No. Tiket, Nama Pemohon, NIK (masking sebagian, mis. `1671****1234`), Jenis Layanan, Waktu Pengajuan, Status Badge, Aksi.  
- **Pencarian & Filter:** Global Search (No. Tiket/NIK), Filter Status, Sorting Waktu, Filter Rentang Tanggal.  
- **Detail Verifikasi (Modal/Sidebar):**  
  - Seluruh data form.  
  - Preview file (PDF/Image viewer built-in, tidak mengunduh file ke perangkat lokal admin secara otomatis).  
  - Aksi: \[Diproses\], \[Disetujui\], \[Ditolak\].  
  - Field catatan/alasan **wajib** jika \[Ditolak\].  
  - Form upload file hasil akhir (PDF) jika \[Disetujui\].

### 8.2. Modul User Management — Kritikal

- **Tabel List User Warga:** No, Nama Lengkap, Login ID, NIK (masking sebagian), Email, Tanggal Registrasi, Status Akun (Aktif/Tidak Aktif/Terkunci).  
- **Pencarian & Filter:** berdasarkan Nama Lengkap, Login ID, atau NIK; filter Status Akun.  
- **Aksi Reset/Ganti Password:**  
  - Tombol **\[Ganti Password\]** (ikon kunci) per baris.  
  - Memicu **re-autentikasi Admin** (lihat 4.3.2 poin 6), lalu Modal Form: **Password Baru**, **Konfirmasi Password Baru**, tombol **\[Simpan\]**/**\[Batal\]**.  
  - Validasi: sama seperti aturan kompleksitas registrasi.  
- **Aksi Tambahan:**  
  - **\[Buka Kunci Akun\]** — untuk akun yang terkunci akibat rate limiting berulang.  
  - **\[Nonaktifkan Akun\]** — Super Admin only, untuk kasus penyalahgunaan.

### 8.3. Audit Log & Reporting

- Setiap aksi sensitif (reset password, buka kunci akun, nonaktifkan akun, ubah status pengajuan) tercatat dengan: Aktor (ID \+ Role), Target (ID), Jenis Aksi, Waktu, IP Address, User-Agent.  
- Audit log bersifat **append-only** (tidak dapat diedit/dihapus oleh Admin biasa), hanya dapat dilihat penuh oleh Super Admin.  
- Retensi audit log minimal 2 tahun, mengikuti kebijakan arsip instansi.  
- Laporan rekapitulasi (harian/bulanan) dapat diekspor ke Excel/PDF oleh Super Admin.

---

## 9\. Matriks Status Pengajuan (Status Matrix)

| Kode Status | Label Tampilan Warga | Deskripsi Status | Warna Badge | Aksi Admin yang Tersedia |
| :---- | :---- | :---- | :---- | :---- |
| `SUBMITTED` | Menunggu Verifikasi | Permohonan baru masuk antrean. | Biru Muda (\#3B82F6) | Ubah ke `IN_REVIEW` atau `REJECTED`. |
| `IN_REVIEW` | Sedang Diproses | Admin memeriksa kelengkapan & keabsahan data. | Kuning/Amber (\#F59E0B) | Ubah ke `APPROVED` atau `REJECTED`. |
| `REJECTED` | Ditolak / Perbaiki | Berkas/data tidak sesuai; warga wajib unggah ulang. | Merah (\#EF4444) | Ubah ke `IN_REVIEW` jika warga sudah unggah ulang. |
| `APPROVED` | Selesai & Terbit | Dokumen disetujui dan terbit; PDF siap diunduh. | Hijau (\#10B981) | Tidak ada aksi lebih lanjut. |
| `EXPIRED` | Kedaluwarsa | Status `REJECTED` tanpa unggah ulang \> 30 hari; pengajuan otomatis ditutup. | Abu-abu (\#9CA3AF) | Warga wajib mengajukan permohonan baru. |

---

## 10\. Spesifikasi API & Integrasi

**Konvensi umum:**

- Seluruh endpoint diawali `/api/v1/` (versioning eksplisit).  
- Autentikasi via header `Authorization: Bearer <access_token>` (kecuali endpoint publik: register, login).  
- Format respons standar:  
    
  { "success": true, "data": { }, "message": "" }  
    
  { "success": false, "error": { "code": "ERR\_VALIDATION", "message": "" } }  
    
- Rate limiting berlaku per endpoint publik (register, login) dan per IP.

| Endpoint | Metode | Deskripsi | Request Body (ringkas) | Response (ringkas) |
| :---- | :---- | :---- | :---- | :---- |
| `/auth/register` | POST | Registrasi akun warga baru. | `{ name, nik, dob, email, password }` | `{ userId, loginId }` |
| `/auth/login` | POST | Login warga. | `{ loginId, password }` | `{ accessToken, refreshToken, userData }` |
| `/auth/refresh` | POST | Perpanjang access token. | `{ refreshToken }` | `{ accessToken }` |
| `/auth/logout` | POST | Cabut sesi aktif. | `{ refreshToken }` | `{ message }` |
| `/me/password` | PUT | Warga mengubah password sendiri (setelah login). | `{ oldPassword, newPassword }` | `{ message }` |
| `/admin/login` | POST | Login Admin/Super Admin. | `{ username, password }` | `{ accessToken, refreshToken }` |
| `/admin/reauth` | POST | Re-autentikasi Admin sebelum aksi sensitif. | `{ password }` | `{ stepUpToken }` |
| `/admin/users` | GET | Daftar warga (pagination). | `?search=&status=&page=&limit=` | `{ users[], total, page }` |
| `/admin/users/:id/reset-password` | PUT | Reset password warga oleh Admin (butuh `stepUpToken`). | `{ newPassword, stepUpToken }` | `{ message }` |
| `/admin/users/:id/unlock` | PUT | Buka kunci akun warga. | `{ stepUpToken }` | `{ message }` |
| `/submissions` | POST | Pengajuan permohonan baru. | `{ serviceType, formData, fileIds[] }` | `{ ticketNumber, status }` |
| `/submissions` | GET | Riwayat pengajuan milik warga login. | `?status=&page=` | `{ submissions[], total }` |
| `/submissions/:id` | GET | Detail satu pengajuan. | — | `{ submission }` |
| `/submissions/:id/status` | PUT | Update status pengajuan oleh Admin. | `{ status, note, resultFileId? }` | `{ updatedStatus }` |
| `/files/upload` | POST | Unggah berkas (multipart), dipindai antivirus. | `multipart/form-data` | `{ fileId, signedUrl }` |
| `/admin/audit-logs` | GET | Daftar audit log (Super Admin only). | `?actorId=&action=&dateFrom=&dateTo=` | `{ logs[], total }` |

---

## 11\. Skema Basis Data (ERD Ringkas)

| Tabel | Kolom Kunci | Catatan |
| :---- | :---- | :---- |
| `citizens` (warga) | id, full\_name, login\_id (unique), nik (unique, encrypted), dob, email (unique), password\_hash, status, created\_at | `nik` disimpan terenkripsi (AES-256) di kolom, bukan hanya di level disk. |
| `admins` | id, username, password\_hash, role (`admin`/`super_admin`), status, created\_at |  |
| `region_codes` (referensi wilayah) | id, province\_code, city\_code, district\_code, label, is\_active | Sumber kebenaran validasi NIK; dapat diperbarui tanpa deploy ulang. |
| `submissions` | id, ticket\_number (unique), citizen\_id (FK), service\_type, form\_data (JSON), status, note, created\_at, updated\_at |  |
| `submission_files` | id, submission\_id (FK), file\_type (`upload`/`result`), storage\_key, original\_name, mime\_type, uploaded\_by, created\_at |  |
| `audit_logs` | id, actor\_id, actor\_role, target\_id, action, ip\_address, user\_agent, created\_at | Append-only. |
| `sessions` (opsional, untuk revocation) | id, user\_id, user\_type, refresh\_token\_hash, expires\_at, revoked\_at |  |

---

## 12\. Kebutuhan Non-Fungsional (Non-Functional Requirements)

| Kode | Kategori | Deskripsi |
| :---- | :---- | :---- |
| **NFR-01** | Keamanan & Privasi Data | Berkas upload (KTP, KK) & kolom NIK dienkripsi di server (AES-256). Password di-hash Argon2id/Bcrypt (cost ≥ 12). Seluruh akses admin memakai audit trail. Transport wajib TLS 1.2+ (HTTPS enforced, HSTS aktif). |
| **NFR-02** | Performa | Waktu muat dashboard \< 2 detik untuk 1.000 data. Unggah file (2 MB) \< 5 detik pada koneksi standar. |
| **NFR-03** | Responsivitas | Portal Warga: mobile-first (Chrome, Safari, Firefox di Android/iOS). Dashboard Admin: dioptimalkan desktop (min. 1366×768). |
| **NFR-04** | Kepatuhan & Keandalan | PDF terbitan memiliki QR Code verifikasi. Backup database harian \+ rencana pemulihan bencana (RPO ≤ 24 jam, RTO ≤ 4 jam). |
| **NFR-05** | Aksesibilitas | Portal warga ramah disabilitas (ARIA labels, kontras warna memadai, navigasi keyboard). |
| **NFR-06** | Privasi Data (UU PDP) | Warga diberi notifikasi persetujuan pengumpulan data pribadi saat registrasi. Retensi data mengikuti kebijakan instansi; warga dapat mengajukan permintaan penghapusan data melalui Admin (dicatat di audit log). Data pribadi tidak dibagikan ke pihak ketiga tanpa dasar hukum. |
| **NFR-07** | Keamanan Aplikasi | Proteksi terhadap OWASP Top 10 (injection, broken auth, XSS, CSRF token pada form Admin, dsb.). Penetration testing sebelum go-live. |
| **NFR-08** | Observability | Logging terpusat (tanpa mencatat password/NIK mentah), monitoring uptime, alerting untuk anomali login (mis. banyak percobaan gagal). |

---

## 13\. Skenario Edge Cases & Penanganan Error

| Skenario | Penanganan |
| :---- | :---- |
| Warga memasukkan NIK dengan format salah | Pesan error spesifik: "NIK harus 16 digit angka dan sesuai wilayah layanan (kode provinsi 16)." |
| Warga mengunggah file \> 2 MB | Sistem menolak unggahan: "Ukuran file maksimal 2 MB." |
| Warga lupa Login ID | Diarahkan ke petunjuk pembentukan Login ID (4.2 poin 4); jika tetap tidak ditemukan, datang ke kantor untuk dibantu Admin. |
| Warga lupa password dan datang ke kantor, data tidak ditemukan | Admin memverifikasi ulang di database; jika benar tidak terdaftar, warga diarahkan melakukan registrasi baru. |
| Admin tidak sengaja mereset password warga yang salah | Tercatat di audit log lengkap (termasuk step-up auth), dapat diinvestigasi dan dilaporkan ke Super Admin. |
| Pengajuan berstatus `REJECTED` tanpa unggah ulang \> 30 hari | Status otomatis berubah menjadi `EXPIRED`; sistem dapat mengirim pengingat email pada hari ke-25 (opsional, jika notifikasi diaktifkan). |
| **Dua warga memiliki Nama Lengkap identik** | **Terselesaikan (v1.2.0):** sistem membentuk Login ID unik otomatis (slug nama \+ sufiks angka bila perlu), sehingga login tidak lagi bergantung pada keunikan nama asli. |
| Percobaan login bertubi-tubi (brute force) pada satu akun | Rate limiting \+ lockout sementara \+ exponential backoff; dicatat untuk deteksi anomali (NFR-08). |
| Sesi Admin dibiarkan terbuka di komputer publik | Timeout otomatis 15 menit; aksi sensitif tetap butuh re-autentikasi terlepas dari status sesi (4.3.2 poin 6). |

---

## 14\. Kriteria Penerimaan (User Acceptance Criteria — UAC)

| Kode | Kriteria | Status |
| :---- | :---- | :---- |
| UAC-01 | Warga dapat mendaftar akun dengan NIK Sumsel yang valid dan menerima Login ID unik. | \[ \] |
| UAC-02 | Warga dapat login menggunakan Login ID dan Password; dua warga dengan nama sama tetap dapat login tanpa konflik. | \[ \] |
| UAC-03 | Warga dapat mengajukan permohonan KK/Akta Lahir/Akta Mati dalam \< 5 menit. | \[ \] |
| UAC-04 | Admin dapat melihat daftar semua warga dan mencari berdasarkan Nama/Login ID/NIK. | \[ \] |
| UAC-05 | Admin dapat mereset password warga melalui modal "Ganti Password" setelah re-autentikasi berhasil. | \[ \] |
| UAC-06 | Setiap aksi reset password tercatat di audit log dengan detail lengkap dan bersifat append-only. | \[ \] |
| UAC-07 | Admin dapat melakukan verifikasi (preview, approve, reject, catatan) pada pengajuan. | \[ \] |
| UAC-08 | Warga dapat mengunduh PDF dokumen (dengan QR code) setelah status `APPROVED`. | \[ \] |
| UAC-09 | Portal warga responsif di perangkat mobile dan memenuhi kriteria aksesibilitas dasar. | \[ \] |
| UAC-10 | Pengajuan `REJECTED` yang tidak diperbarui \> 30 hari otomatis berubah menjadi `EXPIRED`. | \[ \] |
| UAC-11 | Percobaan login gagal berulang memicu lockout sesuai kebijakan rate limiting. | \[ \] |

---

## 15\. Metrik Keberhasilan (Success Metrics)

1. **Adopsi Pengguna:** 60% dari total permohonan dokumen dialihkan ke platform digital dalam 6 bulan pertama.  
2. **Kecepatan Layanan:** waktu rata-rata verifikasi admin turun dari 1 hari menjadi \< 4 jam kerja.  
3. **Efektivitas Reset Password:** proses reset manual di kantor selesai \< 5 menit sejak warga datang.  
4. **Kepuasan Pengguna (CSAT):** skor \> 4.0 dari 5.0 pada survei kuartalan.  
5. **Akurasi Data:** kesalahan input (typo) berkurang hingga 90% lewat validasi otomatis.  
6. **Keamanan:** nol insiden kebocoran data pribadi warga dalam 12 bulan pertama pasca go-live.

---

## 16\. Glosarium

| Istilah | Penjelasan |
| :---- | :---- |
| Login ID | Pengenal unik untuk login warga, dibentuk otomatis dari nama, menggantikan penggunaan NIK/nama mentah. |
| Step-up Authentication | Permintaan re-autentikasi tambahan sebelum aksi sensitif (mis. reset password oleh Admin). |
| Audit Log | Catatan append-only atas aksi-aksi sensitif dalam sistem untuk keperluan akuntabilitas. |
| Signed URL | Tautan akses file dengan tanda tangan digital dan masa berlaku terbatas. |
| RPO / RTO | Recovery Point/Time Objective — target maksimum kehilangan data / waktu pemulihan saat insiden. |

---

## 17\. Lampiran & Referensi

- **Flowchart Alur Sistem:** \[Insert Link Diagram/Gambar\]  
- **Mockup Desain UI (Figma):** \[Insert Link Figma\]  
- **Struktur Database (ERD Visual):** \[Insert Link ERD — turunan dari Bab 11\]  
- **Referensi Kode Wilayah Administratif:** sumber resmi Kemendagri/Permendagri (isi tabel `region_codes` wajib diverifikasi ulang oleh tim sebelum go-live, bukan hasil asumsi dokumen ini).  
- **Referensi Regulasi:** UU No. 27 Tahun 2022 tentang Pelindungan Data Pribadi.

---

**Penutup**

Dokumen PRD versi 1.2.0 ini menyempurnakan versi sebelumnya dengan menutup celah desain pada mekanisme login (kolisi nama), memperkuat keamanan aksi administratif (re-autentikasi, audit log append-only, manajemen sesi/token), melengkapi skema database dan standar API, serta menambahkan kepatuhan privasi data. Dengan persetujuan pemangku kepentingan, tim pengembangan dapat memulai fase sprint planning.

---

**Disusun oleh:** Paduka / Xpawto **Tanggal:** 23 Juli 2026

**Disetujui oleh:**

---

**(Kepala Dinas / Pimpinan Proyek)**  
