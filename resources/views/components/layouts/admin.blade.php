@php $role = $roleAdmin ?? 'admin'; @endphp
<x-layouts.base :title="$title ?? null">
    <div x-data="{ sidebarOpen: false }" class="min-h-screen md:flex bg-gray-100">
        <!-- Sidebar -->
        <aside
            class="fixed inset-y-0 left-0 z-40 w-72 bg-gray-900 text-gray-300 flex flex-col transform transition-transform md:translate-x-0 md:static md:shrink-0"
            x-bind:class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'"
        >
            <div class="h-20 flex items-center px-6 border-b border-gray-800">
                <x-app-logo dark />
            </div>

            <nav class="flex-1 px-4 py-6 space-y-1">
                <x-admin-nav-link :href="route('admin.dashboard')" :active="request()->routeIs('admin.dashboard')">
                    <x-slot:icon><path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6A2.25 2.25 0 0 1 6 3.75h2.25A2.25 2.25 0 0 1 10.5 6v2.25a2.25 2.25 0 0 1-2.25 2.25H6a2.25 2.25 0 0 1-2.25-2.25V6ZM3.75 15.75A2.25 2.25 0 0 1 6 13.5h2.25a2.25 2.25 0 0 1 2.25 2.25V18a2.25 2.25 0 0 1-2.25 2.25H6A2.25 2.25 0 0 1 3.75 18v-2.25ZM13.5 6a2.25 2.25 0 0 1 2.25-2.25H18A2.25 2.25 0 0 1 20.25 6v2.25A2.25 2.25 0 0 1 18 10.5h-2.25a2.25 2.25 0 0 1-2.25-2.25V6ZM13.5 15.75a2.25 2.25 0 0 1 2.25-2.25H18a2.25 2.25 0 0 1 2.25 2.25V18A2.25 2.25 0 0 1 18 20.25h-2.25A2.25 2.25 0 0 1 13.5 18v-2.25Z" /></x-slot:icon>
                    Dashboard
                </x-admin-nav-link>

                <x-admin-nav-link :href="route('admin.verifikasi.index')" :active="request()->routeIs('admin.verifikasi.*')">
                    <x-slot:icon><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" /></x-slot:icon>
                    Verifikasi Pengajuan
                </x-admin-nav-link>

                <x-admin-nav-link :href="route('admin.users.index')" :active="request()->routeIs('admin.users.*')">
                    <x-slot:icon><path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 0 0 2.625.372 9.337 9.337 0 0 0 4.121-.952 4.125 4.125 0 0 0-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 0 1 8.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0 1 11.964-3.07M12 6.375a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0Zm8.25 2.25a2.625 2.625 0 1 1-5.25 0 2.625 2.625 0 0 1 5.25 0Z" /></x-slot:icon>
                    Manajemen User
                </x-admin-nav-link>

                @if($role === 'super_admin')
                    <x-admin-nav-link :href="route('admin.audit-logs.index')" :active="request()->routeIs('admin.audit-logs.*')">
                        <x-slot:icon><path stroke-linecap="round" stroke-linejoin="round" d="M12 12.75c1.148 0 2.278.08 3.383.236 1.037.146 1.866.966 1.866 2.013 0 3.728-2.35 6.75-3.5 6.75s-3.5-3.022-3.5-6.75c0-1.048.83-1.867 1.866-2.013A24.204 24.204 0 0 1 12 12.75Zm0 0V9.157m0 3.593c-.755 0-1.5.022-2.235.066M12 9.157A24.301 24.301 0 0 1 4.5 8.507c-1.036.146-1.865.966-1.865 2.013 0 1.05.35 2.032.96 2.815M12 9.157c2.66 0 5.216.386 7.622 1.104M12 3.75a.75.75 0 0 1 .75.75v3.75a.75.75 0 0 1-1.5 0V4.5a.75.75 0 0 1 .75-.75Z" /></x-slot:icon>
                        Audit Log
                    </x-admin-nav-link>
                @endif
            </nav>

            <div class="p-4 border-t border-gray-800">
                <div class="flex items-center gap-3 px-2 py-2">
                    <div class="w-10 h-10 rounded-full bg-brand-600 text-white flex items-center justify-center font-bold shrink-0">
                        {{ strtoupper(substr($namaAdmin ?? 'A', 0, 1)) }}
                    </div>
                    <div class="min-w-0">
                        <p class="text-white font-semibold text-base truncate">{{ $namaAdmin ?? 'Petugas' }}</p>
                        <p class="text-sm text-gray-400">{{ $role === 'super_admin' ? 'Super Admin' : 'Admin / Petugas' }}</p>
                    </div>
                </div>
                <form method="POST" action="{{ route('admin.logout') }}" class="mt-2">
                    @csrf
                    <button type="submit" class="w-full flex items-center gap-2.5 px-3 py-2.5 rounded-lg text-base font-semibold text-gray-300 hover:bg-gray-800 hover:text-white transition">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0 0 13.5 3h-6a2.25 2.25 0 0 0-2.25 2.25v13.5A2.25 2.25 0 0 0 7.5 21h6a2.25 2.25 0 0 0 2.25-2.25V15M12 9l3 3m0 0-3 3m3-3H2.25" /></svg>
                        Keluar
                    </button>
                </form>
            </div>
        </aside>

        <div x-show="sidebarOpen" x-on:click="sidebarOpen = false" x-cloak class="fixed inset-0 bg-gray-900/50 z-30 md:hidden"></div>

        <!-- Main content -->
        <div class="flex-1 min-w-0 flex flex-col">
            <header class="bg-white border-b border-gray-200 h-16 flex items-center px-4 sm:px-6 gap-4 md:hidden">
                <button type="button" x-on:click="sidebarOpen = true" class="p-2 rounded-lg text-gray-700 hover:bg-gray-100" aria-label="Buka menu">
                    <svg class="w-7 h-7" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" /></svg>
                </button>
                <x-app-logo />
            </header>

            <main class="flex-1 p-4 sm:p-8">
                @if(session('status'))
                    <x-alert type="success" class="mb-6">{{ session('status') }}</x-alert>
                @endif
                {{ $slot }}
            </main>
        </div>
    </div>
</x-layouts.base>
