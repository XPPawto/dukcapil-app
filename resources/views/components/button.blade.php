@props(['variant' => 'primary', 'size' => 'lg', 'type' => 'button'])

@php
$base = 'inline-flex items-center justify-center gap-2 rounded-xl font-semibold transition
    focus-visible:outline focus-visible:outline-3 focus-visible:outline-offset-2
    disabled:opacity-50 disabled:cursor-not-allowed';

$sizes = [
    'lg' => 'px-6 py-4 text-lg min-h-[52px]',
    'md' => 'px-5 py-3 text-base min-h-[44px]',
];

$variants = [
    'primary' => 'bg-brand-600 text-white hover:bg-brand-700 focus-visible:outline-brand-500 shadow-sm',
    'secondary' => 'bg-white text-gray-800 border-2 border-gray-300 hover:bg-gray-50 focus-visible:outline-brand-500',
    'danger' => 'bg-red-600 text-white hover:bg-red-700 focus-visible:outline-red-500 shadow-sm',
    'success' => 'bg-emerald-600 text-white hover:bg-emerald-700 focus-visible:outline-emerald-500 shadow-sm',
    'ghost' => 'bg-transparent text-gray-700 hover:bg-gray-100 focus-visible:outline-brand-500',
];
@endphp

<button type="{{ $type }}" {{ $attributes->merge(['class' => "$base {$sizes[$size]} {$variants[$variant]}"]) }}>
    {{ $slot }}
</button>
