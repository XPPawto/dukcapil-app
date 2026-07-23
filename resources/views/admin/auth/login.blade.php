<x-layouts.base title="Masuk Petugas">
    <div class="min-h-screen bg-gray-900 flex items-center justify-center px-4 py-12">
        <div class="w-full max-w-md">
            <div class="text-center mb-8">
                <x-app-logo dark class="justify-center" />
                <p class="mt-4 text-lg text-gray-400">Dashboard Petugas Dukcapil</p>
            </div>

            <div class="bg-white rounded-2xl shadow-xl p-6 sm:p-8">
                @if($errors->any())
                    <x-alert type="danger" class="mb-6">Username atau Password salah.</x-alert>
                @endif

                <form method="POST" action="{{ route('admin.login.store') }}" class="space-y-6">
                    @csrf
                    <div>
                        <x-label for="username" required>Username</x-label>
                        <x-input type="text" id="username" name="username" required autofocus :error="$errors->first('username')" />
                    </div>
                    <div>
                        <x-label for="password" required>Password</x-label>
                        <x-input type="password" id="password" name="password" required :error="$errors->first('password')" />
                    </div>
                    <x-button type="submit" class="w-full">Masuk Dashboard</x-button>
                </form>
            </div>

            <p class="text-center text-base text-gray-500 mt-6">
                <a href="{{ route('welcome') }}" class="hover:text-gray-300">&larr; Kembali ke Portal Warga</a>
            </p>
        </div>
    </div>
</x-layouts.base>
