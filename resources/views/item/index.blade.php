@extends('main-layouts.main')

@section('title', 'Cari Barang - Campus Lost & Found')

@section('content')
    <div class="min-h-screen bg-gray-50 pb-24">
        <!-- Header -->
        <div class="bg-white shadow-sm border-b">
            <div class="max-w-7xl mx-auto px-4 py-6">
                <h1 class="text-2xl font-bold">Cari Barang</h1>
                <p class="text-gray-600">Temukan barang yang hilang atau yang ditemukan</p>
            </div>
        </div>

        <div class="max-w-7xl mx-auto px-4 py-8">
            <!-- Filter Section -->
            <div class="bg-white rounded-lg p-4 mb-6 shadow-sm">
                <form method="GET" action="{{ route('items.index') }}">
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari barang..."
                            class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                        <select name="status"
                            class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                            <option value="">Semua Status</option>
                            <option value="hilang" {{ request('status') == 'hilang' ? 'selected' : '' }}>Hilang</option>
                            <option value="ditemukan" {{ request('status') == 'ditemukan' ? 'selected' : '' }}>Ditemukan
                            </option>
                            <option value="diklaim" {{ request('status') == 'diklaim' ? 'selected' : '' }}>Diklaim</option>
                        </select>
                        <select name="category"
                            class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                            <option value="">Semua Kategori</option>
                            @foreach ($categories as $cat)
                                <option value="{{ $cat->id }}" {{ request('category') == $cat->id ? 'selected' : '' }}>
                                    {{ $cat->name }}
                                </option>
                            @endforeach
                        </select>
                        <button type="submit"
                            class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                            Cari
                        </button>
                    </div>
                </form>
            </div>

            <!-- Grid Items -->
            @if ($items->count() > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach ($items as $item)
                        <div
                            class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden hover:shadow-lg transition">
                            <!-- Image dengan Badge Status -->
                            <div class="relative h-48 overflow-hidden">
                                <img src="{{ $item->image1 ? asset('storage/' . $item->image1) : 'https://via.placeholder.com/400x300?text=No+Image' }}"
                                    class="w-full h-full object-cover">

                                <!-- Badge Status (BARU DITAMBAHKAN) -->
                                <span
                                    class="absolute top-3 left-3 px-3 py-1 rounded-full text-xs font-bold
                                {{ $item->status === 'ditemukan'
                                    ? 'bg-green-500 text-white'
                                    : ($item->status === 'hilang'
                                        ? 'bg-red-500 text-white'
                                        : ($item->status === 'diklaim'
                                            ? 'bg-yellow-500 text-white'
                                            : 'bg-gray-500 text-white')) }}">
                                    {{ strtoupper($item->status) }}
                                </span>
                            </div>

                            <!-- Content -->
                            <div class="p-4">
                                <h3 class="font-bold text-lg mb-2">{{ $item->name }}</h3>
                                <p class="text-sm text-gray-600 mb-2">
                                    <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                                    </svg>
                                    {{ $item->category->name ?? 'Umum' }}
                                </p>
                                <p class="text-sm text-gray-600 mb-2">
                                    <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                    {{ $item->created_at->format('d M Y') }}
                                </p>
                                <p class="text-sm text-gray-600 mb-4 line-clamp-2">{{ Str::limit($item->description, 80) }}
                                </p>

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
                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
                    </svg>
                    <h3 class="mt-2 text-sm font-medium text-gray-900">Tidak ada barang</h3>
                    <p class="mt-1 text-sm text-gray-500">Coba ubah filter pencarian Anda.</p>
                </div>
            @endif
        </div>
    </div>
@endsection
