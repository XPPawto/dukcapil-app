<x-layouts.guest title="Pendaftaran Berhasil">
    <div class="max-w-xl mx-auto px-4 sm:px-6 py-16 text-center">
        <div class="w-20 h-20 rounded-full bg-emerald-100 text-emerald-600 flex items-center justify-center mx-auto">
            <svg class="w-11 h-11" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" /></svg>
        </div>
        <h1 class="mt-6 text-3xl font-extrabold text-gray-900">Pendaftaran Berhasil!</h1>
        <p class="mt-3 text-lg text-gray-600">Terima kasih, {{ $nama }}. Akun Anda sudah aktif.</p>

        <x-alert type="info" class="mt-8 text-left">
            Untuk masuk ke aplikasi, gunakan <strong>NIK</strong> dan <strong>Password</strong> yang baru saja Anda daftarkan.
        </x-alert>

        <div class="mt-8">
            <x-link-button :href="route('login')" size="lg">Lanjut ke Halaman Masuk</x-link-button>
        </div>
    </div>
</x-layouts.guest>
