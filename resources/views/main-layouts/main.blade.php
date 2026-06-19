@include('main-layouts.alert-message')
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Campus Lost & Found')</title>

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        body { font-family: 'Inter', sans-serif; }
        .scrollbar-hide::-webkit-scrollbar { display: none; }
        .scrollbar-hide { -ms-overflow-style: none; scrollbar-width: none; }
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
