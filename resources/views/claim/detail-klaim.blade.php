@extends('main-layouts.main')

@section('title', 'Detail Klaim - Campus Lost & Found')

@section('content')
<div class="min-h-screen bg-gray-50 pb-24">
    <!-- Header -->
    <div class="bg-white shadow-sm border-b border-gray-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6 flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">Detail Klaim Barang</h1>
                <p class="mt-1 text-sm text-gray-600">ID Klaim: #LF-{{ str_pad($claim->id, 5, '0', STR_PAD_LEFT) }}</p>
            </div>
            <a href="{{ route('claims.index') }}" class="flex items-center space-x-2 px-4 py-2 text-gray-700 border border-gray-300 rounded-lg hover:bg-gray-50 transition">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                <span>Kembali ke Daftar</span>
            </a>
        </div>
    </div>

    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        @if(session('success'))
            <div class="bg-green-50 border-l-4 border-green-400 p-4 mb-6 rounded-r-lg">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg class="h-5 h-5 text-green-400" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                        </svg>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm font-medium text-green-800">{{ session('success') }}</p>
                    </div>
                </div>
            </div>
        @endif

        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 mb-8">
            <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between mb-8 pb-6 border-b border-gray-100">
                <div class="flex items-start space-x-4">
                    <img src="{{ $claim->item->image1 ? asset('storage/' . $claim->item->image1) : 'https://via.placeholder.com/150' }}"
                         alt="{{ $claim->item->name }}" class="w-32 h-32 object-cover rounded-lg border border-gray-100">
                    <div>
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800 uppercase">
                            {{ $claim->item->category->name }}
                        </span>
                        <h2 class="text-xl font-bold text-gray-900 mt-2">{{ $claim->item->name }}</h2>
                        <p class="text-sm text-gray-500 mt-1">Dilaporkan pada: {{ $claim->created_at->format('d M Y H:i') }}</p>
                    </div>
                </div>
                <div class="mt-4 lg:mt-0">
                    @php
                        $statusColors = [
                            'pending' => 'bg-yellow-100 text-yellow-800',
                            'verified' => 'bg-blue-100 text-blue-800',
                            'rejected' => 'bg-red-100 text-red-800',
                            'approved' => 'bg-green-100 text-green-800',
                        ];
                        $statusLabels = [
                            'pending' => 'MENUNGGU VERIFIKASI',
                            'verified' => 'TERVERIFIKASI',
                            'rejected' => 'DITOLAK',
                            'approved' => 'SIAP DIAMBIL',
                        ];
                    @endphp
                    <span class="inline-flex items-center px-4 py-2 rounded-full text-sm font-bold {{ $statusColors[$claim->status] ?? 'bg-gray-100 text-gray-800' }}">
                        {{ $statusLabels[$claim->status] ?? strtoupper($claim->status) }}
                    </span>
                </div>
            </div>

            <!-- Timeline Status -->
            <div class="mb-8">
                <h3 class="text-lg font-bold text-gray-900 mb-4">Lacak Status Pengembalian</h3>
                <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between space-y-4 sm:space-y-0 px-2">
                    @php
                        $steps = ['Diajukan', 'Verifikasi', 'Siap Diambil', 'Selesai'];
                        $currentStep = match($claim->status) {
                            'pending' => 1,
                            'verified' => 2,
                            'approved' => 3,
                            'rejected' => 0,
                            default => 4
                        };
                    @endphp
                    
                    @if($claim->status === 'rejected')
                        <div class="w-full bg-red-50 border border-red-200 rounded-lg p-4 flex items-start space-x-3">
                            <svg class="w-6 h-6 text-red-600 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                            <div>
                                <h4 class="text-sm font-bold text-red-800">Klaim Anda Ditolak</h4>
                                <p class="text-xs text-red-700 mt-1">Alasan: {{ $claim->rejection_reason ?? 'Bukti kepemilikan yang diajukan tidak cocok.' }}</p>
                            </div>
                        </div>
                    @else
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
                                    <div class="hidden sm:block w-16 h-1 mx-2 {{ $index < $currentStep - 1 ? 'bg-green-500' : 'bg-gray-300' }}"></div>
                                @endif
                            </div>
                        @endforeach
                    @endif
                </div>
            </div>

            <!-- Detail Laporan & Bukti Kepemilikan -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 border-t border-gray-100 pt-8">
                <div>
                    <h3 class="text-lg font-bold text-gray-900 mb-4">Informasi Barang</h3>
                    <div class="space-y-3 text-sm">
                        <div>
                            <span class="text-gray-500 block">Deskripsi Barang:</span>
                            <span class="text-gray-900 font-medium">{{ $claim->item->description }}</span>
                        </div>
                        <div>
                            <span class="text-gray-500 block">Lokasi Ditemukan:</span>
                            <span class="text-gray-900 font-medium">{{ $claim->item->location_found ?? $claim->item->location_lost }}</span>
                        </div>
                    </div>
                </div>
                <div>
                    <h3 class="text-lg font-bold text-gray-900 mb-4">Bukti Kepemilikan Anda</h3>
                    <div class="space-y-3 text-sm">
                        <div>
                            <span class="text-gray-500 block">Mengapa ini barang Anda:</span>
                            <span class="text-gray-900 font-medium">{{ $claim->description }}</span>
                        </div>
                        @if($claim->proof_details)
                            <div>
                                <span class="text-gray-500 block">Detail Bukti (Ciri Khusus):</span>
                                <span class="text-gray-900 font-medium">{{ $claim->proof_details }}</span>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- QR Code Section & Handover Details for Approved Claim -->
            @if($claim->status === 'approved')
                <div class="mt-8 border-t border-gray-100 pt-8 flex flex-col items-center justify-center text-center">
                    <h3 class="text-lg font-bold text-gray-900 mb-2">QR Code Pengambilan Barang</h3>
                    <p class="text-sm text-gray-600 mb-6 max-w-md">Tunjukkan QR Code ini kepada Petugas/Satpam di lokasi untuk memverifikasi pengambilan barang secara fisik.</p>
                    
                    <div class="bg-white p-4 border-2 border-gray-200 rounded-xl shadow-inner mb-4">
                        <img src="https://api.qrserver.com/v1/create-qr-code/?size=180x180&data={{ urlencode(route('claims.show', $claim)) }}" 
                             alt="QR Code Klaim" class="w-44 h-44">
                    </div>
                    <span class="text-xs text-gray-400 font-mono">CODE: LF-{{ str_pad($claim->id, 5, '0', STR_PAD_LEFT) }}-{{ $claim->item_id }}</span>
                    
                    <div class="mt-6 p-4 bg-blue-50 border border-blue-100 rounded-lg max-w-lg w-full flex items-center space-x-3 text-left">
                        <svg class="w-6 h-6 text-blue-600 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                        <div>
                            <h4 class="text-sm font-bold text-blue-800">Lokasi Pengambilan Barang:</h4>
                            <p class="text-xs text-blue-700 mt-0.5">{{ $claim->item->drop_off_location ?? 'Layanan Pos Keamanan Utama' }}</p>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Form Upload Bukti Tambahan for Pending Claim -->
            @if($claim->status === 'pending')
                <div class="mt-8 border-t border-gray-100 pt-8">
                    <h3 class="text-lg font-bold text-gray-900 mb-2">Unggah Bukti Tambahan</h3>
                    <p class="text-sm text-gray-600 mb-6">Jika admin membutuhkan verifikasi lebih lanjut, Anda dapat mengunggah file bukti tambahan di bawah ini.</p>
                    
                    <form method="POST" action="{{ route('claims.uploadBukti', $claim) }}" enctype="multipart/form-data" class="max-w-md">
                        @csrf
                        @method('PUT')
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 mb-1">File Bukti (JPG, PNG, atau PDF, Maks 2MB)</label>
                            <input type="file" name="bukti_tambahan" required 
                                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm">
                        </div>
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Catatan Tambahan (Opsional)</label>
                            <textarea name="catatan" rows="3" placeholder="Masukkan deskripsi tambahan dari file bukti yang Anda unggah..."
                                      class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm"></textarea>
                        </div>
                        <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition text-sm font-semibold">
                            Kirim Bukti Tambahan
                        </button>
                    </form>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
