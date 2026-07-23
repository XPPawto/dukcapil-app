<x-layouts.app title="Riwayat Permohonan">
    <div class="mb-8">
        <h1 class="text-3xl font-extrabold text-gray-900">Riwayat Permohonan</h1>
        <p class="mt-2 text-lg text-gray-600">Pantau status seluruh permohonan Anda di sini.</p>
    </div>

    <form method="GET" class="mb-6 flex flex-col sm:flex-row gap-4">
        <div class="flex-1 relative">
            <svg class="w-6 h-6 text-gray-400 absolute left-4 top-1/2 -translate-y-1/2" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" /></svg>
            <input type="text" name="cari" value="{{ $search }}" placeholder="Cari No. Tiket..."
                class="w-full rounded-xl border-2 border-gray-300 pl-12 pr-4 py-3.5 text-lg focus:outline-none focus:ring-3 focus:ring-brand-500/40 focus:border-brand-500">
        </div>
        <select name="status" onchange="this.form.submit()" class="rounded-xl border-2 border-gray-300 px-4 py-3.5 text-lg focus:outline-none focus:ring-3 focus:ring-brand-500/40 focus:border-brand-500">
            <option value="">Semua Status</option>
            <option value="SUBMITTED" @selected($statusFilter === 'SUBMITTED')>Menunggu Verifikasi</option>
            <option value="IN_REVIEW" @selected($statusFilter === 'IN_REVIEW')>Sedang Diproses</option>
            <option value="APPROVED" @selected($statusFilter === 'APPROVED')>Selesai & Terbit</option>
            <option value="REJECTED" @selected($statusFilter === 'REJECTED')>Ditolak / Perbaiki</option>
            <option value="EXPIRED" @selected($statusFilter === 'EXPIRED')>Kedaluwarsa</option>
        </select>
        <x-button type="submit" variant="secondary" size="lg">Cari</x-button>
    </form>

    <div class="space-y-4">
        @forelse($submissions as $item)
            <x-card class="p-5 sm:p-6">
                <div class="flex flex-col sm:flex-row sm:items-center gap-4">
                    <div class="flex-1 min-w-0">
                        <p class="text-lg font-bold text-gray-900">{{ $item->serviceLabel() }}</p>
                        <p class="text-base text-gray-500 mt-0.5">No. Tiket: <span class="font-mono">{{ $item->ticket_number }}</span></p>
                        <p class="text-base text-gray-500">Diajukan: {{ $item->created_at->translatedFormat('d M Y, H.i') }}</p>
                    </div>
                    <x-status-badge :status="$item->status" />
                    <x-link-button :href="route('warga.permohonan.detail', $item->ticket_number)" variant="secondary" size="md">Lihat Detail</x-link-button>
                </div>
                @if($item->status === 'REJECTED' && $item->note)
                    <div class="mt-4 pt-4 border-t border-gray-100 text-base text-red-700 bg-red-50 rounded-lg p-3">
                        <strong>Catatan Petugas:</strong> {{ $item->note }}
                    </div>
                @endif
            </x-card>
        @empty
            <x-card class="p-10 text-center">
                <p class="text-xl text-gray-500">Tidak ada permohonan ditemukan.</p>
                <x-link-button :href="route('warga.permohonan.pilih')" class="mt-5">Ajukan Permohonan Baru</x-link-button>
            </x-card>
        @endforelse
    </div>
</x-layouts.app>
