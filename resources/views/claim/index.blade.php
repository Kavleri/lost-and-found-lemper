@extends('main-layouts.main')

@section('title', 'Klaim Saya - Campus Lost & Found')

@section('content')
<div class="min-h-screen bg-gray-50 pb-24">
    <!-- Header -->
    <div class="bg-white shadow-sm border-b border-gray-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
            <h1 class="text-2xl font-bold text-gray-900">Status Klaim Saya</h1>
            <p class="mt-1 text-sm text-gray-600">Pantau proses verifikasi dan pengambilan barang yang telah Anda klaim.</p>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

        <!-- Statistik Cards -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">Dalam Proses</p>
                    <p class="text-3xl font-bold text-gray-900 mt-2">{{ $stats['proses'] }}</p>
                </div>
                <div class="p-3 bg-yellow-100 rounded-lg">
                    <svg class="w-8 h-8 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
            </div>
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">Selesai</p>
                    <p class="text-3xl font-bold text-gray-900 mt-2">{{ $stats['selesai'] }}</p>
                </div>
                <div class="p-3 bg-green-100 rounded-lg">
                    <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
            </div>
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">Total Klaim</p>
                    <p class="text-3xl font-bold text-gray-900 mt-2">{{ $stats['total'] }}</p>
                </div>
                <div class="p-3 bg-blue-100 rounded-lg">
                    <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/></svg>
                </div>
            </div>
        </div>

        <!-- Daftar Klaim Aktif -->
        <div class="mb-8">
            <div class="flex items-center justify-between mb-6">
                <h3 class="text-xl font-bold text-gray-900">Daftar Klaim Aktif</h3>
            </div>

            @forelse($activeClaims as $claim)
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 mb-4">
                    <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between mb-4">
                        <div class="flex items-start space-x-4">
                            <img src="{{ $claim->item->image1 ? asset('storage/' . $claim->item->image1) : 'https://via.placeholder.com/100' }}"
                                 alt="{{ $claim->item->name }}" class="w-24 h-24 object-cover rounded-lg">
                            <div>
                                <p class="text-sm text-gray-500 font-medium">ID Klaim: #LF-{{ str_pad($claim->id, 5, '0', STR_PAD_LEFT) }}</p>
                                <h4 class="text-lg font-bold text-gray-900 mt-1">{{ $claim->item->name }}</h4>
                                <div class="flex items-center space-x-2 mt-2 text-sm text-gray-600">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                    <span>Diklaim pada {{ $claim->created_at->format('d M Y') }}</span>
                                </div>
                            </div>
                        </div>
                        <div class="mt-4 lg:mt-0">
                            @php
                                $statusColors = [
                                    'pending' => 'bg-yellow-100 text-yellow-800',
                                    'verified' => 'bg-blue-100 text-blue-800',
                                    'approved' => 'bg-green-100 text-green-800',
                                ];
                                $statusLabels = [
                                    'pending' => 'VERIFIKASI',
                                    'verified' => 'VERIFIKASI',
                                    'approved' => 'SIAP DIAMBIL',
                                ];
                            @endphp
                            <span class="inline-flex items-center px-4 py-2 rounded-full text-sm font-semibold {{ $statusColors[$claim->status] }}">
                                {{ $statusLabels[$claim->status] }}
                            </span>
                        </div>
                    </div>

                    <!-- Timeline -->
                    <div class="flex items-center justify-between mb-6 px-2">
                        @php
                            $steps = ['Diajukan', 'Verifikasi', 'Siap Diambil', 'Selesai'];
                            $currentStep = match($claim->status) {
                                'pending' => 1,
                                'verified' => 2,
                                'approved' => 3,
                                default => 4
                            };
                        @endphp
                        @foreach($steps as $index => $step)
                            <div class="flex items-center space-x-2">
                                <div class="w-8 h-8 rounded-full flex items-center justify-center
                                    {{ $index < $currentStep ? 'bg-green-500' : ($index == $currentStep - 1 ? 'bg-blue-500 animate-pulse' : 'bg-gray-300') }}">
                                    @if($index < $currentStep)
                                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                    @else
                                        <span class="text-xs text-white font-bold">{{ $index + 1 }}</span>
                                    @endif
                                </div>
                                <span class="text-sm font-medium {{ $index < $currentStep ? 'text-gray-900' : 'text-gray-500' }}">{{ $step }}</span>
                                @if(!$loop->last)
                                    <div class="w-16 h-1 mx-2 {{ $index < $currentStep - 1 ? 'bg-green-500' : 'bg-gray-300' }}"></div>
                                @endif
                            </div>
                        @endforeach
                    </div>

                    <!-- Actions -->
                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between space-y-3 sm:space-y-0 border-t border-gray-100 pt-4">
                        <div class="flex items-center space-x-3">
                            @if($claim->status === 'approved')
                                <a href="{{ route('claims.show', $claim) }}" class="flex items-center space-x-2 px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z"/></svg>
                                    <span>Tampilkan QR Code</span>
                                </a>
                            @elseif($claim->status === 'pending')
                                <button onclick="document.getElementById('uploadModal-{{ $claim->id }}').classList.remove('hidden')" class="flex items-center space-x-2 px-4 py-2 text-blue-600 border border-blue-600 rounded-lg hover:bg-blue-50 transition">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                    <span>Unggah Bukti Tambahan</span>
                                </button>
                            @endif
                            <a href="{{ route('items.show', $claim->item) }}" class="px-4 py-2 text-gray-700 border border-gray-300 rounded-lg hover:bg-gray-50 transition">Detail Barang</a>
                        </div>

                        @if($claim->status === 'approved')
                            <div class="flex items-center space-x-2 text-sm text-gray-600 bg-gray-50 px-4 py-2 rounded-lg">
                                <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                <span>Lokasi: {{ $claim->item->drop_off_location ?? 'Pusat Keamanan Kampus' }}</span>
                            </div>
                        @elseif($claim->status === 'pending')
                            <div class="flex items-center space-x-2 text-sm text-blue-700 bg-blue-50 px-4 py-2 rounded-lg">
                                <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                <span>Admin sedang meninjau. Mohon tunggu 1-2 hari kerja.</span>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Modal Upload Bukti (Per Claim) -->
                <div id="uploadModal-{{ $claim->id }}" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center p-4">
                    <div class="bg-white rounded-xl shadow-2xl max-w-md w-full p-6">
                        <h3 class="text-lg font-bold text-gray-900 mb-4">Unggah Bukti Tambahan</h3>
                        <form method="POST" action="{{ route('claims.uploadBukti', $claim) }}" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="mb-4">
                                <label class="block text-sm font-medium text-gray-700 mb-1">File Bukti (JPG/PNG/PDF, Max 2MB)</label>
                                <input type="file" name="bukti_tambahan" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                            </div>
                            <div class="mb-4">
                                <label class="block text-sm font-medium text-gray-700 mb-1">Catatan (Opsional)</label>
                                <textarea name="catatan" rows="3" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500"></textarea>
                            </div>
                            <div class="flex justify-end space-x-3">
                                <button type="button" onclick="document.getElementById('uploadModal-{{ $claim->id }}').classList.add('hidden')" class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50">Batal</button>
                                <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">Kirim Bukti</button>
                            </div>
                        </form>
                    </div>
                </div>
            @empty
                <div class="bg-white rounded-xl border border-gray-200 p-12 text-center">
                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/></svg>
                    <h3 class="mt-2 text-sm font-medium text-gray-900">Belum Ada Klaim</h3>
                    <p class="mt-1 text-sm text-gray-500">Anda belum mengajukan klaim untuk barang apapun.</p>
                </div>
            @endforelse
        </div>

        <!-- Riwayat Klaim Selesai/Ditolak -->
        @if($historyClaims->count() > 0)
            <div>
                <h3 class="text-xl font-bold text-gray-900 mb-6">Riwayat Klaim</h3>
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Item</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Tanggal</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status Akhir</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach($historyClaims as $claim)
                                    <tr class="hover:bg-gray-50">
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="flex items-center">
                                                <div class="flex-shrink-0 h-10 w-10 bg-gray-200 rounded-lg flex items-center justify-center text-xs font-bold text-gray-600">IMG</div>
                                                <div class="ml-4">
                                                    <div class="text-sm font-medium text-gray-900">{{ $claim->item->name }}</div>
                                                    <div class="text-xs text-gray-500">#LF-{{ str_pad($claim->id, 5, '0', STR_PAD_LEFT) }}</div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">{{ $claim->updated_at->format('d M Y') }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                                Ditolak
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            <a href="{{ route('items.show', $claim->item) }}" class="text-blue-600 hover:text-blue-900">Lihat Barang</a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>
@endsection
