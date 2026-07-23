@props(['name', 'maxWidth' => 'md'])

@php
$widths = [
    'md' => 'max-w-md',
    'lg' => 'max-w-lg',
    '2xl' => 'max-w-2xl',
    '4xl' => 'max-w-4xl',
];
@endphp

<div
    x-data="{ open: false }"
    x-on:open-modal.window="$event.detail === '{{ $name }}' && (open = true)"
    x-on:close-modal.window="open = false"
    x-on:keydown.escape.window="open = false"
    x-show="open"
    x-cloak
    class="fixed inset-0 z-50 flex items-center justify-center p-4"
    style="display: none;"
>
    <div x-show="open" x-transition.opacity x-on:click="open = false" class="fixed inset-0 bg-gray-900/60"></div>

    <div
        x-show="open"
        x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="opacity-0 scale-95"
        x-transition:enter-end="opacity-100 scale-100"
        class="relative w-full {{ $widths[$maxWidth] }} bg-white rounded-2xl shadow-xl max-h-[90vh] overflow-y-auto"
    >
        {{ $slot }}
    </div>
</div>
