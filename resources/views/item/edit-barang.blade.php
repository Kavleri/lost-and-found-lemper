@extends('main-layouts.main')

@section('title', 'Edit Barang - ' . $item->name)

@section('content')
    <div class="min-h-screen bg-gray-50 pb-24">
        <!-- Header -->
        <div class="bg-white shadow-sm border-b border-gray-200">
            <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
                <a href="{{ route('items.show', $item) }}"
                    class="inline-flex items-center text-sm text-gray-600 hover:text-blue-600 mb-2">
                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                    </svg>
                    Kembali ke Detail
                </a>
                <h1 class="text-2xl font-bold text-gray-900">Edit Barang</h1>
                <p class="text-sm text-gray-600 mt-1">Perbarui informasi barang dengan kode: <span
                        class="font-mono font-bold">{{ $item->item_code }}</span></p>
            </div>
        </div>

        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <form action="{{ route('items.update', $item) }}" method="POST" enctype="multipart/form-data"
                class="space-y-6">
                @csrf
                @method('PUT')

                <!-- Informasi Dasar -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4 border-b pb-2">Informasi Dasar</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Nama Barang <span
                                    class="text-red-500">*</span></label>
                            <input type="text" name="name" value="{{ old('name', $item->name) }}" required
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 @error('name') border-red-500 @enderror">
                            @error('name')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Kategori <span
                                    class="text-red-500">*</span></label>
                            <select name="category_id" required
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 @error('category_id') border-red-500 @enderror">
                                <option value="">Pilih Kategori</option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}"
                                        {{ old('category_id', $item->category_id) == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('category_id')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Status Laporan <span
                                    class="text-red-500">*</span></label>
                            <select name="status" id="statusSelect" required
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 @error('status') border-red-500 @enderror">
                                <option value="hilang" {{ old('status', $item->status) == 'hilang' ? 'selected' : '' }}>
                                    Barang Hilang</option>
                                <option value="ditemukan"
                                    {{ old('status', $item->status) == 'ditemukan' ? 'selected' : '' }}>Barang Ditemukan
                                </option>
                                <option value="diklaim" {{ old('status', $item->status) == 'diklaim' ? 'selected' : '' }}
                                    disabled>Sedang Diklaim (Tidak bisa diubah)</option>
                                <option value="selesai" {{ old('status', $item->status) == 'selesai' ? 'selected' : '' }}
                                    disabled>Selesai (Tidak bisa diubah)</option>
                            </select>
                            @error('status')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Detail & Lokasi -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4 border-b pb-2">Detail & Lokasi</h3>

                    <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Deskripsi Barang <span
                                class="text-red-500">*</span></label>
                        <textarea name="description" rows="4" required
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 @error('description') border-red-500 @enderror">{{ old('description', $item->description) }}</textarea>
                        @error('description')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div id="field-lokasi-ditemukan" class="hidden">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Lokasi Ditemukan</label>
                            <input type="text" name="location_found"
                                value="{{ old('location_found', $item->location_found) }}"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                        </div>

                        <div id="field-lokasi-hilang">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Lokasi Terakhir Dilihat</label>
                            <input type="text" name="location_lost"
                                value="{{ old('location_lost', $item->location_lost) }}"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                        </div>

                        <div id="field-tanggal-ditemukan" class="hidden">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal Ditemukan</label>
                            <input type="date" name="date_found"
                                value="{{ old('date_found', $item->date_found?->format('Y-m-d')) }}"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                        </div>

                        <div id="field-tanggal-hilang">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal Hilang</label>
                            <input type="date" name="date_lost"
                                value="{{ old('date_lost', $item->date_lost?->format('Y-m-d')) }}"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                        </div>

                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Lokasi Penyerahan Barang</label>
                            <input type="text" name="drop_off_location"
                                value="{{ old('drop_off_location', $item->drop_off_location) }}"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                        </div>
                    </div>
                </div>

                <!-- Unggah Foto (Existing + New) -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4 border-b pb-2">Foto Barang</h3>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        @for ($i = 1; $i <= 3; $i++)
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Foto
                                    {{ $i }}</label>

                                @if ($item->{'image' . $i})
                                    <div class="mb-2 relative">
                                        <img src="{{ asset('storage/' . $item->{'image' . $i}) }}"
                                            class="w-full h-32 object-cover rounded-lg border border-gray-200">
                                        <span
                                            class="absolute top-1 right-1 bg-green-500 text-white text-xs px-2 py-0.5 rounded">Saat
                                            ini</span>
                                    </div>
                                    <p class="text-xs text-gray-500 mb-2">Kosongkan jika tidak ingin mengganti.</p>
                                @else
                                    <div
                                        class="mb-2 w-full h-32 bg-gray-100 rounded-lg border-2 border-dashed border-gray-300 flex items-center justify-center">
                                        <span class="text-gray-400 text-sm">Belum ada foto</span>
                                    </div>
                                @endif

                                <input type="file" name="image{{ $i }}" accept="image/*"
                                    class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                            </div>
                        @endfor
                    </div>
                </div>

                <!-- Ciri Tersembunyi -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4 border-b pb-2">Ciri Tersembunyi (Rahasia)</h3>
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Detail Ciri Khusus</label>
                        <textarea name="hidden_details" rows="3"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">{{ old('hidden_details', $item->hidden_details) }}</textarea>
                    </div>
                    <div class="flex items-center">
                        <input type="checkbox" name="is_confidential" value="1"
                            {{ old('is_confidential', $item->is_confidential) ? 'checked' : '' }}
                            class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                        <label class="ml-2 text-sm text-gray-700">Sembunyikan detail ini dari tampilan publik</label>
                    </div>
                </div>

                <!-- Tombol Aksi -->
                <div class="flex items-center justify-end space-x-4">
                    <a href="{{ route('items.show', $item) }}"
                        class="px-6 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition">
                        Batal
                    </a>
                    <button type="submit"
                        class="px-6 py-2 bg-blue-600 text-white font-semibold rounded-lg hover:bg-blue-700 transition shadow-sm">
                        Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        document.getElementById('statusSelect').addEventListener('change', function() {
            const status = this.value;
            const foundFields = ['field-lokasi-ditemukan', 'field-tanggal-ditemukan'];
            const lostFields = ['field-lokasi-hilang', 'field-tanggal-hilang'];

            if (status === 'ditemukan') {
                foundFields.forEach(id => document.getElementById(id).classList.remove('hidden'));
                lostFields.forEach(id => document.getElementById(id).classList.add('hidden'));
            } else {
                foundFields.forEach(id => document.getElementById(id).classList.add('hidden'));
                lostFields.forEach(id => document.getElementById(id).classList.remove('hidden'));
            }
        });

        document.getElementById('statusSelect').dispatchEvent(new Event('change'));
    </script>
@endsection
