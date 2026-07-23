@props(['dark' => false])

<span {{ $attributes->merge(['class' => 'inline-flex items-center gap-2.5 font-bold tracking-tight ' . ($dark ? 'text-white' : 'text-gray-900')]) }}>
    <img src="{{ asset('images/logo-disdukcapil.jpeg') }}" alt="Logo Disdukcapil Palembang" class="w-10 h-10 rounded-full object-cover shrink-0">
    <span class="text-base sm:text-lg leading-tight">Registrasi Pelayanan Dukcapil</span>
</span>
