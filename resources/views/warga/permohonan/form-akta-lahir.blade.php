<x-layouts.app title="Permohonan Akta Kelahiran" :namaWarga="session('warga_nama', 'Warga')">
    <a href="{{ route('warga.permohonan.pilih') }}" class="inline-flex items-center gap-2 text-base font-semibold text-gray-600 hover:text-brand-700 mb-4">
        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5 3 12m0 0 7.5-7.5M3 12h18" /></svg>
        Kembali Pilih Layanan
    </a>

    <div class="mb-8">
        <h1 class="text-3xl font-extrabold text-gray-900">Permohonan Akta Kelahiran</h1>
        <p class="mt-2 text-lg text-gray-600">Lengkapi data anak dan orang tua, lalu unggah berkas.</p>
    </div>

    <form method="POST" action="{{ route('warga.permohonan.store', 'akta-lahir') }}" enctype="multipart/form-data" class="space-y-8">
        @csrf

        <x-card class="p-6 sm:p-8 space-y-6">
            <h2 class="text-xl font-bold text-gray-900">1. Data Anak</h2>
            <div class="grid sm:grid-cols-2 gap-6">
                <div class="sm:col-span-2">
                    <x-label for="nama_anak" required>Nama Lengkap Anak</x-label>
                    <x-input type="text" id="nama_anak" name="nama_anak" required />
                </div>
                <div>
                    <x-label for="tempat_lahir" required>Tempat Lahir</x-label>
                    <x-input type="text" id="tempat_lahir" name="tempat_lahir" required />
                </div>
                <div>
                    <x-label for="tanggal_lahir_anak" required>Tanggal Lahir</x-label>
                    <x-input type="date" id="tanggal_lahir_anak" name="tanggal_lahir_anak" required />
                </div>
                <div>
                    <x-label for="jenis_kelamin" required>Jenis Kelamin</x-label>
                    <select id="jenis_kelamin" name="jenis_kelamin" required class="block w-full rounded-xl border-2 border-gray-300 px-4 py-3.5 text-lg text-gray-900 focus:outline-none focus:ring-3 focus:ring-brand-500/40 focus:border-brand-500">
                        <option value="">-- Pilih --</option>
                        <option value="L">Laki-laki</option>
                        <option value="P">Perempuan</option>
                    </select>
                </div>
            </div>
        </x-card>

        <x-card class="p-6 sm:p-8 space-y-6">
            <h2 class="text-xl font-bold text-gray-900">2. Data Orang Tua</h2>
            <div class="grid sm:grid-cols-2 gap-6">
                <div>
                    <x-label for="nama_ayah" required>Nama Ayah</x-label>
                    <x-input type="text" id="nama_ayah" name="nama_ayah" required />
                </div>
                <div>
                    <x-label for="nama_ibu" required>Nama Ibu</x-label>
                    <x-input type="text" id="nama_ibu" name="nama_ibu" required />
                </div>
                <div>
                    <x-label for="nik_ayah" required>NIK Ayah</x-label>
                    <x-input type="text" inputmode="numeric" maxlength="16" id="nik_ayah" name="nik_ayah" required />
                </div>
                <div>
                    <x-label for="nik_ibu" required>NIK Ibu</x-label>
                    <x-input type="text" inputmode="numeric" maxlength="16" id="nik_ibu" name="nik_ibu" required />
                </div>
            </div>
        </x-card>

        <x-card class="p-6 sm:p-8 space-y-6">
            <h2 class="text-xl font-bold text-gray-900">3. Unggah Berkas Persyaratan</h2>
            <div class="grid sm:grid-cols-2 gap-6">
                <x-file-upload name="berkas_kk" label="Scan KK yang Mencantumkan Nama Anak" :required="true" />
                <x-file-upload name="berkas_ket_lahir" label="Scan Surat Keterangan Lahir dari Bidan/RS" :required="true" />
            </div>
        </x-card>

        <div class="flex flex-col sm:flex-row gap-4 justify-end">
            <x-link-button :href="route('warga.permohonan.pilih')" variant="secondary" size="lg">Batal</x-link-button>
            <x-button type="submit" size="lg">Kirim Permohonan</x-button>
        </div>
    </form>
</x-layouts.app>
