@include('main-layouts.alert-message')
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Campus Lost & Found')</title>
    <link rel="icon" type="image/png" href="{{ asset('images/logo.png') }}">

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['"Plus Jakarta Sans"', 'Inter', 'sans-serif'],
                    },
                    colors: {
                        blue: {
                            50: '#f0fdf4',
                            100: '#dcfce7',
                            200: '#bbf7d0',
                            300: '#86efac',
                            400: '#4ade80',
                            500: '#0c3e2b',
                            600: '#0f4d36',
                            700: '#072419',
                            800: '#051811',
                            900: '#020b08',
                        },
                        brand: {
                            forest: '#0c3e2b',
                            emerald: '#0f4d36',
                            cream: '#FAF9F6',
                            gold: '#d97706',
                        }
                    }
                }
            }
        }
    </script>

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        body {
            font-family: 'Plus Jakarta Sans', 'Inter', sans-serif;
            background-color: #FAF9F6 !important;
        }
        .scrollbar-hide::-webkit-scrollbar { display: none; }
        .scrollbar-hide { -ms-overflow-style: none; scrollbar-width: none; }

        /* Sleek custom scrollbars */
        ::-webkit-scrollbar {
            width: 6px;
            height: 6px;
        }
        ::-webkit-scrollbar-track {
            background: #F5F2EB;
        }
        ::-webkit-scrollbar-thumb {
            background: #DDD0B3;
            border-radius: 3px;
        }
        ::-webkit-scrollbar-thumb:hover {
            background: #d97706;
        }

        /* Glassmorphic card styling */
        .glass-card {
            background: rgba(255, 255, 255, 0.85);
            backdrop-filter: blur(12px);
            border: 1px solid rgba(15, 77, 54, 0.08);
        }
    </style>

    @stack('styles')
</head>
<body class="bg-gray-50">
    <!-- Top Navigation -->
    @include('main-layouts.navbar')

    <!-- Sidebar Navigation (Desktop) -->
    @include('main-layouts.sidebar')

    <!-- Mobile Bottom Navigation -->
    @include('main-layouts.nav-mobile')

    <!-- Main Content -->
    <main class="@yield('has-sidebar', 'lg:ml-64') min-h-screen pt-16 pb-20">
        @yield('content')
    </main>

    <!-- Toast Notification Container -->
    <div id="toast-container" class="fixed top-20 right-4 z-50 space-y-2"></div>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    @stack('scripts')
</body>
</html>
