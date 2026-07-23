<x-layouts.guest title="Pendaftaran Berhasil">
    <div class="max-w-xl mx-auto px-4 sm:px-6 py-16 text-center">
        <div class="w-20 h-20 rounded-full bg-emerald-100 text-emerald-600 flex items-center justify-center mx-auto">
            <svg class="w-11 h-11" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" /></svg>
        </div>
        <h1 class="mt-6 text-3xl font-extrabold text-gray-900">Pendaftaran Berhasil!</h1>
        <p class="mt-3 text-lg text-gray-600">Terima kasih, {{ $nama }}. Catat baik-baik <strong>Login ID</strong> Anda di bawah ini — Anda akan menggunakannya setiap kali masuk ke aplikasi.</p>

        <div class="mt-8 bg-white border-2 border-brand-200 rounded-2xl p-6">
            <p class="text-base text-gray-500 font-semibold">Login ID Anda</p>
            <p class="mt-2 text-4xl font-extrabold text-brand-700 tracking-wide">{{ $loginId }}</p>
        </div>

        <x-alert type="warning" class="mt-6 text-left">
            Login ID ini tidak dapat diubah sendiri. Simpan baik-baik atau tuliskan di tempat yang aman.
            Login ID juga sudah kami kirimkan sebagai catatan ke email Anda.
        </x-alert>

        <div class="mt-8">
            <x-link-button :href="route('login')" size="lg">Lanjut ke Halaman Masuk</x-link-button>
        </div>
    </div>
</x-layouts.guest>
