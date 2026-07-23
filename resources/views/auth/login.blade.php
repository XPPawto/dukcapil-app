<x-layouts.guest title="Masuk">
    <div class="max-w-md mx-auto px-4 sm:px-6 py-16">
        <div class="text-center mb-8">
            <h1 class="text-3xl sm:text-4xl font-extrabold text-gray-900">Masuk ke Akun Anda</h1>
            <p class="mt-3 text-lg text-gray-600">Untuk warga, gunakan NIK dan Password. Petugas dapat masuk dengan Username.</p>
        </div>

        <x-card class="p-6 sm:p-8">
            @if($errors->any())
                <x-alert type="danger" class="mb-6">{{ $errors->first() }}</x-alert>
            @endif

            <form method="POST" action="{{ route('login.store') }}" class="space-y-6">
                @csrf

                <div>
                    <x-label for="identifier" required>NIK / Username</x-label>
                    <x-input type="text" inputmode="numeric" id="identifier" name="identifier" value="{{ old('identifier') }}"
                        placeholder="16 digit NIK (warga) atau username petugas" required autofocus :error="$errors->first('identifier')" />
                    <x-input-error :message="$errors->first('identifier')" />
                </div>

                <div>
                    <x-label for="password" required>Password</x-label>
                    <x-input type="password" id="password" name="password" required :error="$errors->first('password')" />
                    <x-input-error :message="$errors->first('password')" />
                </div>

                <x-button type="submit" class="w-full">Masuk</x-button>

                <p class="text-center text-base">
                    <a href="{{ route('lupa-password') }}" class="font-semibold text-brand-700 hover:underline">Lupa Password?</a>
                </p>
            </form>
        </x-card>

        <p class="text-center text-lg text-gray-600 mt-6">
            Belum punya akun? <a href="{{ route('register') }}" class="font-semibold text-brand-700 hover:underline">Daftar di sini</a>
        </p>
    </div>
</x-layouts.guest>
