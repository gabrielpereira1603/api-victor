<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <link rel="icon" type="image/x-icon" href="{{ asset('postcss.config.svg') }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        <style>
            .popup-content h3 {
                font-size: 18px;
                color: #c30c0c;
                margin-bottom: 5px;
            }

            .popup-content p {
                font-size: 14px;
                color: #555;
                margin: 2px 0;
            }

            .popup-content strong {
                font-weight: bold;
                color: #000;
            }

            #add-blocks{
                background: rgba(129, 223, 151, 0.79) !important;
            }

            #add-lands{
                background: rgba(142, 159, 213, 0.51) !important;
            }
        </style>

    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen bg-gray-100 dark:bg-gray-900">
            <livewire:layout.navigation />

            <!-- Page Heading -->
            @if (isset($header))
                <header class="bg-white dark:bg-gray-800 shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endif

            <!-- Page Content -->
            <main>
                {{ $slot }}
            </main>
        </div>
    </body>
</html>
