<x-layouts.app title="Profil Saya">
    <div class="mb-8">
        <h1 class="text-3xl font-extrabold text-gray-900">Profil Saya</h1>
        <p class="mt-2 text-lg text-gray-600">Lihat dan kelola data akun Anda.</p>
    </div>

    <div class="grid lg:grid-cols-3 gap-6">
        <div class="lg:col-span-1">
            <x-card class="p-6 text-center">
                <div class="w-24 h-24 rounded-full bg-brand-600 text-white flex items-center justify-center text-3xl font-bold mx-auto">
                    {{ strtoupper(substr($profil['nama'], 0, 1)) }}
                </div>
                <p class="mt-4 text-xl font-bold text-gray-900">{{ $profil['nama'] }}</p>
                <p class="text-base text-gray-500">NIK: {{ $profil['nik'] }}</p>
            </x-card>
        </div>

        <div class="lg:col-span-2 space-y-6">
            <x-card class="p-6 sm:p-8">
                <h2 class="text-xl font-bold text-gray-900 mb-6">Data Diri</h2>
                <dl class="grid sm:grid-cols-2 gap-5 text-base mb-6">
                    <div>
                        <dt class="text-gray-500">Nama Lengkap</dt>
                        <dd class="font-semibold text-gray-900 mt-0.5">{{ $profil['nama'] }}</dd>
                    </div>
                    <div>
                        <dt class="text-gray-500">NIK</dt>
                        <dd class="font-semibold text-gray-900 mt-0.5">{{ $profil['nik'] }}</dd>
                    </div>
                    <div>
                        <dt class="text-gray-500">Tanggal Lahir</dt>
                        <dd class="font-semibold text-gray-900 mt-0.5">{{ $profil['tanggal_lahir'] }}</dd>
                    </div>
                </dl>
                <x-alert type="info">
                    Nama dan NIK tidak dapat diubah sendiri. Jika ada kesalahan data, silakan datang ke kantor pelayanan.
                </x-alert>
            </x-card>

            <x-card class="p-6 sm:p-8">
                <h2 class="text-xl font-bold text-gray-900 mb-6">Ubah Email</h2>
                <form method="POST" action="{{ route('warga.profil.email') }}" class="space-y-5">
                    @csrf
                    @method('PUT')
                    <div>
                        <x-label for="email" required>Alamat Email</x-label>
                        <x-input type="email" id="email" name="email" value="{{ $profil['email'] }}" required :error="$errors->first('email')" />
                        <x-input-error :message="$errors->first('email')" />
                    </div>
                    <x-button type="submit" variant="secondary">Simpan Email</x-button>
                </form>
            </x-card>

            <x-card class="p-6 sm:p-8">
                <h2 class="text-xl font-bold text-gray-900 mb-6">Ubah Password</h2>
                <form method="POST" action="{{ route('warga.profil.password') }}" class="space-y-5">
                    @csrf
                    @method('PUT')
                    <div>
                        <x-label for="password_lama" required>Password Saat Ini</x-label>
                        <x-input type="password" id="password_lama" name="password_lama" required :error="$errors->first('password_lama')" />
                        <x-input-error :message="$errors->first('password_lama')" />
                    </div>
                    <div>
                        <x-label for="password_baru" required>Password Baru</x-label>
                        <x-input type="password" id="password_baru" name="password_baru" required :error="$errors->first('password_baru')" />
                        <x-help-text>Minimal 8 karakter, kombinasi huruf besar, huruf kecil, dan angka.</x-help-text>
                        <x-input-error :message="$errors->first('password_baru')" />
                    </div>
                    <div>
                        <x-label for="password_baru_confirmation" required>Konfirmasi Password Baru</x-label>
                        <x-input type="password" id="password_baru_confirmation" name="password_baru_confirmation" required />
                    </div>
                    <x-button type="submit" variant="secondary">Ubah Password</x-button>
                </form>
            </x-card>
        </div>
    </div>
</x-layouts.app>
