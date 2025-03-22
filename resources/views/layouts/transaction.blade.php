<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    @vite(['resources/css/app.css'])
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
<body class="bg-gray-100 flex justify-center  h-screen">
    @yield('content')
    @livewireScripts
</body>
</html>
