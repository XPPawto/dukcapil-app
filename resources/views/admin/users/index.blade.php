<x-layouts.admin title="Manajemen User" :namaAdmin="auth('admin')->user()->name" :roleAdmin="auth('admin')->user()->role">
    <div
        x-data="{
            modalOpen: false,
            mode: 'reset',
            step: 1,
            target: { id: null, nama: '', nik: '', adminPassword: '' },
            baseUrl: '{{ url('admin/users') }}',
            openReset(id, nama, nik) {
                this.target = { id, nama, nik, adminPassword: '' };
                this.mode = 'reset';
                this.step = 1;
                this.modalOpen = true;
            },
            openUnlock(id, nama, nik) {
                this.target = { id, nama, nik, adminPassword: '' };
                this.mode = 'unlock';
                this.step = 1;
                this.modalOpen = true;
            },
        }"
    >
        <div class="mb-8">
            <h1 class="text-3xl font-extrabold text-gray-900">Manajemen User Warga</h1>
            <p class="mt-2 text-lg text-gray-600">Kelola akun warga dan bantu reset password di kantor.</p>
        </div>

        <form method="GET" class="mb-6 flex flex-col sm:flex-row gap-4">
            <div class="flex-1 relative">
                <svg class="w-6 h-6 text-gray-400 absolute left-4 top-1/2 -translate-y-1/2" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" /></svg>
                <input type="text" name="cari" value="{{ $search }}" placeholder="Cari Nama Lengkap atau NIK (16 digit)..."
                    class="w-full rounded-xl border-2 border-gray-300 pl-12 pr-4 py-3.5 text-lg focus:outline-none focus:ring-3 focus:ring-brand-500/40 focus:border-brand-500">
            </div>
            <select name="status" onchange="this.form.submit()" class="rounded-xl border-2 border-gray-300 px-4 py-3.5 text-lg focus:outline-none focus:ring-3 focus:ring-brand-500/40 focus:border-brand-500">
                <option value="">Semua Status</option>
                <option value="active" @selected($statusFilter === 'active')>Aktif</option>
                <option value="inactive" @selected($statusFilter === 'inactive')>Tidak Aktif</option>
                <option value="locked" @selected($statusFilter === 'locked')>Terkunci</option>
            </select>
            <x-button type="submit" variant="secondary" size="lg">Cari</x-button>
        </form>

        <x-card class="overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left min-w-[900px]">
                    <thead>
                        <tr class="text-sm text-gray-500 bg-gray-50 border-b border-gray-200">
                            <th class="px-5 py-4 font-semibold">No</th>
                            <th class="px-5 py-4 font-semibold">Nama Lengkap</th>
                            <th class="px-5 py-4 font-semibold">NIK</th>
                            <th class="px-5 py-4 font-semibold">Email</th>
                            <th class="px-5 py-4 font-semibold">Tgl. Registrasi</th>
                            <th class="px-5 py-4 font-semibold">Status</th>
                            <th class="px-5 py-4 font-semibold">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse($citizens as $i => $citizen)
                            <tr class="text-base hover:bg-gray-50">
                                <td class="px-5 py-4 text-gray-500">{{ $i + 1 }}</td>
                                <td class="px-5 py-4 font-semibold text-gray-900">{{ $citizen->full_name }}</td>
                                <td class="px-5 py-4 text-gray-600 font-mono">{{ $citizen->maskedNik() }}</td>
                                <td class="px-5 py-4 text-gray-600">{{ $citizen->email }}</td>
                                <td class="px-5 py-4 text-gray-500">{{ $citizen->created_at->translatedFormat('d M Y') }}</td>
                                <td class="px-5 py-4">
                                    @php
                                    $statusStyle = [
                                        'active' => 'bg-emerald-100 text-emerald-800',
                                        'inactive' => 'bg-gray-100 text-gray-600',
                                        'locked' => 'bg-red-100 text-red-800',
                                    ][$citizen->status];
                                    @endphp
                                    <span class="inline-flex px-3 py-1.5 rounded-full text-sm font-semibold {{ $statusStyle }}">{{ $statusLabels[$citizen->status] }}</span>
                                </td>
                                <td class="px-5 py-4">
                                    <div class="flex items-center gap-2">
                                        <button type="button"
                                            x-on:click="openReset({{ $citizen->id }}, '{{ addslashes($citizen->full_name) }}', '{{ $citizen->maskedNik() }}')"
                                            title="Ganti Password"
                                            class="w-11 h-11 flex items-center justify-center rounded-lg border-2 border-gray-300 text-gray-600 hover:bg-brand-50 hover:border-brand-400 hover:text-brand-700 transition">
                                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.75"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 5.25a3 3 0 0 1 3 3m3 0a6 6 0 0 1-7.029 5.912c-.563-.097-1.159.026-1.563.43L10.5 17.25H8.25v2.25H6v2.25H2.25v-2.818c0-.597.237-1.17.659-1.591l6.499-6.499c.404-.404.527-1 .43-1.563A6 6 0 1 1 21.75 8.25Z" /></svg>
                                        </button>
                                        @if($citizen->status === 'locked')
                                            <button type="button"
                                                x-on:click="openUnlock({{ $citizen->id }}, '{{ addslashes($citizen->full_name) }}', '{{ $citizen->maskedNik() }}')"
                                                title="Buka Kunci Akun"
                                                class="w-11 h-11 flex items-center justify-center rounded-lg border-2 border-gray-300 text-gray-600 hover:bg-amber-50 hover:border-amber-400 hover:text-amber-700 transition">
                                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.75"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 10.5V6.75a4.5 4.5 0 1 1 9 0v3.75M3.75 21.75h10.5a2.25 2.25 0 0 0 2.25-2.25v-6.75a2.25 2.25 0 0 0-2.25-2.25H3.75a2.25 2.25 0 0 0-2.25 2.25v6.75a2.25 2.25 0 0 0 2.25 2.25Z" /></svg>
                                            </button>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="7" class="px-5 py-10 text-center text-gray-500 text-lg">Tidak ada data ditemukan.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </x-card>

        <!-- Modal Reset Password / Buka Kunci — selalu didahului re-autentikasi admin -->
        <div x-show="modalOpen" x-cloak class="fixed inset-0 z-50 flex items-center justify-center p-4">
            <div x-show="modalOpen" x-transition.opacity x-on:click="modalOpen = false" class="fixed inset-0 bg-gray-900/60"></div>

            <div x-show="modalOpen" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
                class="relative w-full max-w-md bg-white rounded-2xl shadow-xl">

                <!-- Step 1: Re-autentikasi (dan aksi langsung untuk mode unlock) -->
                <template x-if="step === 1">
                    <form method="POST" x-bind:action="mode === 'unlock' ? `${baseUrl}/${target.id}/unlock` : null" x-on:submit="if (mode === 'reset') { $event.preventDefault(); step = 2; }" class="p-6 sm:p-8">
                        @csrf
                        @method('PUT')
                        <div class="w-14 h-14 rounded-full bg-amber-100 text-amber-600 flex items-center justify-center mb-4">
                            <svg class="w-7 h-7" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.75"><path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 1 0-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 0 0 2.25-2.25v-6.75a2.25 2.25 0 0 0-2.25-2.25H6.75a2.25 2.25 0 0 0-2.25 2.25v6.75a2.25 2.25 0 0 0 2.25 2.25Z" /></svg>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900">Konfirmasi Identitas Anda</h3>
                        <p class="mt-2 text-base text-gray-600">
                            <template x-if="mode === 'reset'"><span>Anda akan mengganti password milik <strong x-text="target.nama"></strong>.</span></template>
                            <template x-if="mode === 'unlock'"><span>Anda akan membuka kunci akun milik <strong x-text="target.nama"></strong>.</span></template>
                            Untuk keamanan, masukkan password akun Anda sendiri untuk melanjutkan.
                        </p>
                        <div class="mt-5">
                            <x-label for="admin_password_confirm" required>Password Anda</x-label>
                            <input type="password" id="admin_password_confirm" name="admin_password" x-model="target.adminPassword" required
                                class="block w-full rounded-xl border-2 border-gray-300 px-4 py-3.5 text-lg focus:outline-none focus:ring-3 focus:ring-brand-500/40 focus:border-brand-500">
                            <x-input-error :message="$errors->first('admin_password')" />
                        </div>
                        <div class="mt-6 flex gap-3">
                            <x-button type="button" variant="secondary" class="flex-1" x-on:click="modalOpen = false">Batal</x-button>
                            <x-button type="submit" class="flex-1" x-bind:disabled="!target.adminPassword" x-text="mode === 'unlock' ? 'Buka Kunci Akun' : 'Lanjutkan'"></x-button>
                        </div>
                    </form>
                </template>

                <!-- Step 2 (khusus reset password): Password Baru -->
                <template x-if="step === 2">
                    <form method="POST" x-bind:action="`${baseUrl}/${target.id}/reset-password`" class="p-6 sm:p-8">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="admin_password" x-bind:value="target.adminPassword">

                        <div class="w-14 h-14 rounded-full bg-emerald-100 text-emerald-600 flex items-center justify-center mb-4">
                            <svg class="w-7 h-7" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.75"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 5.25a3 3 0 0 1 3 3m3 0a6 6 0 0 1-7.029 5.912c-.563-.097-1.159.026-1.563.43L10.5 17.25H8.25v2.25H6v2.25H2.25v-2.818c0-.597.237-1.17.659-1.591l6.499-6.499c.404-.404.527-1 .43-1.563A6 6 0 1 1 21.75 8.25Z" /></svg>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900">Password Baru untuk <span x-text="target.nama"></span></h3>
                        <p class="mt-1 text-base text-gray-500">NIK: <span x-text="target.nik" class="font-mono"></span></p>

                        <div class="mt-5 space-y-5">
                            <div>
                                <x-label for="password_baru" required>Password Baru</x-label>
                                <x-input type="password" id="password_baru" name="password_baru" required />
                                <x-help-text>Minimal 8 karakter, kombinasi huruf besar, huruf kecil, dan angka.</x-help-text>
                            </div>
                            <div>
                                <x-label for="password_baru_confirmation" required>Konfirmasi Password Baru</x-label>
                                <x-input type="password" id="password_baru_confirmation" name="password_baru_confirmation" required />
                            </div>
                        </div>

                        <div class="mt-6 flex gap-3">
                            <x-button type="button" variant="secondary" class="flex-1" x-on:click="step = 1">Kembali</x-button>
                            <x-button type="submit" variant="success" class="flex-1">Simpan Password</x-button>
                        </div>
                    </form>
                </template>
            </div>
        </div>
    </div>
</x-layouts.admin>
