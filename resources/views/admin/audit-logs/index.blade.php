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
                    @foreach($logs as $log)
                        <tr class="text-base hover:bg-gray-50">
                            <td class="px-5 py-4 font-semibold text-gray-900">{{ $log['aktor'] }}</td>
                            <td class="px-5 py-4 text-gray-700">{{ $log['aksi'] }}</td>
                            <td class="px-5 py-4 text-gray-600">{{ $log['target'] }}</td>
                            <td class="px-5 py-4 text-gray-500">{{ $log['waktu'] }}</td>
                            <td class="px-5 py-4 text-gray-500 font-mono">{{ $log['ip'] }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </x-card>
</x-layouts.admin>
