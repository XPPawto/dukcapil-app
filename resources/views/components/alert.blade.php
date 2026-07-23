@props(['type' => 'info'])

@php
$styles = [
    'info' => ['wrap' => 'bg-blue-50 border-blue-300 text-blue-900', 'icon' => 'text-blue-600'],
    'success' => ['wrap' => 'bg-emerald-50 border-emerald-300 text-emerald-900', 'icon' => 'text-emerald-600'],
    'warning' => ['wrap' => 'bg-amber-50 border-amber-300 text-amber-900', 'icon' => 'text-amber-600'],
    'danger' => ['wrap' => 'bg-red-50 border-red-300 text-red-900', 'icon' => 'text-red-600'],
];
$s = $styles[$type];
@endphp

<div {{ $attributes->merge(['class' => "flex items-start gap-3 rounded-xl border-2 p-4 text-base {$s['wrap']}"]) }}>
    <svg class="w-6 h-6 shrink-0 mt-0.5 {{ $s['icon'] }}" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
        @if($type === 'success')
            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
        @elseif($type === 'danger')
            <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126ZM12 15.75h.007v.008H12v-.008Z" />
        @elseif($type === 'warning')
            <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m0 3.75h.007v.008H12v-.008ZM21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
        @else
            <path stroke-linecap="round" stroke-linejoin="round" d="M11.25 11.25l.041-.02a.75.75 0 0 1 1.063.852l-.708 2.836a.75.75 0 0 0 1.063.853l.041-.021M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9-3.75h.008v.008H12V8.25Z" />
        @endif
    </svg>
    <div class="flex-1">{{ $slot }}</div>
</div>
