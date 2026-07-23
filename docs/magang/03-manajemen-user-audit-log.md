# Tugas 3: Manajemen User & Audit Log

> Baca `00-persiapan.md` dulu kalau belum.

## Gambaran Besar

Admin (khususnya **super_admin**) perlu bisa: (1) melihat daftar semua warga terdaftar, (2) **mereset password** warga yang lupa password, (3) **membuka kunci akun** warga yang terkunci karena 5x salah password, dan (4) melihat **Audit Log** — catatan siapa melakukan tindakan sensitif apa dan kapan.

Tampilan halamannya sudah jadi di `resources/views/admin/users/` dan `resources/views/admin/audit-logs/`. Tugasmu ada di dua file:

- **`app/Http/Controllers/Admin/UserController.php`** — 3 bagian: `index()`, `resetPassword()`, `unlock()`
- **`app/Http/Controllers/Admin/AuditLogController.php`** — 1 bagian: `index()`

## Langkah 1 — Daftar Semua Warga (`UserController::index`)

Buka `app/Http/Controllers/Admin/UserController.php`. Cari `TODO(Magang 3 - Manajemen User)` di method `index()` (Ctrl+F, ketik `ambil daftar semua warga`). **Hapus semua isi method itu** — dari baris komentar `// TODO(...)` sampai baris `]);` paling bawah (jangan sentuh `{` di baris sebelum komentar dan `}` di baris paling akhir method) — lalu ketik/paste kode berikut menggantikannya:

```php
$query = Citizen::query()->latest();

if ($status = $request->query('status')) {
    $query->where('status', $status);
}

if ($search = $request->query('cari')) {
    if (ctype_digit($search) && strlen($search) === 16) {
        $query->where('nik_hash', Citizen::hashNik($search));
    } else {
        $query->where('full_name', 'like', "%{$search}%");
    }
}

return view('admin.users.index', [
    'citizens' => $query->get(),
    'statusLabels' => self::STATUS_MAP,
    'search' => $search ?? '',
    'statusFilter' => $status ?? '',
]);
```

**Penjelasan:** ambil semua warga, urut terbaru dulu. NIK **tidak disimpan polos** di database (dienkripsi demi keamanan), jadi untuk mencari berdasarkan NIK kita bandingkan lewat `nik_hash` — ada fungsi siap pakai `Citizen::hashNik($search)` untuk itu, kamu tinggal panggil.

## Langkah 2 — Reset Password Warga (`resetPassword`)

Tambahkan baris `use` ini di atas file `UserController.php`, dekat `use App\Models\Citizen;`:

```php
use App\Models\AuditLog;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
```

Cari `TODO(Magang 3 - Manajemen User)` di method `resetPassword()` (Ctrl+F, ketik `minta admin memasukkan ulang password-nya sendiri` — akan ada 2 hasil, pastikan pilih yang di method `resetPassword`). **Hapus semua isi method itu** — dari baris komentar `// TODO(...)` sampai baris `return back()->with(...)` — lalu ketik/paste kode berikut:

```php
$admin = Auth::guard('admin')->user();

$validated = $request->validate([
    'admin_password' => ['required', 'string'],
    'password_baru' => ['required', 'confirmed', Password::min(8)->mixedCase()->numbers()],
]);

if (! Hash::check($validated['admin_password'], $admin->password)) {
    return back()->withErrors(['admin_password' => 'Password Anda salah. Reset dibatalkan.']);
}

$citizen->forceFill([
    'password' => $validated['password_baru'],
    'status' => 'active',
    'failed_login_attempts' => 0,
    'locked_until' => null,
])->save();

AuditLog::record($admin, 'reset_password', 'citizen', $citizen->id, $citizen->full_name, $request);

return redirect()
    ->route('admin.users.index')
    ->with('status', 'Password warga berhasil direset. Tindakan ini telah tercatat di Audit Log.');
```

**Penjelasan penting — kenapa ada `admin_password`:** ini namanya *step-up authentication*. Karena reset password warga adalah tindakan sensitif, admin diminta memasukkan ulang **password miliknya sendiri** sebagai bukti bahwa benar dia yang melakukan ini (bukan orang lain yang kebetulan memegang laptopnya yang masih login). `Hash::check(...)` yang mengeceknya. Kalau salah, prosesnya dibatalkan.

## Langkah 3 — Buka Kunci Akun (`unlock`)

Cari `TODO(Magang 3 - Manajemen User)` di method `unlock()` (hasil ke-2 dari pencarian sebelumnya). **Hapus semua isi method itu** — dari baris komentar `// TODO(...)` sampai baris `return back()->with(...)` — lalu ketik/paste kode berikut:

```php
$admin = Auth::guard('admin')->user();

$validated = $request->validate(['admin_password' => ['required', 'string']]);

if (! Hash::check($validated['admin_password'], $admin->password)) {
    return back()->withErrors(['admin_password' => 'Password Anda salah. Tindakan dibatalkan.']);
}

$citizen->forceFill(['status' => 'active', 'failed_login_attempts' => 0, 'locked_until' => null])->save();

AuditLog::record($admin, 'unlock_account', 'citizen', $citizen->id, $citizen->full_name, $request);

return redirect()
    ->route('admin.users.index')
    ->with('status', 'Akun warga berhasil dibuka kembali.');
```

**Penjelasan:** sama pola dengan reset password (step-up auth pakai `admin_password`), tapi yang direset di sini adalah status kunci akunnya, bukan passwordnya.

## Langkah 4 — Audit Log (`AuditLogController::index`)

Buka `app/Http/Controllers/Admin/AuditLogController.php`. Tambahkan `use App\Models\AuditLog;` di bawah `namespace`. Cari `TODO(Magang 3 - Manajemen User)` di method `index()`, ganti baris `'logs' => new LengthAwarePaginator([], 0, 30),` menjadi:

```php
'logs' => AuditLog::latest()->paginate(30),
```

Baris `use Illuminate\Pagination\LengthAwarePaginator;` yang lama boleh dihapus kalau sudah tidak dipakai.

**Penjelasan:** `AuditLog::latest()` mengambil semua catatan audit dari yang terbaru, `paginate(30)` membaginya 30 baris per halaman supaya tidak berat kalau catatannya sudah banyak.

## Cara Coba Sendiri (Testing Manual)

1. Login sebagai admin: `uptdzona3@admin.com` / `uptdzona3password`.
2. Buka menu **Manajemen User** (atau nama serupa di sidebar), pastikan daftar warga terdaftar muncul.
3. Coba cari warga pakai nama dan pakai NIK 16 digit.
4. Klik salah satu warga, coba **Reset Password**: masukkan password admin yang **salah** dulu — harus muncul pesan error. Lalu ulangi dengan password admin yang **benar** — harus berhasil.
5. Coba juga tombol **Buka Kunci Akun** dengan cara yang sama.
6. Buka menu **Audit Log**, pastikan 2 tindakan tadi (reset password & unlock) muncul di daftar, lengkap dengan siapa yang melakukan dan kapan.
7. Coba login sebagai petugas biasa (`uptdzona3@petugas.com`, bukan super_admin) — halaman Audit Log seharusnya **menolak akses** (403), karena hanya super_admin yang boleh lihat. Ini sudah diatur otomatis di baris `abort_unless(...)` paling atas method, kamu tidak perlu ubah.
