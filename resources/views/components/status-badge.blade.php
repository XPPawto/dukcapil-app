@props(['status'])

@php
$map = [
    'SUBMITTED' => ['label' => 'Menunggu Verifikasi', 'class' => 'bg-blue-100 text-blue-800 border-blue-300'],
    'IN_REVIEW' => ['label' => 'Sedang Diproses', 'class' => 'bg-amber-100 text-amber-800 border-amber-300'],
    'REJECTED' => ['label' => 'Ditolak / Perbaiki', 'class' => 'bg-red-100 text-red-800 border-red-300'],
    'APPROVED' => ['label' => 'Selesai & Terbit', 'class' => 'bg-emerald-100 text-emerald-800 border-emerald-300'],
    'EXPIRED' => ['label' => 'Kedaluwarsa', 'class' => 'bg-gray-100 text-gray-600 border-gray-300'],
];
$item = $map[$status] ?? ['label' => $status, 'class' => 'bg-gray-100 text-gray-600 border-gray-300'];
@endphp

<span {{ $attributes->merge(['class' => "inline-flex items-center gap-1.5 rounded-full border px-3.5 py-1.5 text-sm font-semibold whitespace-nowrap {$item['class']}"]) }}>
    <span class="w-2 h-2 rounded-full bg-current opacity-70"></span>
    {{ $item['label'] }}
</span>
