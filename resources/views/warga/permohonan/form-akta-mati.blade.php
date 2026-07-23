<x-layouts.app title="Permohonan Akta Kematian">
    <a href="{{ route('warga.permohonan.pilih') }}" class="inline-flex items-center gap-2 text-base font-semibold text-gray-600 hover:text-brand-700 mb-4">
        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5 3 12m0 0 7.5-7.5M3 12h18" /></svg>
        Kembali Pilih Layanan
    </a>

    <div class="mb-8">
        <h1 class="text-3xl font-extrabold text-gray-900">Permohonan Akta Kematian</h1>
        <p class="mt-2 text-lg text-gray-600">Lengkapi data jenazah dan unggah berkas yang diperlukan.</p>
    </div>

    <form method="POST" action="{{ route('warga.permohonan.store', 'akta-mati') }}" enctype="multipart/form-data" class="space-y-8">
        @csrf

        <x-card class="p-6 sm:p-8 space-y-6">
            <h2 class="text-xl font-bold text-gray-900">1. Data Jenazah</h2>
            <div class="grid sm:grid-cols-2 gap-6">
                <div class="sm:col-span-2">
                    <x-label for="nama_jenazah" required>Nama Lengkap</x-label>
                    <x-input type="text" id="nama_jenazah" name="nama_jenazah" required />
                </div>
                <div>
                    <x-label for="nik_jenazah" required>NIK</x-label>
                    <x-input type="text" inputmode="numeric" maxlength="16" id="nik_jenazah" name="nik_jenazah" required />
                </div>
                <div></div>
                <div>
                    <x-label for="tanggal_meninggal" required>Tanggal Meninggal</x-label>
                    <x-input type="date" id="tanggal_meninggal" name="tanggal_meninggal" required />
                </div>
                <div>
                    <x-label for="jam_meninggal" required>Jam Meninggal</x-label>
                    <x-input type="time" id="jam_meninggal" name="jam_meninggal" required />
                </div>
                <div class="sm:col-span-2">
                    <x-label for="lokasi_meninggal" required>Lokasi Meninggal</x-label>
                    <x-input type="text" id="lokasi_meninggal" name="lokasi_meninggal" placeholder="Contoh: RSUD Palembang / Rumah" required />
                </div>
                <div class="sm:col-span-2">
                    <x-label for="penyebab">Penyebab Kematian (opsional)</x-label>
                    <x-input type="text" id="penyebab" name="penyebab" />
                </div>
            </div>
        </x-card>

        <x-card class="p-6 sm:p-8 space-y-6">
            <h2 class="text-xl font-bold text-gray-900">2. Unggah Berkas Persyaratan</h2>
            <div class="grid sm:grid-cols-2 gap-6">
                <x-file-upload name="berkas_ket_kematian" label="Scan Surat Keterangan Kematian (RS/Kelurahan)" :required="true" />
                <x-file-upload name="berkas_kk_ktp" label="Scan KK & KTP Jenazah" :required="true" />
            </div>
        </x-card>

        <div class="flex flex-col sm:flex-row gap-4 justify-end">
            <x-link-button :href="route('warga.permohonan.pilih')" variant="secondary" size="lg">Batal</x-link-button>
            <x-button type="submit" size="lg">Kirim Permohonan</x-button>
        </div>
    </form>
</x-layouts.app>
