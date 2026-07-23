@php use App\Support\DemoData; @endphp
<x-layouts.admin title="Detail Pengajuan" :namaAdmin="auth('admin')->user()->name" :roleAdmin="auth('admin')->user()->role">
    <a href="{{ route('admin.verifikasi.index') }}" class="inline-flex items-center gap-2 text-base font-semibold text-gray-600 hover:text-brand-700 mb-4">
        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5 3 12m0 0 7.5-7.5M3 12h18" /></svg>
        Kembali ke Daftar Verifikasi
    </a>

    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-8">
        <div>
            <h1 class="text-3xl font-extrabold text-gray-900">{{ $submission['service_type'] }}</h1>
            <p class="mt-1 text-lg text-gray-500">No. Tiket: <span class="font-mono font-semibold">{{ $submission['ticket_number'] }}</span></p>
        </div>
        <x-status-badge :status="$submission['status']" class="text-base px-4 py-2" />
    </div>

    <div class="grid lg:grid-cols-3 gap-6">
        <div class="lg:col-span-2 space-y-6">
            <x-card class="p-6 sm:p-8">
                <h2 class="text-xl font-bold text-gray-900 mb-5">Data Pemohon</h2>
                <dl class="grid sm:grid-cols-2 gap-5 text-base">
                    <div>
                        <dt class="text-gray-500">Nama Pemohon</dt>
                        <dd class="font-semibold text-gray-900 mt-0.5">{{ $submission['nama_pemohon'] }}</dd>
                    </div>
                    <div>
                        <dt class="text-gray-500">NIK</dt>
                        <dd class="font-semibold text-gray-900 mt-0.5">{{ $submission['nik'] }}</dd>
                    </div>
                    <div>
                        <dt class="text-gray-500">Jenis Layanan</dt>
                        <dd class="font-semibold text-gray-900 mt-0.5">{{ $submission['service_type'] }}</dd>
                    </div>
                    <div>
                        <dt class="text-gray-500">Waktu Pengajuan</dt>
                        <dd class="font-semibold text-gray-900 mt-0.5">{{ $submission['created_at'] }}</dd>
                    </div>
                </dl>
            </x-card>

            <x-card class="p-6 sm:p-8">
                <h2 class="text-xl font-bold text-gray-900 mb-5">Berkas Terlampir</h2>
                <div class="grid sm:grid-cols-2 gap-4">
                    @foreach(['KK Asli', 'Buku Nikah', 'KTP Pelapor'] as $file)
                        <button type="button" onclick="window.dispatchEvent(new CustomEvent('open-modal', { detail: 'preview-file' }))"
                            class="flex items-center gap-3 border-2 border-gray-200 rounded-xl p-4 hover:border-brand-400 hover:bg-brand-50 transition text-left">
                            <div class="w-11 h-11 rounded-lg bg-red-50 text-red-500 flex items-center justify-center shrink-0">
                                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z" /></svg>
                            </div>
                            <div class="min-w-0">
                                <p class="font-semibold text-gray-900 truncate">{{ $file }}.pdf</p>
                                <p class="text-sm text-gray-500">Ketuk untuk pratinjau</p>
                            </div>
                        </button>
                    @endforeach
                </div>
            </x-card>
        </div>

        <div class="lg:col-span-1">
            <x-card class="p-6 sm:p-8 lg:sticky lg:top-24" x-data="{ aksi: '{{ $submission['status'] === 'SUBMITTED' ? '' : 'IN_REVIEW' }}' }">
                <h2 class="text-xl font-bold text-gray-900 mb-5">Tindakan Verifikasi</h2>

                @if($submission['status'] === 'APPROVED')
                    <x-alert type="success">Pengajuan ini sudah disetujui dan diterbitkan. Tidak ada aksi lebih lanjut.</x-alert>
                @else
                    <form method="POST" action="{{ route('admin.verifikasi.update-status', $submission['ticket_number']) }}" enctype="multipart/form-data" class="space-y-5">
                        @csrf
                        @method('PUT')

                        <div class="grid grid-cols-3 gap-2">
                            <label class="cursor-pointer">
                                <input type="radio" name="status" value="IN_REVIEW" x-model="aksi" class="sr-only peer">
                                <span class="block text-center py-3 rounded-xl border-2 border-gray-300 text-sm font-semibold text-gray-700 peer-checked:bg-amber-500 peer-checked:border-amber-500 peer-checked:text-white transition">Diproses</span>
                            </label>
                            <label class="cursor-pointer">
                                <input type="radio" name="status" value="APPROVED" x-model="aksi" class="sr-only peer">
                                <span class="block text-center py-3 rounded-xl border-2 border-gray-300 text-sm font-semibold text-gray-700 peer-checked:bg-emerald-500 peer-checked:border-emerald-500 peer-checked:text-white transition">Disetujui</span>
                            </label>
                            <label class="cursor-pointer">
                                <input type="radio" name="status" value="REJECTED" x-model="aksi" class="sr-only peer">
                                <span class="block text-center py-3 rounded-xl border-2 border-gray-300 text-sm font-semibold text-gray-700 peer-checked:bg-red-500 peer-checked:border-red-500 peer-checked:text-white transition">Ditolak</span>
                            </label>
                        </div>

                        <div x-show="aksi === 'REJECTED'" x-cloak>
                            <x-label for="catatan" required>Alasan Penolakan</x-label>
                            <textarea id="catatan" name="catatan" rows="4" placeholder="Jelaskan berkas atau data yang perlu diperbaiki..."
                                class="block w-full rounded-xl border-2 border-gray-300 px-4 py-3 text-lg focus:outline-none focus:ring-3 focus:ring-brand-500/40 focus:border-brand-500"></textarea>
                            <x-input-error :message="$errors->first('catatan')" />
                        </div>

                        <div x-show="aksi === 'APPROVED'" x-cloak>
                            <x-file-upload name="hasil_pdf" label="Unggah File PDF Hasil" hint="Format PDF, maksimal 5 MB." :required="false" />
                        </div>

                        <x-button type="submit" variant="primary" class="w-full" x-bind:disabled="!aksi">Simpan Tindakan</x-button>
                    </form>
                @endif
            </x-card>
        </div>
    </div>

    <x-modal name="preview-file" max-width="2xl">
        <div class="p-6 border-b border-gray-100 flex items-center justify-between">
            <h3 class="text-xl font-bold text-gray-900">Pratinjau Berkas</h3>
            <button type="button" onclick="window.dispatchEvent(new CustomEvent('close-modal'))" class="text-gray-400 hover:text-gray-600">
                <svg class="w-7 h-7" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" /></svg>
            </button>
        </div>
        <div class="p-10 flex flex-col items-center justify-center text-center bg-gray-50">
            <svg class="w-16 h-16 text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z" /></svg>
            <p class="mt-4 text-gray-500 text-lg">Pratinjau berkas akan tampil di sini.</p>
        </div>
    </x-modal>
</x-layouts.admin>
