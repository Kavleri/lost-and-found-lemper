@extends('main-layouts.main')

@section('title', 'Tambah User - Admin')

@section('content')
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="mb-6">
            <a href="{{ route('users.index') }}"
                class="inline-flex items-center text-sm text-gray-600 hover:text-blue-600 mb-2">
                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                </svg>
                Kembali ke Daftar User
            </a>
            <h1 class="text-2xl font-bold text-gray-900">Tambah User Baru</h1>
        </div>

        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
            <form method="POST" action="{{ route('users.store') }}">
                @csrf

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Nama -->
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Nama Lengkap <span
                                class="text-red-500">*</span></label>
                        <input type="text" name="name" value="{{ old('name') }}"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 @error('name') border-red-500 @enderror">
                        @error('name')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Email -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Email <span
                                class="text-red-500">*</span></label>
                        <input type="email" name="email" value="{{ old('email') }}"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 @error('email') border-red-500 @enderror">
                        @error('email')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- NIM/NIP -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">NIM / NIP</label>
                        <input type="text" name="nim_nip" value="{{ old('nim_nip') }}"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 @error('nim_nip') border-red-500 @enderror">
                        @error('nim_nip')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Password -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Password <span
                                class="text-red-500">*</span></label>
                        <input type="password" name="password"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 @error('password') border-red-500 @enderror">
                        @error('password')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Konfirmasi Password -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Konfirmasi Password <span
                                class="text-red-500">*</span></label>
                        <input type="password" name="password_confirmation"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                    </div>

                    <!-- Role -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Role <span
                                class="text-red-500">*</span></label>
                        <select name="role"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 @error('role') border-red-500 @enderror">
                            <option value="">Pilih Role</option>
                            <option value="mahasiswa" {{ old('role') == 'mahasiswa' ? 'selected' : '' }}>Mahasiswa</option>
                            <option value="dosen" {{ old('role') == 'dosen' ? 'selected' : '' }}>Dosen</option>
                            <option value="staf" {{ old('role') == 'staf' ? 'selected' : '' }}>Staf</option>
                            <option value="satpam" {{ old('role') == 'satpam' ? 'selected' : '' }}>Satpam</option>
                            <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                        </select>
                        @error('role')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Departemen -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Departemen</label>
                        <input type="text" name="department" value="{{ old('department') }}"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 @error('department') border-red-500 @enderror">
                        @error('department')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Phone -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">No. Telepon</label>
                        <input type="text" name="phone" value="{{ old('phone') }}"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 @error('phone') border-red-500 @enderror">
                        @error('phone')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Verified -->
                    <div class="md:col-span-2">
                        <label class="flex items-center">
                            <input type="checkbox" name="is_verified" value="1"
                                {{ old('is_verified') ? 'checked' : '' }}
                                class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                            <span class="ml-2 text-sm text-gray-700">User sudah terverifikasi</span>
                        </label>
                    </div>
                </div>

                <!-- Buttons -->
                <div class="flex items-center justify-end space-x-3 mt-8 pt-6 border-t border-gray-200">
                    <a href="{{ route('users.index') }}"
                        class="px-6 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition">
                        Batal
                    </a>
                    <button type="submit"
                        class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition shadow-sm">
                        Simpan User
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
