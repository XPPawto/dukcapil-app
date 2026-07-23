@props(['name', 'label', 'required' => false, 'hint' => 'Format JPG, PNG, atau PDF. Ukuran maksimal 2 MB.'])

<div x-data="{ fileName: null }">
    <x-label :for="$name" :required="$required">{{ $label }}</x-label>

    <label
        for="{{ $name }}"
        class="flex flex-col items-center justify-center gap-2 w-full rounded-xl border-2 border-dashed border-gray-300 bg-gray-50 px-4 py-8 text-center cursor-pointer hover:bg-gray-100 hover:border-brand-400 transition"
        x-bind:class="fileName ? 'border-emerald-400 bg-emerald-50' : ''"
    >
        <template x-if="!fileName">
            <div class="flex flex-col items-center gap-2">
                <svg class="w-9 h-9 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 16.5V9.75m0 0 3 3m-3-3-3 3M6.75 19.5a4.5 4.5 0 0 1-1.41-8.775 5.25 5.25 0 0 1 10.233-2.33 3 3 0 0 1 3.758 3.848A3.752 3.752 0 0 1 18 19.5H6.75Z" />
                </svg>
                <span class="text-base font-semibold text-gray-700">Ketuk untuk pilih berkas</span>
                <span class="text-sm text-gray-500">{{ $hint }}</span>
            </div>
        </template>
        <template x-if="fileName">
            <div class="flex flex-col items-center gap-2">
                <svg class="w-9 h-9 text-emerald-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                </svg>
                <span class="text-base font-semibold text-emerald-700" x-text="fileName"></span>
                <span class="text-sm text-gray-500">Ketuk untuk ganti berkas</span>
            </div>
        </template>
        <input
            id="{{ $name }}"
            name="{{ $name }}"
            type="file"
            accept=".jpg,.jpeg,.png,.pdf"
            @if($required) required @endif
            class="sr-only"
            x-on:change="fileName = $event.target.files.length ? $event.target.files[0].name : null"
        >
    </label>
    <x-input-error :message="$errors->first($name)" />
</div>
