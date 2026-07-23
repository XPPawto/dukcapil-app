<x-layouts.base :title="$title ?? null">
    <div class="min-h-screen flex flex-col">
        <header class="bg-white border-b border-gray-200">
            <div class="max-w-6xl mx-auto px-4 sm:px-6 py-4 flex items-center justify-between">
                <a href="{{ url('/') }}"><x-app-logo /></a>
                <nav class="flex items-center gap-3">
                    <a href="{{ route('login') }}" class="hidden sm:inline-flex items-center px-4 py-2.5 text-base font-semibold text-gray-700 hover:text-brand-700">Masuk</a>
                    <x-link-button :href="route('register')" size="md">Daftar Akun</x-link-button>
                </nav>
            </div>
        </header>

        <main class="flex-1">
            {{ $slot }}
        </main>

        <footer class="bg-gray-900 text-gray-300 mt-auto">
            <div class="max-w-6xl mx-auto px-4 sm:px-6 py-10 grid gap-8 sm:grid-cols-3">
                <div>
                    <x-app-logo dark />
                    <p class="mt-3 text-base text-gray-400">Layanan mandiri dokumen kependudukan untuk warga Kecamatan Plaju dan Seberang Ulu II, Kota Palembang.</p>
                </div>
                <div>
                    <h3 class="text-white font-semibold text-lg mb-3">Butuh Bantuan?</h3>
                    <p class="text-base text-gray-400 leading-relaxed">Datang langsung ke Kantor Dukcapil pada jam kerja:<br>Senin–Jumat, 08.00–15.00 WIB.</p>
                    <p class="text-base text-gray-400 mt-2">Telepon: (0711) 000-0000</p>
                </div>
                <div>
                    <h3 class="text-white font-semibold text-lg mb-3">Tautan</h3>
                    <ul class="space-y-2 text-base text-gray-400">
                        <li><a href="{{ route('lupa-password') }}" class="hover:text-white">Lupa Password?</a></li>
                        <li><a href="{{ route('login') }}" class="hover:text-white">Masuk sebagai Petugas</a></li>
                    </ul>
                </div>
            </div>
            <div class="border-t border-gray-800 py-4 text-center text-sm text-gray-500">
                &copy; {{ date('Y') }} Sipenkar — Dinas Kependudukan dan Pencatatan Sipil.
            </div>
        </footer>
    </div>
</x-layouts.base>
