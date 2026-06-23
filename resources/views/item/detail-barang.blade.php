@extends('main-layouts.main')

@section('title', 'Detail Barang - ' . $item->name)

@section('content')
<div class="min-h-screen bg-gray-50 pb-24">
    <!-- Breadcrumb -->
    <div class="bg-gradient-to-r from-[#0c3e2b] via-[#0f4d36] to-[#072419] text-white shadow-md relative overflow-hidden">
        <!-- Decorative soft glowing light -->
        <div class="absolute -top-20 -right-20 w-48 h-48 bg-amber-500/10 rounded-full blur-2xl pointer-events-none"></div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6 relative z-10">
            <a href="{{ route('items.index') }}" class="inline-flex items-center text-sm text-emerald-100 hover:text-amber-400 transition mb-2">
                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                </svg>
                Kembali ke Pencarian
            </a>
            <h1 class="text-xl md:text-2xl font-extrabold tracking-tight">Detail Barang #{{ $item->item_code }}</h1>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

            <!-- KOLOM KIRI: Gambar & Info Utama -->
            <div class="lg:col-span-2 space-y-6">

                <!-- Image Gallery -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                    <div class="relative">
                        <img src="{{ $item->image1 ? asset('storage/' . $item->image1) : 'https://via.placeholder.com/800x400?text=Tidak+Ada+Foto' }}"
                             alt="{{ $item->name }}"
                             class="w-full h-64 sm:h-96 object-cover">

                        <span class="absolute top-4 left-4 px-3 py-1 rounded-full text-xs font-bold
                            {{ $item->status === 'ditemukan' ? 'bg-green-500 text-white' :
                               ($item->status === 'hilang' ? 'bg-red-500 text-white' : 'bg-yellow-500 text-white') }}">
                            {{ strtoupper($item->status === 'ditemukan' ? 'BARANG DITEMUKAN' : ($item->status === 'hilang' ? 'BARANG HILANG' : $item->status)) }}
                        </span>
                    </div>

                    @if($item->image2 || $item->image3)
                        <div class="flex space-x-2 p-4 overflow-x-auto">
                            @foreach([$item->image1, $item->image2, $item->image3] as $img)
                                @if($img)
                                    <img src="{{ asset('storage/' . $img) }}"
                                         class="w-20 h-20 object-cover rounded-lg border-2 border-gray-200 hover:border-blue-500 cursor-pointer transition">
                                @endif
                            @endforeach
                        </div>
                    @endif
                </div>

                <!-- Info Utama -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                    <div class="flex flex-col sm:flex-row sm:items-start sm:justify-between gap-4 mb-4">
                        <div class="flex-1">
                            <h2 class="text-2xl font-bold text-gray-900">{{ $item->name }}</h2>
                            <div class="flex flex-wrap items-center gap-4 mt-2 text-sm text-gray-600">
                                @if($item->date_found)
                                    <span class="flex items-center">
                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                        </svg>
                                        Ditemukan: {{ $item->date_found->format('d M Y') }}
                                    </span>
                                @endif
                                @if($item->location_found)
                                    <span class="flex items-center">
                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                        </svg>
                                        {{ $item->location_found }}
                                    </span>
                                @endif
                            </div>
                        </div>

                        <!-- Tombol Edit/Hapus (hanya untuk pemilik) -->
                        @if(auth()->id() === $item->reporter_id)
                            <div class="flex space-x-2">
                                <a href="{{ route('items.edit', $item) }}" class="px-4 py-2 bg-yellow-500 text-white rounded-lg hover:bg-yellow-600 transition text-sm font-medium">
                                    Edit
                                </a>
                                <form method="POST" action="{{ route('items.destroy', $item) }}" onsubmit="return confirm('Yakin ingin menghapus?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition text-sm font-medium">
                                        Hapus
                                    </button>
                                </form>
                            </div>
                        @endif
                    </div>

                    <!--  TOMBOL AJUKAN KLAIM (PENTING!) -->
                    @if(auth()->id() !== $item->reporter_id && $item->status === 'ditemukan' && !isset($userClaim))
                        <button onclick="document.getElementById('claimModal').classList.remove('hidden')"
                                class="w-full sm:w-auto px-6 py-3 bg-blue-600 text-white font-semibold rounded-lg hover:bg-blue-700 transition shadow-sm flex items-center justify-center">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                            </svg>
                            Ajukan Klaim
                        </button>
                    @elseif(isset($userClaim) && $userClaim)
                        <div class="inline-flex items-center px-4 py-2 bg-yellow-100 text-yellow-800 rounded-lg text-sm font-medium">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            Status Klaim Anda: <strong class="ml-1">{{ ucfirst($userClaim->status) }}</strong>
                        </div>
                    @elseif(auth()->id() === $item->reporter_id)
                        <div class="inline-flex items-center px-4 py-2 bg-gray-100 text-gray-700 rounded-lg text-sm font-medium">
                            Ini adalah barang yang Anda laporkan
                        </div>
                    @elseif($item->status !== 'ditemukan')
                        <div class="inline-flex items-center px-4 py-2 bg-gray-100 text-gray-700 rounded-lg text-sm font-medium">
                            Barang ini tidak dapat diklaim saat ini
                        </div>
                    @endif
                </div>

                <!-- Detail Spesifikasi -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                    <h3 class="text-lg font-bold text-gray-900 mb-4">Detail Barang</h3>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div class="p-4 bg-gray-50 rounded-lg">
                            <p class="text-xs font-semibold text-gray-500 uppercase mb-1">Kategori</p>
                            <p class="text-sm font-medium text-gray-900">{{ $item->category->name ?? '-' }}</p>
                        </div>
                        <div class="p-4 bg-gray-50 rounded-lg">
                            <p class="text-xs font-semibold text-gray-500 uppercase mb-1">Kode Barang</p>
                            <p class="text-sm font-medium text-gray-900 font-mono">{{ $item->item_code }}</p>
                        </div>
                        @if($item->location_found)
                            <div class="p-4 bg-gray-50 rounded-lg">
                                <p class="text-xs font-semibold text-gray-500 uppercase mb-1">Lokasi Ditemukan</p>
                                <p class="text-sm font-medium text-gray-900">{{ $item->location_found }}</p>
                            </div>
                        @endif
                        @if($item->date_found)
                            <div class="p-4 bg-gray-50 rounded-lg">
                                <p class="text-xs font-semibold text-gray-500 uppercase mb-1">Tanggal Ditemukan</p>
                                <p class="text-sm font-medium text-gray-900">{{ $item->date_found->format('d M Y') }}</p>
                            </div>
                        @endif
                    </div>

                    <div class="mt-6">
                        <h4 class="text-sm font-semibold text-gray-700 mb-2">Deskripsi Detail</h4>
                        <p class="text-sm text-gray-600 leading-relaxed whitespace-pre-line">{{ $item->description }}</p>
                    </div>

                    <!-- Catatan Penting (hanya admin/satpam) -->
                    @if($item->is_confidential && $item->hidden_details && in_array(auth()->user()->role, ['admin', 'satpam']))
                        <div class="mt-6 p-4 bg-amber-50 border-l-4 border-amber-400 rounded-r-lg">
                            <div class="flex items-start">
                                <svg class="w-5 h-5 text-amber-600 mr-2 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                <div>
                                    <p class="text-sm font-semibold text-amber-900">Catatan Penting (Hanya Admin/Satpam)</p>
                                    <p class="text-sm text-amber-800 mt-1">{{ $item->hidden_details }}</p>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>

                <!-- Informasi Pelapor -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                    <h3 class="text-lg font-bold text-gray-900 mb-4">Dilaporkan Oleh</h3>
                    <div class="flex items-center space-x-4">
                        <div class="w-14 h-14 rounded-full bg-gradient-to-br from-blue-400 to-blue-600 flex items-center justify-center text-white font-bold text-lg">
                            {{ substr($item->reporter->name ?? 'U', 0, 2) }}
                        </div>
                        <div class="flex-1">
                            <p class="font-semibold text-gray-900">{{ $item->reporter->name ?? 'Anonymous' }}</p>
                            <p class="text-sm text-gray-600">{{ $item->reporter->department ?? 'Mahasiswa' }}</p>
                            @if($item->reporter && $item->reporter->is_verified)
                                <span class="inline-flex items-center mt-1 text-xs text-green-600 font-medium">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                                    </svg>
                                    Verified Account
                                </span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- KOLOM KANAN: Sidebar -->
            <div class="space-y-6">

                <!-- CTA Klaim (Hanya muncul jika barang ditemukan & bukan milik sendiri) -->
                @if(auth()->id() !== $item->reporter_id && $item->status === 'ditemukan' && !isset($userClaim))
                    <div class="bg-gradient-to-br from-blue-600 to-blue-700 rounded-xl shadow-lg p-6 text-white sticky top-24">
                        <h3 class="text-lg font-bold mb-2">Ini Milik Anda?</h3>
                        <p class="text-sm text-blue-100 mb-4">Proses verifikasi biasanya memakan waktu 1-2 hari kerja setelah pengajuan klaim.</p>
                        <button onclick="document.getElementById('claimModal').classList.remove('hidden')"
                                class="w-full px-4 py-3 bg-white text-blue-600 font-semibold rounded-lg hover:bg-blue-50 transition flex items-center justify-center">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 11.5V14m0-2.5v-6a1.5 1.5 0 113 0m-3 6a1.5 1.5 0 00-3 0v2a7.5 7.5 0 0015 0v-5a1.5 1.5 0 00-3 0m-6-3V11m0-5.5v-1a1.5 1.5 0 013 0v1m0 0V11m0-5.5a1.5 1.5 0 013 0v3m0 0V11"/>
                            </svg>
                            Ajukan Klaim Sekarang
                        </button>
                    </div>
                @endif

                <!-- Panduan Klaim -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                    <h3 class="text-lg font-bold text-gray-900 mb-4 flex items-center">
                        <svg class="w-5 h-5 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        Panduan Klaim
                    </h3>
                    <ul class="space-y-3 text-sm text-gray-600">
                        <li class="flex items-start">
                            <span class="flex-shrink-0 w-5 h-5 bg-blue-100 text-blue-600 rounded-full flex items-center justify-center text-xs font-bold mr-2 mt-0.5">1</span>
                            Siapkan identitas diri (KTM/KTP)
                        </li>
                        <li class="flex items-start">
                            <span class="flex-shrink-0 w-5 h-5 bg-blue-100 text-blue-600 rounded-full flex items-center justify-center text-xs font-bold mr-2 mt-0.5">2</span>
                            Wajib mendeskripsikan ciri khusus barang
                        </li>
                        <li class="flex items-start">
                            <span class="flex-shrink-0 w-5 h-5 bg-blue-100 text-blue-600 rounded-full flex items-center justify-center text-xs font-bold mr-2 mt-0.5">3</span>
                            Tunjukkan bukti pembelian atau foto lama
                        </li>
                        <li class="flex items-start">
                            <span class="flex-shrink-0 w-5 h-5 bg-red-100 text-red-600 rounded-full flex items-center justify-center text-xs font-bold mr-2 mt-0.5">!</span>
                            <span class="text-red-600 font-medium">Klaim palsu dapat dikenakan sanksi disiplin kampus</span>
                        </li>
                    </ul>
                </div>

                <!-- Barang Serupa -->
                @if(isset($similarItems) && $similarItems->count() > 0)
                    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                        <div class="flex items-center justify-between mb-4">
                            <h3 class="text-lg font-bold text-gray-900">Barang Serupa</h3>
                            <a href="{{ route('items.index', ['category' => $item->category_id]) }}" class="text-sm text-blue-600 hover:text-blue-800">Lihat Semua</a>
                        </div>
                        <div class="space-y-3">
                            @foreach($similarItems as $similar)
                                <a href="{{ route('items.show', $similar) }}" class="flex items-center space-x-3 p-3 rounded-lg hover:bg-gray-50 transition border border-gray-100">
                                    <img src="{{ $similar->image1 ? asset('storage/' . $similar->image1) : 'https://via.placeholder.com/60' }}"
                                         class="w-16 h-16 object-cover rounded-lg flex-shrink-0">
                                    <div class="flex-1 min-w-0">
                                        <p class="text-sm font-semibold text-gray-900 truncate">{{ $similar->name }}</p>
                                        <p class="text-xs text-gray-500 truncate">{{ $similar->location_found }}</p>
                                        <p class="text-xs text-gray-400 mt-1">{{ $similar->created_at->diffForHumans() }}</p>
                                    </div>
                                </a>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- 🔥 MODAL AJUKAN KLAIM -->
    @if(auth()->id() !== $item->reporter_id && $item->status === 'ditemukan' && !isset($userClaim))
        <div id="claimModal" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center p-4">
            <div class="bg-white rounded-xl shadow-2xl max-w-2xl w-full max-h-[90vh] overflow-y-auto">
                <div class="sticky top-0 bg-white border-b border-gray-200 px-6 py-4 flex items-center justify-between rounded-t-xl">
                    <h3 class="text-lg font-bold text-gray-900">Ajukan Klaim Barang</h3>
                    <button onclick="document.getElementById('claimModal').classList.add('hidden')" class="text-gray-400 hover:text-gray-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>

                <form method="POST" action="{{ route('items.claim', $item) }}" class="p-6 space-y-4">
                    @csrf

                    <!-- Info Barang -->
                    <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 flex items-center space-x-3">
                        <img src="{{ $item->image1 ? asset('storage/' . $item->image1) : 'https://via.placeholder.com/60' }}"
                             class="w-16 h-16 object-cover rounded-lg">
                        <div>
                            <p class="font-semibold text-gray-900">{{ $item->name }}</p>
                            <p class="text-sm text-gray-600">{{ $item->item_code }}</p>
                        </div>
                    </div>

                    <!-- Deskripsi Klaim -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            Deskripsi Klaim <span class="text-red-500">*</span>
                        </label>
                        <textarea name="description" rows="3" required
                                  class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 @error('description') border-red-500 @enderror"
                                  placeholder="Jelaskan mengapa Anda yakin barang ini milik Anda...">{{ old('description') }}</textarea>
                        @error('description') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>

                    <!-- Bukti Kepemilikan (Ciri Tersembunyi) -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            Bukti Kepemilikan (Ciri Tersembunyi) <span class="text-red-500">*</span>
                        </label>
                        <textarea name="proof_details" rows="4" required
                                  class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 @error('proof_details') border-red-500 @enderror"
                                  placeholder="Sebutkan ciri-ciri khusus yang hanya pemilik asli yang tahu (goresan, stiker, wallpaper, dll)...">{{ old('proof_details') }}</textarea>
                        @error('proof_details') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                        <p class="mt-1 text-xs text-gray-500"> Informasi ini hanya akan dilihat oleh admin/satpam untuk verifikasi.</p>
                    </div>

                    <!-- Warning -->
                    <div class="bg-amber-50 border-l-4 border-amber-400 p-4 rounded-r-lg">
                        <p class="text-sm text-amber-800">
                            <strong>Perhatian:</strong> Pengajuan klaim palsu akan dikenakan sanksi disiplin sesuai peraturan kampus.
                        </p>
                    </div>

                    <!-- Buttons -->
                    <div class="flex items-center justify-end space-x-3 pt-4 border-t border-gray-200">
                        <button type="button" onclick="document.getElementById('claimModal').classList.add('hidden')"
                                class="px-6 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition">
                            Batal
                        </button>
                        <button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition shadow-sm">
                            Kirim Klaim
                        </button>
                    </div>
                </form>
            </div>
        </div>
    @endif
</div>
@endsection
