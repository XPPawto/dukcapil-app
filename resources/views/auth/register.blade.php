<x-layouts.guest title="Daftar Akun">
    <div class="max-w-2xl mx-auto px-4 sm:px-6 py-12">
        <div class="text-center mb-8">
            <h1 class="text-3xl sm:text-4xl font-extrabold text-gray-900">Daftar Akun Warga</h1>
            <p class="mt-3 text-lg text-gray-600">Isi data di bawah ini dengan benar sesuai KTP Anda.</p>
        </div>

        <x-card class="p-6 sm:p-8">
            @if($errors->any())
                <x-alert type="danger" class="mb-6">
                    Ada data yang belum sesuai. Mohon periksa kembali isian di bawah.
                </x-alert>
            @endif

            <form method="POST" action="{{ route('register.store') }}" class="space-y-6">
                @csrf

                <div>
                    <x-label for="nama_lengkap" required>Nama Lengkap</x-label>
                    <x-input type="text" id="nama_lengkap" name="nama_lengkap" value="{{ old('nama_lengkap') }}"
                        placeholder="Contoh: Suratno Wijaya" required :error="$errors->first('nama_lengkap')" />
                    <x-help-text>Sesuai nama pada KTP.</x-help-text>
                    <x-input-error :message="$errors->first('nama_lengkap')" />
                </div>

                <div>
                    <x-label for="nik" required>Nomor Induk Kependudukan (NIK)</x-label>
                    <x-input type="text" inputmode="numeric" maxlength="16" id="nik" name="nik" value="{{ old('nik') }}"
                        placeholder="16 digit angka pada KTP" required :error="$errors->first('nik')" />
                    <x-help-text>Hanya untuk warga Kecamatan Plaju dan Seberang Ulu II, Kota Palembang.</x-help-text>
                    <x-input-error :message="$errors->first('nik')" />
                </div>

                <div>
                    <x-label required>Tanggal Lahir</x-label>
                    <div class="grid grid-cols-3 gap-3">
                        <select name="lahir_tanggal" required
                            class="block w-full rounded-xl border-2 border-gray-300 px-3 py-3.5 text-lg text-gray-900 focus:outline-none focus:ring-3 focus:ring-brand-500/40 focus:border-brand-500">
                            <option value="">Tanggal</option>
                            @for($d = 1; $d <= 31; $d++)
                                <option value="{{ $d }}" @selected(old('lahir_tanggal') == $d)>{{ $d }}</option>
                            @endfor
                        </select>
                        <select name="lahir_bulan" required
                            class="block w-full rounded-xl border-2 border-gray-300 px-3 py-3.5 text-lg text-gray-900 focus:outline-none focus:ring-3 focus:ring-brand-500/40 focus:border-brand-500">
                            <option value="">Bulan</option>
                            @foreach(['Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'] as $i => $bulan)
                                <option value="{{ $i + 1 }}" @selected(old('lahir_bulan') == $i + 1)>{{ $bulan }}</option>
                            @endforeach
                        </select>
                        <select name="lahir_tahun" required
                            class="block w-full rounded-xl border-2 border-gray-300 px-3 py-3.5 text-lg text-gray-900 focus:outline-none focus:ring-3 focus:ring-brand-500/40 focus:border-brand-500">
                            <option value="">Tahun</option>
                            @for($y = now()->year; $y >= now()->year - 100; $y--)
                                <option value="{{ $y }}" @selected(old('lahir_tahun') == $y)>{{ $y }}</option>
                            @endfor
                        </select>
                    </div>
                    <x-help-text>Harus sesuai dengan tanggal lahir pada NIK Anda.</x-help-text>
                    <x-input-error :message="$errors->first('tanggal_lahir')" />
                </div>

                <div>
                    <x-label for="email" required>Alamat Email</x-label>
                    <x-input type="email" id="email" name="email" value="{{ old('email') }}"
                        placeholder="nama@email.com" required :error="$errors->first('email')" />
                    <x-help-text>Digunakan untuk menerima notifikasi sistem, bukan untuk reset password.</x-help-text>
                    <x-input-error :message="$errors->first('email')" />
                </div>

                <div>
                    <x-label for="password" required>Password</x-label>
                    <x-input type="password" id="password" name="password" required :error="$errors->first('password')" />
                    <x-help-text>Minimal 8 karakter, kombinasi huruf besar, huruf kecil, dan angka.</x-help-text>
                    <x-input-error :message="$errors->first('password')" />
                </div>

                <div>
                    <x-label for="password_confirmation" required>Konfirmasi Password</x-label>
                    <x-input type="password" id="password_confirmation" name="password_confirmation" required />
                </div>

                <label class="flex items-start gap-3 p-4 bg-gray-50 rounded-xl border border-gray-200 cursor-pointer">
                    <input type="checkbox" name="persetujuan" value="1" required
                        class="mt-1 w-5 h-5 rounded border-2 border-gray-400 text-brand-600 focus:ring-brand-500">
                    <span class="text-base text-gray-700 leading-relaxed">
                        Saya menyetujui data pribadi saya dikumpulkan dan digunakan untuk keperluan layanan kependudukan,
                        sesuai UU No. 27 Tahun 2022 tentang Pelindungan Data Pribadi.
                    </span>
                </label>
                <x-input-error :message="$errors->first('persetujuan')" />

                <x-button type="submit" class="w-full">Daftar Sekarang</x-button>
            </form>
        </x-card>

        <p class="text-center text-lg text-gray-600 mt-6">
            Sudah punya akun? <a href="{{ route('login') }}" class="font-semibold text-brand-700 hover:underline">Masuk di sini</a>
        </p>
    </div>
</x-layouts.guest>
