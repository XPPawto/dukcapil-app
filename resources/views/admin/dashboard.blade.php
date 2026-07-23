<x-layouts.admin title="Dashboard Admin" :namaAdmin="auth('admin')->user()->name" :roleAdmin="auth('admin')->user()->role">
    <div class="mb-8">
        <h1 class="text-3xl font-extrabold text-gray-900">Dashboard</h1>
        <p class="mt-2 text-lg text-gray-600">Ringkasan pengajuan layanan kependudukan.</p>
    </div>

    <div class="grid grid-cols-2 lg:grid-cols-5 gap-4 mb-10">
        <x-stat-card label="Total" :value="$kpi['total']" color="gray">
            <svg class="w-7 h-7" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h5.586a1 1 0 0 1 .707.293l5.414 5.414a1 1 0 0 1 .293.707V19a2 2 0 0 1-2 2Z" /></svg>
        </x-stat-card>
        <x-stat-card label="Menunggu" :value="$kpi['pending']" color="brand">
            <svg class="w-7 h-7" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6l4 2m6-2a10 10 0 1 1-20 0 10 10 0 0 1 20 0Z" /></svg>
        </x-stat-card>
        <x-stat-card label="Diproses" :value="$kpi['diproses']" color="amber">
            <svg class="w-7 h-7" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="m11.42 15.17 2.496-3.03c.317-.384.74-.626 1.208-.766M11.42 15.17 4.36 8.876c-.317-.384-.74-.626-1.208-.766m8.268 7.06 3.938 4.784c.44.534 1.163.789 1.858.618l4.9-1.204c.66-.162 1.02-.868.76-1.492l-2.176-5.238a1.5 1.5 0 0 0-1.383-.914h-4.66a1.5 1.5 0 0 0-1.383.914" /></svg>
        </x-stat-card>
        <x-stat-card label="Disetujui" :value="$kpi['disetujui']" color="emerald">
            <svg class="w-7 h-7" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" /></svg>
        </x-stat-card>
        <x-stat-card label="Ditolak" :value="$kpi['ditolak']" color="red">
            <svg class="w-7 h-7" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126ZM12 15.75h.007v.008H12v-.008Z" /></svg>
        </x-stat-card>
    </div>

    <x-card class="p-6 sm:p-8">
        <div class="flex items-center justify-between mb-5">
            <h2 class="text-xl font-bold text-gray-900">Pengajuan Terbaru</h2>
            <a href="{{ route('admin.verifikasi.index') }}" class="text-base font-semibold text-brand-700 hover:underline">Lihat Semua &rarr;</a>
        </div>
        <div class="overflow-x-auto -mx-2">
            <table class="w-full text-left">
                <thead>
                    <tr class="text-sm text-gray-500 border-b border-gray-200">
                        <th class="px-2 py-3 font-semibold">No. Tiket</th>
                        <th class="px-2 py-3 font-semibold">Pemohon</th>
                        <th class="px-2 py-3 font-semibold">Layanan</th>
                        <th class="px-2 py-3 font-semibold">Waktu</th>
                        <th class="px-2 py-3 font-semibold">Status</th>
                        <th class="px-2 py-3 font-semibold"></th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @foreach($terbaru as $item)
                        <tr class="text-base">
                            <td class="px-2 py-4 font-mono text-gray-700">{{ $item['ticket_number'] }}</td>
                            <td class="px-2 py-4 font-semibold text-gray-900">{{ $item['nama_pemohon'] }}</td>
                            <td class="px-2 py-4 text-gray-600">{{ $item['service_type'] }}</td>
                            <td class="px-2 py-4 text-gray-500">{{ $item['created_at'] }}</td>
                            <td class="px-2 py-4"><x-status-badge :status="$item['status']" /></td>
                            <td class="px-2 py-4">
                                <a href="{{ route('admin.verifikasi.show', $item['ticket_number']) }}" class="font-semibold text-brand-700 hover:underline">Proses</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </x-card>
</x-layouts.admin>
