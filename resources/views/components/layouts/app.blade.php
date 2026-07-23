<x-layouts.base :title="$title ?? null">
    <div x-data="{ mobileOpen: false }" class="min-h-screen flex flex-col">
        <header class="bg-white border-b border-gray-200 sticky top-0 z-30">
            <div class="max-w-6xl mx-auto px-4 sm:px-6">
                <div class="flex items-center justify-between h-20">
                    <a href="{{ route('warga.dashboard') }}"><x-app-logo /></a>

                    <nav class="hidden md:flex items-center gap-1">
                        <x-nav-link :href="route('warga.dashboard')" :active="request()->routeIs('warga.dashboard')">Beranda</x-nav-link>
                        <x-nav-link :href="route('warga.permohonan.pilih')" :active="request()->routeIs('warga.permohonan.*') && !request()->routeIs('warga.permohonan.riwayat')">Ajukan Permohonan</x-nav-link>
                        <x-nav-link :href="route('warga.permohonan.riwayat')" :active="request()->routeIs('warga.permohonan.riwayat')">Riwayat</x-nav-link>
                        <x-nav-link :href="route('warga.profil')" :active="request()->routeIs('warga.profil')">Profil Saya</x-nav-link>
                    </nav>

                    <div class="hidden md:flex items-center gap-3">
                        <span class="text-base text-gray-600">Halo, <span class="font-semibold text-gray-900">{{ auth('citizen')->user()->full_name }}</span></span>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <x-button type="submit" variant="ghost" size="md">Keluar</x-button>
                        </form>
                    </div>

                    <button type="button" x-on:click="mobileOpen = !mobileOpen" class="md:hidden p-2.5 rounded-lg text-gray-700 hover:bg-gray-100" aria-label="Buka menu">
                        <svg x-show="!mobileOpen" class="w-8 h-8" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" /></svg>
                        <svg x-show="mobileOpen" class="w-8 h-8" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" style="display:none"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" /></svg>
                    </button>
                </div>

                <nav x-show="mobileOpen" x-cloak class="md:hidden pb-4 flex flex-col gap-1 border-t border-gray-100 pt-3">
                    <x-nav-link :href="route('warga.dashboard')" :active="request()->routeIs('warga.dashboard')" mobile>Beranda</x-nav-link>
                    <x-nav-link :href="route('warga.permohonan.pilih')" :active="request()->routeIs('warga.permohonan.*')" mobile>Ajukan Permohonan</x-nav-link>
                    <x-nav-link :href="route('warga.permohonan.riwayat')" :active="request()->routeIs('warga.permohonan.riwayat')" mobile>Riwayat</x-nav-link>
                    <x-nav-link :href="route('warga.profil')" :active="request()->routeIs('warga.profil')" mobile>Profil Saya</x-nav-link>
                    <form method="POST" action="{{ route('logout') }}" class="pt-2">
                        @csrf
                        <x-button type="submit" variant="secondary" size="md" class="w-full">Keluar</x-button>
                    </form>
                </nav>
            </div>
        </header>

        <main class="flex-1">
            <div class="max-w-6xl mx-auto px-4 sm:px-6 py-8">
                @if(session('status'))
                    <x-alert type="success" class="mb-6">{{ session('status') }}</x-alert>
                @endif
                {{ $slot }}
            </div>
        </main>

        <footer class="border-t border-gray-200 bg-white">
            <div class="max-w-6xl mx-auto px-4 sm:px-6 py-6 text-center text-sm text-gray-500">
                &copy; {{ date('Y') }} Registrasi Pelayanan Dukcapil — Dinas Kependudukan dan Pencatatan Sipil Kota Palembang.
            </div>
        </footer>
    </div>
</x-layouts.base>
