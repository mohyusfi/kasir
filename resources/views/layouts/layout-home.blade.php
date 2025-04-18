<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Welcome</title>
    <link rel="icon" type="image/ico" href="{{ asset('favicon_io/favicon.ico') }}">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />

    <!-- Styles / Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    {{-- @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
    @else

    @endif --}}
</head>

<body class="bg-neutral-200 text-[#1b1b18] flex min-h-screen lg:justify-center">
    {{ $slot }}
</body>

</html>