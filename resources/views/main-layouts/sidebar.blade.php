<aside id="sidebar"
    class="fixed left-0 top-16 bottom-0 w-64 bg-white border-r border-gray-200 z-30 transform -translate-x-full lg:translate-x-0 transition-transform duration-300 ease-in-out overflow-y-auto">
    <div class="p-4">
        <!-- Quick Actions -->
        <a href="{{ route('lapor', ['type' => 'hilang']) }}"
            class="flex items-center justify-center w-full px-4 py-3 mb-6 bg-gradient-to-r from-blue-600 to-blue-700 text-white rounded-lg hover:from-blue-700 hover:to-blue-800 transition shadow-md hover:shadow-lg">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
            </svg>
            <span class="font-semibold">Laporkan Barang</span>
        </a>

        <!-- Navigation Menu -->
        <nav class="space-y-1">
            <a href="{{ route('dashboard') }}"
                class="flex items-center px-4 py-3 text-gray-700 rounded-lg hover:bg-blue-50 hover:text-blue-600 transition {{ request()->routeIs('home') ? 'bg-blue-50 text-blue-600' : '' }}">
                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                </svg>
                <span class="font-medium">Beranda</span>
            </a>

            <a href="{{ route('lapor', ['type' => 'hilang']) }}"
                class="flex items-center px-4 py-3 text-gray-700 rounded-lg hover:bg-blue-50 hover:text-blue-600 transition {{ request()->routeIs('items.hilang') ? 'bg-blue-50 text-blue-600' : '' }}">
                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                </svg>
                <span class="font-medium">Laporkan Hilang</span>
            </a>

            <a href="{{ route('lapor', ['type' => 'ditemukan']) }}"
                class="flex items-center px-4 py-3 text-gray-700 rounded-lg hover:bg-blue-50 hover:text-blue-600 transition {{ request()->routeIs('items.ditemukan') ? 'bg-blue-50 text-blue-600' : '' }}">
                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <span class="font-medium">Laporkan Ditemukan</span>
            </a>

            <a href="{{ route('items.index') }}"
                class="flex items-center px-4 py-3 text-gray-700 rounded-lg hover:bg-blue-50 hover:text-blue-600 transition {{ request()->routeIs('cari-barang') ? 'bg-blue-50 text-blue-600' : '' }}">
                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                </svg>
                <span class="font-medium">Cari Barang</span>
            </a>

            <a href="{{ route('claims.index') }}"
                class="flex items-center px-4 py-3 text-gray-700 rounded-lg hover:bg-blue-50 hover:text-blue-600 transition {{ request()->routeIs('klaim-saya') ? 'bg-blue-50 text-blue-600' : '' }}">
                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" />
                </svg>
                <span class="font-medium">Klaim Saya</span>
                @php
                    $klaimCount =
                        \App\Models\Claim::where('claimant_id', auth()->id())
                            ->whereIn('status', ['pending', 'approved'])
                            ->count() ?? 0;
                @endphp
                @if ($klaimCount > 0)
                    <span
                        class="ml-auto bg-red-500 text-white text-xs font-bold px-2 py-0.5 rounded-full">{{ $klaimCount }}</span>
                @endif
            </a>

            <a href="{{ route('notifications.index') }}"
                class="flex items-center px-4 py-3 text-gray-700 rounded-lg hover:bg-blue-50 hover:text-blue-600 transition {{ request()->routeIs('notifikasi') ? 'bg-blue-50 text-blue-600' : '' }}">
                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                </svg>
                <span class="font-medium">Notifikasi</span>
                @php
                    $notifCount =
                        \App\Models\Notification::where('user_id', auth()->id())
                            ->where('is_read', false)
                            ->count() ?? 0;
                @endphp
                @if ($notifCount > 0)
                    <span
                        class="ml-auto bg-red-500 text-white text-xs font-bold px-2 py-0.5 rounded-full">{{ $notifCount }}</span>
                @endif
            </a>
        </nav>

        <!-- Help Section -->
        <div class="mt-6 pt-6 border-t border-gray-200">
            <a href="#" class="flex items-center px-4 py-2 text-sm text-gray-600 hover:text-blue-600">
                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                Bantuan & FAQ
            </a>
            <a href="#" class="flex items-center px-4 py-2 text-sm text-gray-600 hover:text-blue-600">
                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                </svg>
                Hubungi Kami
            </a>
        </div>
    </div>
</aside>

<!-- Overlay for mobile -->
<div id="sidebar-overlay" class="fixed inset-0 bg-black bg-opacity-50 z-20 hidden lg:hidden"
    onclick="document.getElementById('sidebar').classList.add('-translate-x-full')"></div>
