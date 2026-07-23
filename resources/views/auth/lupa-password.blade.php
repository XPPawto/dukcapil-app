<x-layouts.guest title="Lupa Password">
    <div class="max-w-2xl mx-auto px-4 sm:px-6 py-16">
        <div class="text-center mb-8">
            <div class="w-20 h-20 rounded-full bg-amber-100 text-amber-600 flex items-center justify-center mx-auto">
                <svg class="w-11 h-11" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 5.25a3 3 0 0 1 3 3m3 0a6 6 0 0 1-7.029 5.912c-.563-.097-1.159.026-1.563.43L10.5 17.25H8.25v2.25H6v2.25H2.25v-2.818c0-.597.237-1.17.659-1.591l6.499-6.499c.404-.404.527-1 .43-1.563A6 6 0 1 1 21.75 8.25Z" /></svg>
            </div>
            <h1 class="mt-6 text-3xl sm:text-4xl font-extrabold text-gray-900">Lupa Password?</h1>
        </div>

        <x-card class="p-6 sm:p-8 space-y-6">
            <div>
                <p class="text-lg text-gray-700 leading-relaxed">
                    Untuk keamanan data Anda, <strong>perubahan password hanya dapat dilakukan secara langsung di kantor pelayanan.</strong>
                    Kami tidak menyediakan reset password melalui email atau SMS.
                </p>
            </div>

            <x-alert type="info">
                <p class="font-semibold mb-1">Silakan datang ke kantor dengan membawa:</p>
                <ul class="list-disc list-inside space-y-1">
                    <li>KTP asli</li>
                    <li>Kartu Keluarga (KK) asli</li>
                </ul>
                <p class="mt-2">Petugas akan memverifikasi identitas Anda dan membantu mengganti password secara langsung.</p>
            </x-alert>

            <div class="bg-gray-50 rounded-xl border border-gray-200 p-5">
                <p class="text-base font-semibold text-gray-800">Jam Layanan</p>
                <p class="text-base text-gray-600 mt-1">Senin&ndash;Jumat, 08.00&ndash;15.00 WIB</p>
                <p class="text-base text-gray-600">Telepon: (0711) 000-0000</p>
            </div>
        </x-card>

        <div class="text-center mt-8">
            <x-link-button :href="route('login')" variant="secondary" size="lg">Kembali ke Halaman Masuk</x-link-button>
        </div>
    </div>
</x-layouts.guest>
