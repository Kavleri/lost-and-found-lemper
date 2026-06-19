<nav class="md:hidden fixed bottom-0 left-0 right-0 bg-white border-t border-gray-200 px-4 py-2 z-40 safe-area-pb">
    <div class="flex items-center justify-around">
        <a href="{{ route('dashboard') }}"
            class="flex flex-col items-center space-y-1 p-2 {{ request()->routeIs('home') ? 'text-blue-600' : 'text-gray-600' }}">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
            </svg>
            <span class="text-xs font-medium">Home</span>
        </a>

        <a href="{{ route('items.index') }}"
            class="flex flex-col items-center space-y-1 p-2 {{ request()->routeIs('cari-barang') ? 'text-blue-600' : 'text-gray-600' }}">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
            </svg>
            <span class="text-xs font-medium">Cari</span>
        </a>

        <!-- FAB for Report -->
        <div class="relative -top-5">
            <a href="{{ route('lapor', ['type' => 'hilang']) }}"
                class="flex items-center justify-center w-14 h-14 bg-gradient-to-r from-blue-600 to-blue-700 text-white rounded-full shadow-lg hover:shadow-xl transform hover:scale-105 transition">
                <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
            </a>
        </div>

        <a href="{{ route('claims.index') }}"
            class="flex flex-col items-center space-y-1 p-2 {{ request()->routeIs('klaim-saya') ? 'text-blue-600' : 'text-gray-600' }}">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
            </svg>
            <span class="text-xs font-medium">Klaim</span>
        </a>

        <a href="{{ route('profil') }}"
            class="flex flex-col items-center space-y-1 p-2 {{ request()->routeIs('profil') ? 'text-blue-600' : 'text-gray-600' }}">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
            </svg>
            <span class="text-xs font-medium">Akun</span>
        </a>
    </div>
</nav>

<style>
    .safe-area-pb {
        padding-bottom: max(0.5rem, env(safe-area-inset-bottom));
    }
</style>
