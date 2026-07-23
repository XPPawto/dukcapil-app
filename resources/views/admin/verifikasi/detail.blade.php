@php
use Illuminate\Support\Facades\URL;

$fieldLabels = [
    'alasan' => 'Alasan Perubahan', 'kepala_nama' => 'Nama Kepala Keluarga', 'kepala_nik' => 'NIK Kepala Keluarga',
    'nama_anak' => 'Nama Anak', 'tempat_lahir' => 'Tempat Lahir', 'tanggal_lahir_anak' => 'Tanggal Lahir',
    'jenis_kelamin' => 'Jenis Kelamin', 'nama_ayah' => 'Nama Ayah', 'nama_ibu' => 'Nama Ibu',
    'nik_ayah' => 'NIK Ayah', 'nik_ibu' => 'NIK Ibu', 'nama_jenazah' => 'Nama Jenazah', 'nik_jenazah' => 'NIK Jenazah',
    'tanggal_meninggal' => 'Tanggal Meninggal', 'jam_meninggal' => 'Jam Meninggal',
    'lokasi_meninggal' => 'Lokasi Meninggal', 'penyebab' => 'Penyebab Kematian',
];
@endphp
<x-layouts.admin title="Detail Pengajuan" :namaAdmin="auth('admin')->user()->name" :roleAdmin="auth('admin')->user()->role">
    <div x-data="{ previewUrl: null, previewMime: null, previewName: null }">
        <a href="{{ route('admin.verifikasi.index') }}" class="inline-flex items-center gap-2 text-base font-semibold text-gray-600 hover:text-brand-700 mb-4">
            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5 3 12m0 0 7.5-7.5M3 12h18" /></svg>
            Kembali ke Daftar Verifikasi
        </a>

        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-8">
            <div>
                <h1 class="text-3xl font-extrabold text-gray-900">{{ $submission->serviceLabel() }}</h1>
                <p class="mt-1 text-lg text-gray-500">No. Tiket: <span class="font-mono font-semibold">{{ $submission->ticket_number }}</span></p>
            </div>
            <x-status-badge :status="$submission->status" class="text-base px-4 py-2" />
        </div>

        <div class="grid lg:grid-cols-3 gap-6">
            <div class="lg:col-span-2 space-y-6">
                <x-card class="p-6 sm:p-8">
                    <h2 class="text-xl font-bold text-gray-900 mb-5">Data Pemohon</h2>
                    <dl class="grid sm:grid-cols-2 gap-5 text-base">
                        <div>
                            <dt class="text-gray-500">Nama Pemohon</dt>
                            <dd class="font-semibold text-gray-900 mt-0.5">{{ $submission->citizen->full_name }}</dd>
                        </div>
                        <div>
                            <dt class="text-gray-500">NIK</dt>
                            <dd class="font-semibold text-gray-900 mt-0.5">{{ $submission->citizen->maskedNik() }}</dd>
                        </div>
                        <div>
                            <dt class="text-gray-500">Jenis Layanan</dt>
                            <dd class="font-semibold text-gray-900 mt-0.5">{{ $submission->serviceLabel() }}</dd>
                        </div>
                        <div>
                            <dt class="text-gray-500">Waktu Pengajuan</dt>
                            <dd class="font-semibold text-gray-900 mt-0.5">{{ $submission->created_at->translatedFormat('d F Y, H.i') }}</dd>
                        </div>
                    </dl>
                </x-card>

                <x-card class="p-6 sm:p-8">
                    <h2 class="text-xl font-bold text-gray-900 mb-5">Isian Formulir</h2>
                    <dl class="grid sm:grid-cols-2 gap-5 text-base">
                        @foreach($submission->form_data as $key => $value)
                            @continue($key === 'anggota' || is_array($value) || $value === null || $value === '')
                            <div>
                                <dt class="text-gray-500">{{ $fieldLabels[$key] ?? $key }}</dt>
                                <dd class="font-semibold text-gray-900 mt-0.5">{{ $value }}</dd>
                            </div>
                        @endforeach
                    </dl>

                    @if(!empty($submission->form_data['anggota']))
                        <div class="mt-6 pt-6 border-t border-gray-100">
                            <p class="text-base font-semibold text-gray-800 mb-3">Anggota Keluarga</p>
                            <div class="space-y-2">
                                @foreach($submission->form_data['anggota'] as $anggota)
                                    @continue(empty($anggota['nama']))
                                    <p class="text-base text-gray-700">{{ $anggota['nama'] }} &middot; {{ $anggota['nik'] }} &middot; {{ $anggota['hubungan'] }}</p>
                                @endforeach
                            </div>
                        </div>
                    @endif
                </x-card>

                <x-card class="p-6 sm:p-8">
                    <h2 class="text-xl font-bold text-gray-900 mb-5">Berkas Terlampir</h2>
                    <div class="grid sm:grid-cols-2 gap-4">
                        @forelse($submission->files->where('file_type', 'upload') as $file)
                            @php $url = URL::temporarySignedRoute('files.show', now()->addMinutes(15), ['file' => $file->id]); @endphp
                            <button type="button"
                                x-on:click="previewUrl = '{{ $url }}'; previewMime = '{{ $file->mime_type }}'; previewName = '{{ addslashes($file->original_name) }}'; window.dispatchEvent(new CustomEvent('open-modal', { detail: 'preview-file' }))"
                                class="flex items-center gap-3 border-2 border-gray-200 rounded-xl p-4 hover:border-brand-400 hover:bg-brand-50 transition text-left">
                                <div class="w-11 h-11 rounded-lg bg-red-50 text-red-500 flex items-center justify-center shrink-0">
                                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z" /></svg>
                                </div>
                                <div class="min-w-0">
                                    <p class="font-semibold text-gray-900 truncate">{{ $file->original_name }}</p>
                                    <p class="text-sm text-gray-500">Ketuk untuk pratinjau</p>
                                </div>
                            </button>
                        @empty
                            <p class="text-base text-gray-500 sm:col-span-2">Belum ada berkas yang diunggah.</p>
                        @endforelse
                    </div>
                </x-card>
            </div>

            <div class="lg:col-span-1">
                <x-card class="p-6 sm:p-8 lg:sticky lg:top-24" x-data="{ aksi: '{{ $submission->status === 'SUBMITTED' ? '' : 'IN_REVIEW' }}' }">
                    <h2 class="text-xl font-bold text-gray-900 mb-5">Tindakan Verifikasi</h2>

                    @if($submission->status === 'APPROVED')
                        <x-alert type="success">Pengajuan ini sudah disetujui dan diterbitkan. Tidak ada aksi lebih lanjut.</x-alert>
                    @else
                        <form method="POST" action="{{ route('admin.verifikasi.update-status', $submission->ticket_number) }}" enctype="multipart/form-data" class="space-y-5">
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
                <h3 class="text-xl font-bold text-gray-900 truncate" x-text="previewName"></h3>
                <button type="button" onclick="window.dispatchEvent(new CustomEvent('close-modal'))" class="text-gray-400 hover:text-gray-600 shrink-0 ml-4">
                    <svg class="w-7 h-7" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" /></svg>
                </button>
            </div>
            <div class="bg-gray-50 h-[70vh]">
                <template x-if="previewMime && previewMime.startsWith('image/')">
                    <img :src="previewUrl" class="w-full h-full object-contain">
                </template>
                <template x-if="previewMime === 'application/pdf'">
                    <iframe :src="previewUrl" class="w-full h-full border-0"></iframe>
                </template>
            </div>
        </x-modal>
    </div>
</x-layouts.admin>
