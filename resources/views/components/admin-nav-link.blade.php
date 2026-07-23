@props(['href', 'active' => false])

<a href="{{ $href }}" {{ $attributes->merge(['class' => 'flex items-center gap-3 px-4 py-3 rounded-xl text-base font-semibold transition ' . ($active ? 'bg-brand-600 text-white' : 'text-gray-300 hover:bg-gray-800 hover:text-white')]) }}>
    <svg class="w-6 h-6 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.75">
        {{ $icon }}
    </svg>
    {{ $slot }}
</a>
