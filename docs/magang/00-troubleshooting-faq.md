# Troubleshooting & FAQ

Kumpulan error yang paling sering muncul buat pemula, dan cara membacanya. Cek di sini dulu sebelum tanya mentor — banyak masalah yang bisa kamu selesaikan sendiri dalam 1 menit begitu tahu penyebabnya.

## Cara Membaca Halaman Error Laravel

Kalau ada yang salah di kode PHP, browser akan menampilkan halaman error (biasanya latar putih/abu, tulisan besar di atas). Bagian yang paling penting cuma 3:

1. **Judul besar di atas** — inti masalahnya, contoh: `syntax error, unexpected token ";"` atau `Class "App\Models\Foo" not found`.
2. **Nama file & nomor baris** — biasanya ditulis seperti `PermohonanController.php:45` atau muncul di kotak kode dengan satu baris di-highlight warna beda. **Ini paling penting** — buka file itu, pergi ke baris itu persis.
3. **Baris kode yang di-highlight** — bandingkan pelan-pelan, karakter per karakter, dengan kode yang ada di panduan (`.pdf` tugasmu). Biasanya bedanya cuma 1 karakter kecil (kurung, koma, titik koma, kutip).

**Tips:** jangan baca semua tulisan panjang di halaman error (itu "stack trace", buat programmer berpengalaman). Fokus ke judul + nama file + nomor baris saja.

## Daftar Error yang Sering Muncul

### "This site can't be reached" / "localhost refused to connect"
**Penyebab:** Docker belum jalan, atau aplikasinya belum selesai booting.
**Solusi:**
1. Buka **Docker Desktop**, pastikan statusnya **"Engine running"**.
2. Buka terminal di folder project, jalankan lagi:
   ```
   docker compose up -d
   ```
3. Tunggu 1-2 menit (kadang lebih lama di percobaan pertama), baru buka ulang http://localhost:8000

### "Port is already allocated" / "bind: address already in use"
**Penyebab:** ada aplikasi lain di laptop kamu yang sudah memakai port yang sama (biasanya port 8000, 3306, atau 8080).
**Solusi:** restart laptop biasanya membereskan ini. Kalau masih muncul setelah restart, screenshot pesan errornya dan tanya mentor — mungkin perlu ganti nomor port di `docker-compose.yml`, biar mentor saja yang atur.

### Halaman putih kosong / "500 | Server Error" tanpa detail
**Penyebab:** hampir selalu ada salah ketik di file PHP yang baru diedit (tanda kutip `'` atau `"` tidak ditutup, koma `,` kurang/lebih, kurung `(` `)` tidak seimbang).
**Solusi:** buka file yang barusan kamu edit, bandingkan **persis** (huruf, tanda baca, spasi) dengan kode di panduan. Kesalahan paling sering: lupa titik koma `;` di akhir baris, atau kurang satu `)`.

### "syntax error, unexpected ..." / "syntax error, unexpected token"
**Penyebab:** typo di kode — biasanya lupa `;`, kurung tidak seimbang, atau ada tanda kutip yang belum ditutup.
**Solusi:** pesan errornya menyebutkan nama file dan baris. Buka baris itu, dan **baris tepat di atasnya** — 90% kasus, kesalahannya ada di baris sebelum yang disebutkan (misal lupa `;` di baris atasnya).

### "Class ... not found" (contoh: `Class "App\Models\Submission" not found`)
**Penyebab:** kamu memakai sebuah Model/Class di kode, tapi lupa menambahkan baris `use App\Models\...;` di bagian atas file.
**Solusi:** cek langkah di panduan tugasmu — di awal biasanya ada instruksi "tambahkan baris use ini di bawah namespace". Pastikan baris itu sudah ditambahkan dan tidak ada typo pada namanya.

### CSS berantakan / tampilan jadi acak-acakan
**Penyebab:** biasanya cuma perlu refresh browser (**Ctrl+Shift+R** untuk refresh yang benar-benar bersih, bukan cache lama).
**Solusi:** kalau setelah refresh masih berantakan, tanya mentor — jangan sentuh file di folder `resources/css` atau `resources/js`, itu di luar tugas kamu.

### Tulisan "SQLSTATE..." di error
**Penyebab:** biasanya database belum siap (container MySQL belum selesai booting) atau ada masalah struktur tabel.
**Solusi:** tunggu 1-2 menit lalu coba lagi. Kalau masih muncul, jangan otak-atik sendiri — screenshot errornya dan tanya mentor, karena ini biasanya bukan salah kode kamu.

### Halaman menampilkan pesan "Fitur ... sedang dikerjakan tim magang"
**Ini bukan error!** Itu tandanya kamu belum menyelesaikan langkah di panduan untuk bagian itu — bukan ada yang rusak. Lanjutkan mengikuti panduan tugasmu.

### GitHub Desktop: tombol "Push origin" tidak muncul / error saat push
**Penyebab:** biasanya belum ada perubahan yang di-**commit** dulu, atau koneksi internet putus.
**Solusi:** pastikan sudah klik **Commit to (nama branch)** dulu sebelum push. Cek koneksi internet. Kalau muncul tulisan merah soal "conflict", jangan coba beresin sendiri — tanya mentor.

### Lupa NIK/password akun warga yang dipakai testing
**Solusi:** daftar akun baru saja lewat halaman `/register` khusus untuk latihan/testing — tidak masalah bikin banyak akun percobaan. Jangan pakai data pribadi asli untuk testing.

## Sebelum Tanya Mentor, Cek Dulu:

- [ ] File sudah di-**save** (Ctrl+S)? Cek tab nama file — kalau masih ada titik bulat kecil, berarti belum tersimpan.
- [ ] Sudah **refresh browser** (Ctrl+Shift+R)?
- [ ] Docker Desktop statusnya **"Engine running"**?
- [ ] Sudah baca judul + nama file + nomor baris di pesan error?
- [ ] Sudah bandingkan kode yang ditulis **karakter per karakter** dengan yang ada di panduan PDF tugasmu?

Kalau semua sudah dicek dan tetap bingung, itu wajar — screenshot pesan errornya (semuanya, jangan dipotong) dan tanya mentor. Tidak apa-apa bertanya, itu bagian dari belajar.
