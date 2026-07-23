@props(['error' => null])

<input {{ $attributes->merge([
    'class' => 'block w-full rounded-xl border-2 px-4 py-3.5 text-lg text-gray-900 placeholder:text-gray-400
        focus:outline-none focus:ring-3 focus:ring-brand-500/40
        ' . ($error ? 'border-red-400 focus:border-red-500' : 'border-gray-300 focus:border-brand-500'),
]) }}>
