<x-layouts.guest>
    <!-- Hero -->
    <section class="bg-white">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 py-14 sm:py-20 grid lg:grid-cols-2 gap-10 items-center">
            <div>
                <span class="inline-flex items-center gap-2 bg-brand-50 text-brand-700 text-base font-semibold px-4 py-2 rounded-full">
                    Layanan Resmi Dinas Kependudukan
                </span>
                <h1 class="mt-5 text-4xl sm:text-5xl font-extrabold text-gray-900 leading-tight">
                    Urus Dokumen Kependudukan Tanpa Antre
                </h1>
                <p class="mt-5 text-xl text-gray-600 leading-relaxed">
                    Ajukan Kartu Keluarga, Akta Kelahiran, dan Akta Kematian secara online dari rumah.
                    Cukup unggah berkas, lalu pantau statusnya sampai selesai.
                </p>
                <div class="mt-8 flex flex-col sm:flex-row gap-4">
                    <x-link-button :href="route('register')" size="lg">
                        Daftar Sekarang
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3" /></svg>
                    </x-link-button>
                    <x-link-button :href="route('login')" variant="secondary" size="lg">Saya Sudah Punya Akun</x-link-button>
                </div>
                <p class="mt-6 text-base text-gray-500">
                    Khusus melayani warga Kecamatan Plaju dan Seberang Ulu II, Kota Palembang.
                </p>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div class="col-span-2 bg-brand-600 rounded-2xl p-6 text-white flex items-center gap-4">
                    <svg class="w-12 h-12 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" /></svg>
                    <div>
                        <p class="text-lg font-semibold">Status Real-Time</p>
                        <p class="text-brand-100 text-base">Pantau pengajuan Anda kapan saja.</p>
                    </div>
                </div>
                <div class="bg-white border-2 border-gray-200 rounded-2xl p-6">
                    <svg class="w-10 h-10 text-brand-600 mb-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 12.75c1.148 0 2.278.08 3.383.236 1.037.146 1.866.966 1.866 2.013 0 3.728-2.35 6.75-3.5 6.75s-3.5-3.022-3.5-6.75c0-1.048.83-1.867 1.866-2.013A24.204 24.204 0 0 1 12 12.75Zm0 0V9.157" /></svg>
                    <p class="text-lg font-semibold text-gray-900">Aman &amp; Resmi</p>
                    <p class="text-gray-600 text-base mt-1">Data terenkripsi dan tercatat.</p>
                </div>
                <div class="bg-white border-2 border-gray-200 rounded-2xl p-6">
                    <svg class="w-10 h-10 text-brand-600 mb-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z" /></svg>
                    <p class="text-lg font-semibold text-gray-900">PDF Resmi</p>
                    <p class="text-gray-600 text-base mt-1">Lengkap dengan QR verifikasi.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Layanan -->
    <section class="bg-gray-50 border-y border-gray-200">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 py-16">
            <h2 class="text-3xl font-bold text-gray-900 text-center">Layanan yang Tersedia</h2>
            <p class="text-lg text-gray-600 text-center mt-3">Pilih layanan sesuai kebutuhan Anda</p>

            <div class="mt-10 grid sm:grid-cols-3 gap-6">
                <x-card class="p-7">
                    <div class="w-14 h-14 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center mb-4">
                        <svg class="w-8 h-8" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M18 18.72a9.094 9.094 0 0 0 3.741-.479 3 3 0 0 0-4.682-2.72m.94 3.198.001.031c0 .225-.012.447-.037.666A11.944 11.944 0 0 1 12 21c-2.17 0-4.207-.576-5.963-1.584A6.062 6.062 0 0 1 6 18.719m12 0a5.971 5.971 0 0 0-.941-3.197m0 0A5.995 5.995 0 0 0 12 12.75a5.995 5.995 0 0 0-5.058 2.772m0 0a3 3 0 0 0-4.681 2.72 8.986 8.986 0 0 0 3.74.477m.94-3.197a5.971 5.971 0 0 0-.94 3.197M15 6.75a3 3 0 1 1-6 0 3 3 0 0 1 6 0Zm6 3a2.25 2.25 0 1 1-4.5 0 2.25 2.25 0 0 1 4.5 0Zm-13.5 0a2.25 2.25 0 1 1-4.5 0 2.25 2.25 0 0 1 4.5 0Z" /></svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900">Kartu Keluarga</h3>
                    <p class="text-gray-600 mt-2 text-base leading-relaxed">Pembuatan baru atau perubahan data anggota keluarga.</p>
                </x-card>
                <x-card class="p-7">
                    <div class="w-14 h-14 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center mb-4">
                        <svg class="w-8 h-8" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M9.75 9.75c0-1.03.84-1.875 1.875-1.875h.75c1.036 0 1.875.845 1.875 1.875v.75a1.875 1.875 0 0 1-1.875 1.875h-.375a1.875 1.875 0 0 0-1.875 1.875v.375m1.875 5.25a9 9 0 1 0 0-18 9 9 0 0 0 0 18Zm.75-15h.008v.008h-.008V9.75Z" /></svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900">Akta Kelahiran</h3>
                    <p class="text-gray-600 mt-2 text-base leading-relaxed">Penerbitan akta kelahiran untuk anak yang baru lahir.</p>
                </x-card>
                <x-card class="p-7">
                    <div class="w-14 h-14 rounded-xl bg-gray-100 text-gray-600 flex items-center justify-center mb-4">
                        <svg class="w-8 h-8" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M11.35 3.836c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4c.414 0 .75-.336.75-.75 0-.231-.035-.454-.1-.664M11.35 3.836c.223-.722.898-1.246 1.65-1.246h4c.752 0 1.427.524 1.65 1.246m-7.3 0C9.311 4.512 8.75 5.427 8.75 6.354V19.5A2.25 2.25 0 0 0 11 21.75h2A2.25 2.25 0 0 0 15.25 19.5V6.354c0-.927-.561-1.842-1.4-2.518" /></svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900">Akta Kematian</h3>
                    <p class="text-gray-600 mt-2 text-base leading-relaxed">Pencatatan dan penerbitan akta kematian.</p>
                </x-card>
            </div>
        </div>
    </section>

    <!-- Cara Kerja -->
    <section class="bg-white">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 py-16">
            <h2 class="text-3xl font-bold text-gray-900 text-center">Caranya Mudah</h2>
            <div class="mt-10 grid sm:grid-cols-3 gap-8">
                @foreach([
                    ['no' => '1', 'title' => 'Daftar Akun', 'desc' => 'Isi nama, NIK, dan data diri Anda.'],
                    ['no' => '2', 'title' => 'Unggah Berkas', 'desc' => 'Pilih layanan lalu unggah dokumen yang diminta.'],
                    ['no' => '3', 'title' => 'Pantau &amp; Unduh', 'desc' => 'Lihat status dan unduh dokumen PDF setelah selesai.'],
                ] as $step)
                    <div class="text-center">
                        <div class="w-16 h-16 rounded-full bg-brand-600 text-white text-2xl font-bold flex items-center justify-center mx-auto">
                            {{ $step['no'] }}
                        </div>
                        <h3 class="mt-4 text-xl font-bold text-gray-900">{{ $step['title'] }}</h3>
                        <p class="mt-2 text-base text-gray-600">{!! $step['desc'] !!}</p>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- CTA -->
    <section class="bg-brand-700">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 py-14 text-center">
            <h2 class="text-3xl font-bold text-white">Siap Mengurus Dokumen Anda?</h2>
            <p class="mt-3 text-lg text-brand-100">Daftar sekarang, hanya butuh beberapa menit.</p>
            <div class="mt-7">
                <x-link-button :href="route('register')" variant="secondary" size="lg">Daftar Akun Gratis</x-link-button>
            </div>
        </div>
    </section>
</x-layouts.guest>
