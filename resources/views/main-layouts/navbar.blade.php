<header class="fixed top-0 left-0 right-0 bg-white shadow-sm border-b border-gray-200 z-40">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between h-16">
            <!-- Logo & Brand -->
            <div class="flex items-center space-x-3">
                <button id="sidebar-toggle"
                    class="lg:hidden p-2 rounded-md text-gray-600 hover:text-blue-600 hover:bg-gray-100">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                </button>

                <a href="{{ route('dashboard') }}" class="flex items-center space-x-2">
                    <div class="w-10 h-10 rounded-full overflow-hidden bg-[#0a4029] flex items-center justify-center border border-emerald-800/20 shadow-sm shrink-0">
                        <img src="{{ asset('images/logo.png') }}" class="w-9 h-9 object-contain transform hover:scale-105 transition-transform duration-300" alt="Logo">
                    </div>
                    <div class="hidden sm:block">
                        <h1 class="text-lg font-bold text-gray-900">Campus Portal</h1>
                        <p class="text-xs text-gray-600">Lost & Found System</p>
                    </div>
                </a>
            </div>

            <!-- Search Bar (Desktop) -->
            <form action="{{ route('items.index') }}" method="GET" class="hidden md:flex flex-1 max-w-lg mx-8">
                <div class="relative w-full">
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari barang hilang..."
                        class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    <svg class="absolute left-3 top-2.5 w-5 h-5 text-gray-400" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                </div>
            </form>

            <!-- Right Actions -->
            <div class="flex items-center space-x-2 sm:space-x-4">
                <!-- Mobile Search -->
                <a href="{{ route('items.index') }}" class="md:hidden p-2 text-gray-600 hover:text-blue-600" title="Cari Barang">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                </a>

                <!-- Notifikasi Dropdown -->
                <div class="relative" x-data="{ open: false }">
                    <button @click="open = !open" class="p-2 text-gray-600 hover:text-blue-600 transition relative">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                        </svg>
                        @php
                            $unreadNotifCount = \App\Models\Notification::where('user_id', auth()->id())
                                ->where('is_read', false)
                                ->count();
                        @endphp
                        @if ($unreadNotifCount > 0)
                            <span class="absolute top-1 right-1 w-2 h-2 bg-red-500 rounded-full"></span>
                        @endif
                    </button>

                    <!-- Dropdown Menu -->
                    <div x-show="open" @click.away="open = false" x-transition
                        class="absolute right-0 mt-2 w-96 bg-white rounded-lg shadow-lg border border-gray-200 py-2 z-50 max-h-96 overflow-y-auto">

                        <div class="px-4 py-2 border-b border-gray-200 flex items-center justify-between">
                            <h3 class="font-semibold text-gray-900">Notifikasi</h3>
                            @if ($unreadNotifCount > 0)
                                <form method="POST" action="{{ route('notifications.readAll') }}">
                                    @csrf
                                    <button type="submit" class="text-xs text-blue-600 hover:text-blue-800">
                                        Tandai semua dibaca
                                    </button>
                                </form>
                            @endif
                        </div>

                        @php
                            $recentNotifications = \App\Models\Notification::where('user_id', auth()->id())
                                ->orderBy('created_at', 'desc')
                                ->limit(5)
                                ->get();
                        @endphp

                        @forelse($recentNotifications as $notif)
                            <a href="{{ route('notifications.index') }}"
                                class="block px-4 py-3 hover:bg-gray-50 {{ !$notif->is_read ? 'bg-blue-50' : '' }}">
                                <div class="flex items-start space-x-3">
                                    <div class="flex-shrink-0">
                                        @if (!$notif->is_read)
                                            <div class="w-2 h-2 bg-blue-600 rounded-full mt-2"></div>
                                        @else
                                            <div class="w-2 h-2 bg-gray-300 rounded-full mt-2"></div>
                                        @endif
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <p
                                            class="text-sm font-medium text-gray-900 {{ !$notif->is_read ? 'font-bold' : '' }}">
                                            {{ $notif->title }}
                                        </p>
                                        <p class="text-xs text-gray-600 truncate">{{ $notif->message }}</p>
                                        <p class="text-xs text-gray-400 mt-1">{{ $notif->created_at->diffForHumans() }}
                                        </p>
                                    </div>
                                </div>
                            </a>
                        @empty
                            <div class="px-4 py-8 text-center text-gray-500 text-sm">
                                Tidak ada notifikasi baru
                            </div>
                        @endforelse

                        <div class="border-t border-gray-200 mt-2 pt-2">
                            <a href="{{ route('notifications.index') }}"
                                class="block px-4 py-2 text-center text-sm text-blue-600 hover:bg-blue-50 font-medium">
                                Lihat Semua Notifikasi
                            </a>
                        </div>
                    </div>
                </div>
                <!-- User Profile Dropdown -->
                <div class="relative" x-data="{ open: false }">
                    @auth
                        <button @click="open = !open" class="flex items-center space-x-2 p-1 rounded-lg hover:bg-gray-100">
                            <div
                                class="w-9 h-9 rounded-full bg-gradient-to-br from-blue-400 to-blue-600 flex items-center justify-center text-white font-semibold text-sm">
                                {{ substr(auth()->user()->name, 0, 2) }}
                            </div>
                            <span
                                class="hidden lg:block text-sm font-medium text-gray-700">{{ auth()->user()->name }}</span>
                            <svg class="hidden lg:block w-4 h-4 text-gray-500" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                            </svg>
                        </button>

                        <!-- Dropdown Menu -->
                        <div x-show="open" @click.away="open = false" x-transition
                            class="absolute right-0 mt-2 w-56 bg-white rounded-lg shadow-lg border border-gray-200 py-1 z-50">

                            <div class="px-4 py-3 border-b border-gray-200">
                                <p class="text-sm font-semibold text-gray-900">{{ auth()->user()->name }}</p>
                                <p class="text-xs text-gray-600">{{ auth()->user()->email }}</p>
                                <p class="text-xs text-gray-500 mt-1">{{ ucfirst(auth()->user()->role) }}</p>
                            </div>

                            <a href="{{ route('profil') }}"
                                class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                <svg class="w-5 h-5 mr-3 text-gray-500" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                </svg>
                                Profil Saya
                            </a>

                            <a href="{{ route('claims.index') }}"
                                class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                <svg class="w-5 h-5 mr-3 text-gray-500" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                                </svg>
                                Klaim Saya
                            </a>

                            <div class="border-t border-gray-200 my-1"></div>

                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit"
                                    class="w-full flex items-center px-4 py-2 text-sm text-red-600 hover:bg-red-50">
                                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                                    </svg>
                                    Keluar
                                </button>
                            </form>
                        </div>
                    @else
                        <a href="{{ route('login') }}"
                            class="flex items-center space-x-2 px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1" />
                            </svg>
                            <span>Login</span>
                        </a>
                    @endauth
                </div>
            </div>
        </div>
    </div>
</header>

<script>
    // Sidebar Toggle
    document.getElementById('sidebar-toggle')?.addEventListener('click', function() {
        const sidebar = document.getElementById('sidebar');
        sidebar?.classList.toggle('-translate-x-full');
    });
</script>
