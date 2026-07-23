@php
$actionLabels = [
    'reset_password' => 'Reset Password',
    'unlock_account' => 'Buka Kunci Akun',
    'update_submission_status' => 'Ubah Status Pengajuan',
];
@endphp
<x-layouts.admin title="Audit Log" :namaAdmin="auth('admin')->user()->name" :roleAdmin="auth('admin')->user()->role">
    <div class="mb-8">
        <h1 class="text-3xl font-extrabold text-gray-900">Audit Log</h1>
        <p class="mt-2 text-lg text-gray-600">Catatan seluruh aksi sensitif dalam sistem (append-only).</p>
    </div>

    <x-card class="overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left min-w-[800px]">
                <thead>
                    <tr class="text-sm text-gray-500 bg-gray-50 border-b border-gray-200">
                        <th class="px-5 py-4 font-semibold">Aktor</th>
                        <th class="px-5 py-4 font-semibold">Aksi</th>
                        <th class="px-5 py-4 font-semibold">Target</th>
                        <th class="px-5 py-4 font-semibold">Waktu</th>
                        <th class="px-5 py-4 font-semibold">IP Address</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($logs as $log)
                        <tr class="text-base hover:bg-gray-50">
                            <td class="px-5 py-4 font-semibold text-gray-900">{{ $log->actor_name }}</td>
                            <td class="px-5 py-4 text-gray-700">{{ $actionLabels[$log->action] ?? $log->action }}</td>
                            <td class="px-5 py-4 text-gray-600">{{ $log->target_label }}</td>
                            <td class="px-5 py-4 text-gray-500">{{ $log->created_at->translatedFormat('d M Y, H.i') }} WIB</td>
                            <td class="px-5 py-4 text-gray-500 font-mono">{{ $log->ip_address }}</td>
                        </tr>
                    @empty
                        <tr><td colspan="5" class="px-5 py-10 text-center text-gray-500 text-lg">Belum ada aktivitas tercatat.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </x-card>

    <div class="mt-6">
        {{ $logs->links() }}
    </div>
</x-layouts.admin>
