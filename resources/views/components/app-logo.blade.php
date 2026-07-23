@props(['dark' => false])

<span {{ $attributes->merge(['class' => 'inline-flex items-center gap-2.5 font-bold tracking-tight ' . ($dark ? 'text-white' : 'text-gray-900')]) }}>
    <span class="flex items-center justify-center w-10 h-10 rounded-xl bg-brand-600 text-white shrink-0">
        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75m-3-7.036A11.959 11.959 0 0 1 3.598 6 11.99 11.99 0 0 0 3 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285Z" />
        </svg>
    </span>
    <span class="text-xl leading-tight">Sipenkar</span>
</span>
