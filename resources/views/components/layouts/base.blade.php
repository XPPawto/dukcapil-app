<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=5">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title ?? 'Registrasi Pelayanan Dukcapil' }}</title>
    <link rel="icon" type="image/jpeg" href="{{ asset('images/logo-disdukcapil.jpeg') }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50 text-gray-900 antialiased" x-cloak>
    {{ $slot }}
</body>
</html>
