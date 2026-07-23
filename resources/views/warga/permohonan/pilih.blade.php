<x-layouts.app title="Ajukan Permohonan" :namaWarga="session('warga_nama', 'Warga')">
    <div class="mb-8">
        <h1 class="text-3xl font-extrabold text-gray-900">Pilih Jenis Layanan</h1>
        <p class="mt-2 text-lg text-gray-600">Pilih dokumen yang ingin Anda ajukan.</p>
    </div>

    <div class="grid sm:grid-cols-3 gap-6">
        <a href="{{ route('warga.permohonan.kk') }}" class="group">
            <x-card class="p-7 h-full hover:border-brand-400 hover:shadow-md transition">
                <div class="w-14 h-14 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center mb-4">
                    <svg class="w-8 h-8" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M18 18.72a9.094 9.094 0 0 0 3.741-.479 3 3 0 0 0-4.682-2.72m.94 3.198.001.031c0 .225-.012.447-.037.666A11.944 11.944 0 0 1 12 21c-2.17 0-4.207-.576-5.963-1.584A6.062 6.062 0 0 1 6 18.719m12 0a5.971 5.971 0 0 0-.941-3.197m0 0A5.995 5.995 0 0 0 12 12.75a5.995 5.995 0 0 0-5.058 2.772m0 0a3 3 0 0 0-4.681 2.72 8.986 8.986 0 0 0 3.74.477m.94-3.197a5.971 5.971 0 0 0-.94 3.197M15 6.75a3 3 0 1 1-6 0 3 3 0 0 1 6 0Zm6 3a2.25 2.25 0 1 1-4.5 0 2.25 2.25 0 0 1 4.5 0Zm-13.5 0a2.25 2.25 0 1 1-4.5 0 2.25 2.25 0 0 1 4.5 0Z" /></svg>
                </div>
                <h3 class="text-xl font-bold text-gray-900">Kartu Keluarga</h3>
                <p class="text-gray-600 mt-2 text-base leading-relaxed">Pembuatan baru atau perubahan data anggota keluarga.</p>
                <span class="inline-flex items-center gap-1 mt-4 text-brand-700 font-semibold text-base group-hover:underline">
                    Ajukan Sekarang
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3" /></svg>
                </span>
            </x-card>
        </a>

        <a href="{{ route('warga.permohonan.akta-lahir') }}" class="group">
            <x-card class="p-7 h-full hover:border-brand-400 hover:shadow-md transition">
                <div class="w-14 h-14 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center mb-4">
                    <svg class="w-8 h-8" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M9.75 9.75c0-1.03.84-1.875 1.875-1.875h.75c1.036 0 1.875.845 1.875 1.875v.75a1.875 1.875 0 0 1-1.875 1.875h-.375a1.875 1.875 0 0 0-1.875 1.875v.375m1.875 5.25a9 9 0 1 0 0-18 9 9 0 0 0 0 18Zm.75-15h.008v.008h-.008V9.75Z" /></svg>
                </div>
                <h3 class="text-xl font-bold text-gray-900">Akta Kelahiran</h3>
                <p class="text-gray-600 mt-2 text-base leading-relaxed">Penerbitan akta kelahiran untuk anak yang baru lahir.</p>
                <span class="inline-flex items-center gap-1 mt-4 text-brand-700 font-semibold text-base group-hover:underline">
                    Ajukan Sekarang
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3" /></svg>
                </span>
            </x-card>
        </a>

        <a href="{{ route('warga.permohonan.akta-mati') }}" class="group">
            <x-card class="p-7 h-full hover:border-brand-400 hover:shadow-md transition">
                <div class="w-14 h-14 rounded-xl bg-gray-100 text-gray-600 flex items-center justify-center mb-4">
                    <svg class="w-8 h-8" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M11.35 3.836c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4c.414 0 .75-.336.75-.75 0-.231-.035-.454-.1-.664M11.35 3.836c.223-.722.898-1.246 1.65-1.246h4c.752 0 1.427.524 1.65 1.246m-7.3 0C9.311 4.512 8.75 5.427 8.75 6.354V19.5A2.25 2.25 0 0 0 11 21.75h2A2.25 2.25 0 0 0 15.25 19.5V6.354c0-.927-.561-1.842-1.4-2.518" /></svg>
                </div>
                <h3 class="text-xl font-bold text-gray-900">Akta Kematian</h3>
                <p class="text-gray-600 mt-2 text-base leading-relaxed">Pencatatan dan penerbitan akta kematian.</p>
                <span class="inline-flex items-center gap-1 mt-4 text-brand-700 font-semibold text-base group-hover:underline">
                    Ajukan Sekarang
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3" /></svg>
                </span>
            </x-card>
        </a>
    </div>
</x-layouts.app>
