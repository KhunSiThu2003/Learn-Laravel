<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>

        @media (min-width: 768px) {
            #top-bar-sidebar {
                transform: translateX(0) !important;
            }
        }
        @media (min-width: 768px) {
            main {
                margin-left: 16rem;
                /* 64 * 0.25rem = 16rem for w-64 */
            }
        }
    </style>
</head>

<body class="font-sans antialiased bg-gray-50">
    @include('layouts.sidebar')
    @include('layouts.navigation')

    <!-- Page Content -->
    <main class="min-h-screen p-16">
        {{ $slot }}
    </main>

    <!-- Flowbite JS -->
    <script src="https://cdn.jsdelivr.net/npm/flowbite@2.5.2/dist/flowbite.min.js"></script>

    @if (session('success'))
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                notyf.success('{{ session('success') }}');
            });
        </script>
    @endif

    @if (session('error'))
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                notyf.error('{{ session('error') }}');
            });
        </script>
    @endif

    <!-- Stack for page-specific scripts -->
    @stack('scripts')
</body>

</html>
