<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Confirm Transaction</title>
    <link rel="icon" type="image/ico" href="{{ asset('favicon_io/favicon.ico') }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        @media print {
            body * {
                visibility: hidden;
            }
            .receipt {
                visibility: visible;
            }
            .receipt * {
                visibility: visible;
            }

            h2.salam {
                visibility: visible;
                display: block;
            }
        }
        .salam {
            visibility: hidden;
            display:  none;
        }
    </style>
    @livewireStyles
</head>
<body class="bg-gray-100 flex justify-center pb-20">

    {{ $slot }}

    @livewireScripts
</body>
</html>
