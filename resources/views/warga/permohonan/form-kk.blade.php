<x-layouts.app title="Permohonan Kartu Keluarga">
    <a href="{{ route('warga.permohonan.pilih') }}" class="inline-flex items-center gap-2 text-base font-semibold text-gray-600 hover:text-brand-700 mb-4">
        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5 3 12m0 0 7.5-7.5M3 12h18" /></svg>
        Kembali Pilih Layanan
    </a>

    <div class="mb-8">
        <h1 class="text-3xl font-extrabold text-gray-900">Permohonan Kartu Keluarga</h1>
        <p class="mt-2 text-lg text-gray-600">Lengkapi data dan unggah berkas yang diperlukan.</p>
    </div>

    <form method="POST" action="{{ route('warga.permohonan.store', 'kk') }}" enctype="multipart/form-data" class="space-y-8" x-data="{ anggota: [{ nama: '', nik: '', hubungan: '' }] }">
        @csrf

        <x-card class="p-6 sm:p-8 space-y-6">
            <h2 class="text-xl font-bold text-gray-900">1. Alasan Perubahan</h2>
            <div>
                <x-label for="alasan" required>Jenis Pengajuan</x-label>
                <select id="alasan" name="alasan" required class="block w-full rounded-xl border-2 border-gray-300 px-4 py-3.5 text-lg text-gray-900 focus:outline-none focus:ring-3 focus:ring-brand-500/40 focus:border-brand-500">
                    <option value="">-- Pilih Alasan --</option>
                    <option value="baru">Pembuatan KK Baru</option>
                    <option value="pindah">Perubahan karena Pindah Domisili</option>
                    <option value="nikah">Perubahan karena Pernikahan</option>
                    <option value="lahir">Perubahan karena Penambahan Anggota (Lahir)</option>
                </select>
            </div>
        </x-card>

        <x-card class="p-6 sm:p-8 space-y-6">
            <h2 class="text-xl font-bold text-gray-900">2. Data Kepala Keluarga</h2>
            <div class="grid sm:grid-cols-2 gap-6">
                <div>
                    <x-label for="kepala_nama" required>Nama Kepala Keluarga</x-label>
                    <x-input type="text" id="kepala_nama" name="kepala_nama" required />
                </div>
                <div>
                    <x-label for="kepala_nik" required>NIK Kepala Keluarga</x-label>
                    <x-input type="text" inputmode="numeric" maxlength="16" id="kepala_nik" name="kepala_nik" required />
                </div>
            </div>
        </x-card>

        <x-card class="p-6 sm:p-8 space-y-6">
            <div class="flex items-center justify-between">
                <h2 class="text-xl font-bold text-gray-900">3. Data Anggota Keluarga</h2>
                <button type="button" x-on:click="anggota.push({ nama: '', nik: '', hubungan: '' })"
                    class="inline-flex items-center gap-1.5 text-base font-semibold text-brand-700 hover:underline">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" /></svg>
                    Tambah Anggota
                </button>
            </div>

            <template x-for="(item, index) in anggota" :key="index">
                <div class="border border-gray-200 rounded-xl p-5 grid sm:grid-cols-[1fr_1fr_1fr_auto] gap-4 items-end">
                    <div>
                        <label class="block text-base font-semibold text-gray-800 mb-2">Nama Anggota</label>
                        <input type="text" :name="`anggota[${index}][nama]`" x-model="item.nama"
                            class="block w-full rounded-xl border-2 border-gray-300 px-4 py-3 text-lg focus:outline-none focus:ring-3 focus:ring-brand-500/40 focus:border-brand-500">
                    </div>
                    <div>
                        <label class="block text-base font-semibold text-gray-800 mb-2">NIK</label>
                        <input type="text" inputmode="numeric" maxlength="16" :name="`anggota[${index}][nik]`" x-model="item.nik"
                            class="block w-full rounded-xl border-2 border-gray-300 px-4 py-3 text-lg focus:outline-none focus:ring-3 focus:ring-brand-500/40 focus:border-brand-500">
                    </div>
                    <div>
                        <label class="block text-base font-semibold text-gray-800 mb-2">Hubungan Keluarga</label>
                        <input type="text" placeholder="Contoh: Anak" :name="`anggota[${index}][hubungan]`" x-model="item.hubungan"
                            class="block w-full rounded-xl border-2 border-gray-300 px-4 py-3 text-lg focus:outline-none focus:ring-3 focus:ring-brand-500/40 focus:border-brand-500">
                    </div>
                    <button type="button" x-on:click="anggota.splice(index, 1)" x-show="anggota.length > 1"
                        class="h-[50px] w-[50px] flex items-center justify-center rounded-xl border-2 border-red-200 text-red-600 hover:bg-red-50">
                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" /></svg>
                    </button>
                </div>
            </template>
        </x-card>

        <x-card class="p-6 sm:p-8 space-y-6">
            <h2 class="text-xl font-bold text-gray-900">4. Unggah Berkas Persyaratan</h2>
            <div class="grid sm:grid-cols-2 gap-6">
                <x-file-upload name="berkas_kk_asli" label="Scan/Foto KK Asli" :required="true" />
                <x-file-upload name="berkas_buku_nikah" label="Fotokopi Buku Nikah" :required="true" />
                <x-file-upload name="berkas_ktp_pelapor" label="Scan KTP Pelapor & Saksi" :required="true" />
                <x-file-upload name="berkas_ket_lahir" label="Surat Keterangan Lahir (jika ada tambahan anggota)" :required="false" />
            </div>
        </x-card>

        <div class="flex flex-col sm:flex-row gap-4 justify-end">
            <x-link-button :href="route('warga.permohonan.pilih')" variant="secondary" size="lg">Batal</x-link-button>
            <x-button type="submit" size="lg">Kirim Permohonan</x-button>
        </div>
    </form>
</x-layouts.app>
