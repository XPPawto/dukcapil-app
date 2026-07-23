@props(['label', 'value', 'color' => 'brand'])

@php
$colors = [
    'brand' => 'bg-brand-50 text-brand-700',
    'amber' => 'bg-amber-50 text-amber-700',
    'red' => 'bg-red-50 text-red-700',
    'emerald' => 'bg-emerald-50 text-emerald-700',
    'gray' => 'bg-gray-100 text-gray-700',
];
@endphp

<div class="bg-white rounded-2xl border border-gray-200 shadow-sm p-5 flex items-center gap-4">
    <div class="w-14 h-14 rounded-xl flex items-center justify-center shrink-0 {{ $colors[$color] }}">
        {{ $slot }}
    </div>
    <div>
        <p class="text-3xl font-bold text-gray-900 leading-none">{{ $value }}</p>
        <p class="text-base text-gray-500 mt-1.5">{{ $label }}</p>
    </div>
</div>
