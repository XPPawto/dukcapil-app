@props(['for' => null, 'required' => false])

<label @if($for) for="{{ $for }}" @endif {{ $attributes->merge(['class' => 'block text-base font-semibold text-gray-800 mb-2']) }}>
    {{ $slot }}
    @if($required)
        <span class="text-red-600">*</span>
    @endif
</label>
