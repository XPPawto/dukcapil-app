@php
$steps = ['SUBMITTED', 'IN_REVIEW', 'APPROVED'];
$currentIndex = array_search($submission['status'], $steps);
$isRejectedOrExpired = in_array($submission['status'], ['REJECTED', 'EXPIRED']);
@endphp
<x-layouts.app title="Detail Permohonan" :namaWarga="session('warga_nama', 'Warga')">
    <a href="{{ route('warga.permohonan.riwayat') }}" class="inline-flex items-center gap-2 text-base font-semibold text-gray-600 hover:text-brand-700 mb-4">
        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5 3 12m0 0 7.5-7.5M3 12h18" /></svg>
        Kembali ke Riwayat
    </a>

    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-8">
        <div>
            <h1 class="text-3xl font-extrabold text-gray-900">{{ $submission['service_type'] }}</h1>
            <p class="mt-1 text-lg text-gray-500">No. Tiket: <span class="font-mono font-semibold">{{ $submission['ticket_number'] }}</span></p>
        </div>
        <x-status-badge :status="$submission['status']" class="text-base px-4 py-2" />
    </div>

    <x-card class="p-6 sm:p-8 mb-6">
        <h2 class="text-xl font-bold text-gray-900 mb-6">Status Pengajuan</h2>

        @if($isRejectedOrExpired)
            <x-alert :type="$submission['status'] === 'REJECTED' ? 'danger' : 'warning'">
                <p class="font-semibold">{{ $submission['status'] === 'REJECTED' ? 'Permohonan Ditolak' : 'Permohonan Kedaluwarsa' }}</p>
                @if($submission['catatan'])
                    <p class="mt-1">{{ $submission['catatan'] }}</p>
                @endif
            </x-alert>
        @else
            <ol class="space-y-0">
                @foreach([
                    ['key' => 'SUBMITTED', 'label' => 'Menunggu Verifikasi', 'desc' => 'Permohonan diterima sistem.'],
                    ['key' => 'IN_REVIEW', 'label' => 'Sedang Diproses', 'desc' => 'Petugas memeriksa kelengkapan berkas.'],
                    ['key' => 'APPROVED', 'label' => 'Selesai & Terbit', 'desc' => 'Dokumen siap diunduh.'],
                ] as $i => $step)
                    @php $done = $i <= $currentIndex; @endphp
                    <li class="flex gap-4">
                        <div class="flex flex-col items-center">
                            <div class="w-9 h-9 rounded-full flex items-center justify-center shrink-0 {{ $done ? 'bg-emerald-500 text-white' : 'bg-gray-200 text-gray-400' }}">
                                @if($done)
                                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3"><path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5" /></svg>
                                @else
                                    <span class="w-2.5 h-2.5 rounded-full bg-current"></span>
                                @endif
                            </div>
                            @if(!$loop->last)
                                <div class="w-0.5 flex-1 min-h-8 {{ $done && $i < $currentIndex ? 'bg-emerald-500' : 'bg-gray-200' }}"></div>
                            @endif
                        </div>
                        <div class="pb-8">
                            <p class="text-lg font-bold {{ $done ? 'text-gray-900' : 'text-gray-400' }}">{{ $step['label'] }}</p>
                            <p class="text-base {{ $done ? 'text-gray-600' : 'text-gray-400' }}">{{ $step['desc'] }}</p>
                        </div>
                    </li>
                @endforeach
            </ol>
        @endif
    </x-card>

    <x-card class="p-6 sm:p-8 mb-6">
        <h2 class="text-xl font-bold text-gray-900 mb-4">Ringkasan Data</h2>
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
                <dt class="text-gray-500">Tanggal Pengajuan</dt>
                <dd class="font-semibold text-gray-900 mt-0.5">{{ $submission['created_at'] }}</dd>
            </div>
        </dl>
    </x-card>

    @if($submission['status'] === 'APPROVED')
        <x-card class="p-6 sm:p-8 bg-emerald-50 border-emerald-200">
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                <div>
                    <p class="text-xl font-bold text-emerald-800">Dokumen Anda Siap!</p>
                    <p class="text-base text-emerald-700 mt-1">File PDF sudah dilengkapi QR Code verifikasi.</p>
                </div>
                <x-button variant="success" size="lg">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75V16.5M16.5 12 12 16.5m0 0L7.5 12m4.5 4.5V3" /></svg>
                    Unduh PDF
                </x-button>
            </div>
        </x-card>
    @elseif($submission['status'] === 'REJECTED')
        <div class="text-center">
            <x-link-button :href="route('warga.permohonan.pilih')" size="lg">Ajukan Ulang</x-link-button>
        </div>
    @endif
</x-layouts.app>
