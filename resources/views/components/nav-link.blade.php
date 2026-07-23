@props(['href', 'active' => false, 'mobile' => false])

@php
$base = $mobile
    ? 'block px-4 py-3 rounded-lg text-lg font-semibold'
    : 'px-4 py-2.5 rounded-lg text-base font-semibold';
$state = $active ? 'bg-brand-50 text-brand-700' : 'text-gray-700 hover:bg-gray-100';
@endphp

<a href="{{ $href }}" {{ $attributes->merge(['class' => "$base $state transition"]) }}>
    {{ $slot }}
</a>
