@extends('main-layouts.main')

@section('title', 'Dashboard - Campus Lost & Found')

@section('content')
    <div class="min-h-screen bg-gray-50 pb-24">

        <!-- Hero Section dengan Search -->
        <div class="bg-gradient-to-br from-blue-600 to-blue-800 text-white pb-24">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
                <div class="text-center mb-8">
                    <h1 class="text-3xl md:text-4xl font-bold mb-2">Campus Lost & Found</h1>
                    <p class="text-blue-100 text-lg">Temukan barang yang hilang atau kembalikan barang yang Anda temukan</p>
                </div>

                <!-- Search Bar -->
                <div class="max-w-3xl mx-auto">
                    <form method="GET" action="{{ route('dashboard') }}" class="relative">
                        <input type="text" name="search" value="{{ request('search') }}"
                            placeholder="Cari barang (laptop, dompet, kunci, dll)..."
                            class="w-full px-6 py-4 rounded-full text-gray-900 shadow-lg focus:ring-4 focus:ring-blue-300 focus:outline-none text-lg">
                        <button type="submit"
                            class="absolute right-3 top-2 bg-blue-600 text-white p-2.5 rounded-full hover:bg-blue-700 transition">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 -mt-16">

            <!-- Statistik Cards -->
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-8">
                <div class="bg-white rounded-xl shadow-md p-6 border-l-4 border-blue-500">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-gray-600 font-medium">Total Barang</p>
                            <p class="text-3xl font-bold text-gray-900 mt-1">{{ $stats['total_items'] }}</p>
                        </div>
                        <div class="p-3 bg-blue-100 rounded-full">
                            <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                            </svg>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-xl shadow-md p-6 border-l-4 border-green-500">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-gray-600 font-medium">Ditemukan</p>
                            <p class="text-3xl font-bold text-gray-900 mt-1">{{ $stats['found_items'] }}</p>
                        </div>
                        <div class="p-3 bg-green-100 rounded-full">
                            <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-xl shadow-md p-6 border-l-4 border-red-500">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-gray-600 font-medium">Hilang</p>
                            <p class="text-3xl font-bold text-gray-900 mt-1">{{ $stats['lost_items'] }}</p>
                        </div>
                        <div class="p-3 bg-red-100 rounded-full">
                            <svg class="w-8 h-8 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                            </svg>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-xl shadow-md p-6 border-l-4 border-yellow-500">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-gray-600 font-medium">Diklaim</p>
                            <p class="text-3xl font-bold text-gray-900 mt-1">{{ $stats['claimed_items'] }}</p>
                        </div>
                        <div class="p-3 bg-yellow-100 rounded-full">
                            <svg class="w-8 h-8 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                            </svg>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tombol Aksi Cepat -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-8">
                <a href="{{ route('lapor', ['type' => 'hilang']) }}"
                    class="bg-gradient-to-r from-blue-600 to-blue-700 text-white rounded-xl p-6 shadow-lg hover:shadow-xl transition transform hover:-translate-y-1 flex items-center">
                    <div class="p-3 bg-white bg-opacity-20 rounded-full mr-4">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-lg font-bold">Laporkan Barang Hilang</h3>
                        <p class="text-blue-100 text-sm">Kehilangan sesuatu? Laporkan di sini</p>
                    </div>
                </a>

                <a href="{{ route('lapor', ['type' => 'ditemukan']) }}"
                    class="bg-gradient-to-r from-green-600 to-green-700 text-white rounded-xl p-6 shadow-lg hover:shadow-xl transition transform hover:-translate-y-1 flex items-center">
                    <div class="p-3 bg-white bg-opacity-20 rounded-full mr-4">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-lg font-bold">Laporkan Barang Ditemukan</h3>
                        <p class="text-green-100 text-sm">Menemukan barang? Bantu kembalikan</p>
                    </div>
                </a>
            </div>

            <!-- Filter & Daftar Barang -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 mb-8">
                <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-6">
                    <h2 class="text-xl font-bold text-gray-900 mb-4 md:mb-0">Daftar Barang</h2>

                    <!-- Filter -->
                    <form method="GET" action="{{ route('dashboard') }}" class="flex flex-wrap gap-3">
                        <select name="status"
                            class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            <option value="">Semua Status</option>
                            <option value="hilang" {{ request('status') == 'hilang' ? 'selected' : '' }}>Hilang</option>
                            <option value="ditemukan" {{ request('status') == 'ditemukan' ? 'selected' : '' }}>Ditemukan
                            </option>
                            <option value="diklaim" {{ request('status') == 'diklaim' ? 'selected' : '' }}>Diklaim
                            </option>
                        </select>

                        <select name="category"
                            class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            <option value="">Semua Kategori</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}"
                                    {{ request('category') == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>

                        @if (request('search') || request('status') || request('category'))
                            <a href="{{ route('dashboard') }}"
                                class="px-4 py-2 text-gray-600 border border-gray-300 rounded-lg hover:bg-gray-50">
                                Reset
                            </a>
                        @endif
                    </form>
                </div>

                <!-- Grid Barang -->
                @if ($items->count() > 0)
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        @foreach ($items as $item)
                            <div
                                class="border border-gray-200 rounded-xl overflow-hidden hover:shadow-lg transition group">
                                <!-- Image -->
                                <div class="relative h-48 overflow-hidden">
                                    <img src="{{ $item->image1 ? asset('storage/' . $item->image1) : 'https://via.placeholder.com/400x300?text=No+Image' }}"
                                        alt="{{ $item->name }}"
                                        class="w-full h-full object-cover group-hover:scale-105 transition duration-300">

                                    <!-- Badge Status -->
                                    <span
                                        class="absolute top-3 left-3 px-3 py-1 rounded-full text-xs font-bold
                                    {{ $item->status === 'ditemukan'
                                        ? 'bg-green-500 text-white'
                                        : ($item->status === 'hilang'
                                            ? 'bg-red-500 text-white'
                                            : 'bg-yellow-500 text-white') }}">
                                        {{ strtoupper($item->status) }}
                                    </span>
                                </div>

                                <!-- Content -->
                                <div class="p-4">
                                    <h3 class="font-bold text-gray-900 mb-2 truncate">{{ $item->name }}</h3>

                                    <div class="flex items-center text-sm text-gray-600 mb-2">
                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                                        </svg>
                                        {{ $item->category->name ?? 'Umum' }}
                                    </div>

                                    <div class="flex items-center text-sm text-gray-600 mb-3">
                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                        </svg>
                                        {{ $item->created_at->format('d M Y') }}
                                    </div>

                                    <p class="text-sm text-gray-600 line-clamp-2 mb-4">
                                        {{ Str::limit($item->description, 80) }}</p>

                                    <a href="{{ route('items.show', $item) }}"
                                        class="block w-full text-center px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition font-medium">
                                        Lihat Detail
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <!-- Pagination -->
                    <div class="mt-8">
                        {{ $items->links() }}
                    </div>
                @else
                    <div class="text-center py-12">
                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
                        </svg>
                        <h3 class="mt-2 text-sm font-medium text-gray-900">Tidak ada barang</h3>
                        <p class="mt-1 text-sm text-gray-500">Coba ubah filter pencarian Anda.</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
