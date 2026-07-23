<x-layouts.admin title="Verifikasi Pengajuan" :namaAdmin="auth('admin')->user()->name" :roleAdmin="auth('admin')->user()->role">
    <div class="mb-8">
        <h1 class="text-3xl font-extrabold text-gray-900">Verifikasi Pengajuan</h1>
        <p class="mt-2 text-lg text-gray-600">Periksa dan proses permohonan warga.</p>
    </div>

    <form method="GET" class="mb-6 flex flex-col sm:flex-row gap-4">
        <div class="flex-1 relative">
            <svg class="w-6 h-6 text-gray-400 absolute left-4 top-1/2 -translate-y-1/2" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" /></svg>
            <input type="text" name="cari" value="{{ $search }}" placeholder="Cari No. Tiket atau NIK..."
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

    <x-card class="overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left min-w-[900px]">
                <thead>
                    <tr class="text-sm text-gray-500 bg-gray-50 border-b border-gray-200">
                        <th class="px-5 py-4 font-semibold">No. Tiket</th>
                        <th class="px-5 py-4 font-semibold">Nama Pemohon</th>
                        <th class="px-5 py-4 font-semibold">NIK</th>
                        <th class="px-5 py-4 font-semibold">Jenis Layanan</th>
                        <th class="px-5 py-4 font-semibold">Waktu Pengajuan</th>
                        <th class="px-5 py-4 font-semibold">Status</th>
                        <th class="px-5 py-4 font-semibold">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($submissions as $item)
                        <tr class="text-base hover:bg-gray-50">
                            <td class="px-5 py-4 font-mono text-gray-700">{{ $item->ticket_number }}</td>
                            <td class="px-5 py-4 font-semibold text-gray-900">{{ $item->citizen->full_name }}</td>
                            <td class="px-5 py-4 text-gray-600 font-mono">{{ $item->citizen->maskedNik() }}</td>
                            <td class="px-5 py-4 text-gray-600">{{ $item->serviceLabel() }}</td>
                            <td class="px-5 py-4 text-gray-500">{{ $item->created_at->translatedFormat('d M Y, H.i') }}</td>
                            <td class="px-5 py-4"><x-status-badge :status="$item->status" /></td>
                            <td class="px-5 py-4">
                                <x-link-button :href="route('admin.verifikasi.show', $item->ticket_number)" variant="secondary" size="md">Proses</x-link-button>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="7" class="px-5 py-10 text-center text-gray-500 text-lg">Tidak ada data ditemukan.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </x-card>
</x-layouts.admin>
