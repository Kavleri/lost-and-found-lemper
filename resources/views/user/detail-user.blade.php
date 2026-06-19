@extends('main-layouts.main')

@section('title', 'Detail User - Admin')

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="mb-6">
        <a href="{{ route('users.index') }}" class="inline-flex items-center text-sm text-gray-600 hover:text-blue-600 mb-2">
            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
            </svg>
            Kembali ke Daftar User
        </a>
        <h1 class="text-2xl font-bold text-gray-900">Detail User</h1>
    </div>

    <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
        <!-- Header -->
        <div class="bg-gradient-to-r from-blue-600 to-blue-700 px-6 py-8 text-white">
            <div class="flex items-center space-x-4">
                <div class="w-20 h-20 rounded-full bg-white bg-opacity-20 flex items-center justify-center text-2xl font-bold">
                    {{ substr($user->name, 0, 2) }}
                </div>
                <div>
                    <h2 class="text-2xl font-bold">{{ $user->name }}</h2>
                    <p class="text-blue-100">{{ $user->email }}</p>
                    <span class="inline-flex items-center mt-2 px-3 py-1 rounded-full text-xs font-medium bg-white bg-opacity-20">
                        {{ ucfirst($user->role) }}
                    </span>
                </div>
            </div>
        </div>

        <!-- Info Grid -->
        <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <h3 class="text-xs font-semibold text-gray-500 uppercase">NIM / NIP</h3>
                <p class="mt-1 text-sm text-gray-900">{{ $user->nim_nip ?? '-' }}</p>
            </div>
            <div>
                <h3 class="text-xs font-semibold text-gray-500 uppercase">Departemen</h3>
                <p class="mt-1 text-sm text-gray-900">{{ $user->department ?? '-' }}</p>
            </div>
            <div>
                <h3 class="text-xs font-semibold text-gray-500 uppercase">No. Telepon</h3>
                <p class="mt-1 text-sm text-gray-900">{{ $user->phone ?? '-' }}</p>
            </div>
            <div>
                <h3 class="text-xs font-semibold text-gray-500 uppercase">Status Verifikasi</h3>
                <p class="mt-1">
                    @if($user->is_verified)
                        <span class="inline-flex items-center text-sm font-medium text-green-600">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                            </svg>
                            Terverifikasi
                        </span>
                    @else
                        <span class="inline-flex items-center text-sm font-medium text-yellow-600">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01"/>
                            </svg>
                            Belum Terverifikasi
                        </span>
                    @endif
                </p>
            </div>
            <div>
                <h3 class="text-xs font-semibold text-gray-500 uppercase">Bergabung Sejak</h3>
                <p class="mt-1 text-sm text-gray-900">{{ $user->created_at->format('d M Y, H:i') }}</p>
            </div>
            <div>
                <h3 class="text-xs font-semibold text-gray-500 uppercase">Terakhir Diperbarui</h3>
                <p class="mt-1 text-sm text-gray-900">{{ $user->updated_at->format('d M Y, H:i') }}</p>
            </div>
        </div>

        <!-- Statistik -->
        <div class="border-t border-gray-200 px-6 py-6 bg-gray-50">
            <h3 class="text-sm font-semibold text-gray-700 mb-4">Statistik Aktivitas</h3>
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                <div class="bg-white p-4 rounded-lg border border-gray-200">
                    <p class="text-xs text-gray-500">Laporan Hilang</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $user->reported_items_count }}</p>
                </div>
                <div class="bg-white p-4 rounded-lg border border-gray-200">
                    <p class="text-xs text-gray-500">Barang Ditemukan</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $user->found_items_count }}</p>
                </div>
                <div class="bg-white p-4 rounded-lg border border-gray-200">
                    <p class="text-xs text-gray-500">Klaim Diajukan</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $user->claims_count }}</p>
                </div>
                <div class="bg-white p-4 rounded-lg border border-gray-200">
                    <p class="text-xs text-gray-500">Notifikasi</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $user->notifications_count }}</p>
                </div>
            </div>
        </div>

        <!-- Actions -->
        <div class="border-t border-gray-200 px-6 py-4 bg-white flex justify-end space-x-3">
            <a href="{{ route('users.edit', $user) }}" class="px-4 py-2 bg-yellow-500 text-white rounded-lg hover:bg-yellow-600 transition">
                Edit User
            </a>
            <form method="POST" action="{{ route('users.destroy', $user) }}" onsubmit="return confirm('Yakin ingin menghapus user ini?')">
                @csrf
                @method('DELETE')
                <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition">
                    Hapus User
                </button>
            </form>
        </div>
    </div>
</div>
@endsection
