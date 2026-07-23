<x-layouts.app title="Beranda" :namaWarga="session('warga_nama', 'Warga')">
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-8">
        <div>
            <h1 class="text-3xl font-extrabold text-gray-900">Selamat Datang, {{ session('warga_nama', 'Warga') }}</h1>
            <p class="mt-2 text-lg text-gray-600">Berikut ringkasan permohonan Anda.</p>
        </div>
        <x-link-button :href="route('warga.permohonan.pilih')" size="lg">
            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" /></svg>
            Ajukan Permohonan Baru
        </x-link-button>
    </div>

    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-10">
        <x-stat-card label="Total Permohonan" :value="$summary['total']" color="brand">
            <svg class="w-7 h-7" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h5.586a1 1 0 0 1 .707.293l5.414 5.414a1 1 0 0 1 .293.707V19a2 2 0 0 1-2 2Z" /></svg>
        </x-stat-card>
        <x-stat-card label="Sedang Diproses" :value="$summary['diproses']" color="amber">
            <svg class="w-7 h-7" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6l4 2m6-2a10 10 0 1 1-20 0 10 10 0 0 1 20 0Z" /></svg>
        </x-stat-card>
        <x-stat-card label="Selesai & Terbit" :value="$summary['selesai']" color="emerald">
            <svg class="w-7 h-7" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" /></svg>
        </x-stat-card>
        <x-stat-card label="Ditolak" :value="$summary['ditolak']" color="red">
            <svg class="w-7 h-7" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126ZM12 15.75h.007v.008H12v-.008Z" /></svg>
        </x-stat-card>
    </div>

    <div class="flex items-center justify-between mb-4">
        <h2 class="text-2xl font-bold text-gray-900">Permohonan Terbaru</h2>
        <a href="{{ route('warga.permohonan.riwayat') }}" class="text-base font-semibold text-brand-700 hover:underline">Lihat Semua &rarr;</a>
    </div>

    <div class="space-y-4">
        @forelse($submissions as $item)
            <x-card class="p-5 flex flex-col sm:flex-row sm:items-center gap-4">
                <div class="flex-1 min-w-0">
                    <p class="text-lg font-bold text-gray-900">{{ $item['service_type'] }}</p>
                    <p class="text-base text-gray-500 mt-0.5">No. Tiket: {{ $item['ticket_number'] }} &middot; {{ $item['created_at'] }}</p>
                </div>
                <x-status-badge :status="$item['status']" />
                <a href="{{ route('warga.permohonan.detail', $item['ticket_number']) }}" class="text-base font-semibold text-brand-700 hover:underline whitespace-nowrap">Lihat Detail</a>
            </x-card>
        @empty
            <x-card class="p-8 text-center text-gray-500 text-lg">Belum ada permohonan.</x-card>
        @endforelse
    </div>
</x-layouts.app>
