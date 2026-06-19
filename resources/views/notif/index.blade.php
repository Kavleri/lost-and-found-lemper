@extends('main-layouts.main')

@section('title', 'Notifikasi - Campus Lost & Found')

@section('content')
    <div class="min-h-screen bg-gray-50 pb-24">
        <!-- Header -->
        <div class="bg-white shadow-sm border-b border-gray-200">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
                <div class="flex items-center justify-between">
                    <div>
                        <h1 class="text-2xl font-bold text-gray-900">Notifikasi</h1>
                        <p class="text-sm text-gray-600 mt-1">Pantau semua pembaruan tentang barang dan klaim Anda</p>
                    </div>
                    @if ($unreadCount > 0)
                        <form method="POST" action="{{ route('notifications.readAll') }}">
                            @csrf
                            <button type="submit"
                                class="flex items-center space-x-2 px-4 py-2 text-sm font-medium text-blue-600 bg-blue-50 rounded-lg hover:bg-blue-100 transition">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                <span>Tandai semua dibaca</span>
                            </button>
                        </form>
                    @endif
                </div>
            </div>
        </div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <!-- Filter Tabs -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 mb-6">
                <div class="flex border-b border-gray-200">
                    <button onclick="filterNotifications('all')"
                        class="flex-1 px-4 py-3 text-sm font-medium text-blue-600 border-b-2 border-blue-600 hover:bg-gray-50 transition"
                        id="tab-all">
                        <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                        </svg>
                        Semua
                    </button>
                    <button onclick="filterNotifications('unread')"
                        class="flex-1 px-4 py-3 text-sm font-medium text-gray-600 hover:text-blue-600 hover:bg-gray-50 transition"
                        id="tab-unread">
                        <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                        </svg>
                        Belum Dibaca
                        @if ($unreadCount > 0)
                            <span
                                class="ml-2 px-2 py-0.5 text-xs font-bold bg-red-500 text-white rounded-full">{{ $unreadCount }}</span>
                        @endif
                    </button>
                </div>
            </div>

            <!-- Notifications List -->
            <div class="space-y-4">
                @forelse($notifications as $notification)
                    <div class="bg-white rounded-xl shadow-sm border {{ $notification->is_read ? 'border-gray-200' : 'border-blue-300 bg-blue-50' }} p-6 hover:shadow-md transition"
                        data-read="{{ $notification->is_read }}">
                        <div class="flex items-start justify-between">
                            <div class="flex items-start space-x-4 flex-1">
                                <!-- Icon based on notification type -->
                                <div class="flex-shrink-0">
                                    @if (str_contains(strtolower($notification->title), 'klaim'))
                                        <div class="w-12 h-12 rounded-full bg-blue-100 flex items-center justify-center">
                                            <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                            </svg>
                                        </div>
                                    @elseif(str_contains(strtolower($notification->title), 'match') || str_contains(strtolower($notification->title), 'barang'))
                                        <div class="w-12 h-12 rounded-full bg-green-100 flex items-center justify-center">
                                            <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                            </svg>
                                        </div>
                                    @elseif(str_contains(strtolower($notification->title), 'verified') ||
                                            str_contains(strtolower($notification->title), 'verifikasi'))
                                        <div class="w-12 h-12 rounded-full bg-purple-100 flex items-center justify-center">
                                            <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                            </svg>
                                        </div>
                                    @else
                                        <div class="w-12 h-12 rounded-full bg-gray-100 flex items-center justify-center">
                                            <svg class="w-6 h-6 text-gray-600" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                                            </svg>
                                        </div>
                                    @endif
                                </div>

                                <!-- Content -->
                                <div class="flex-1 min-w-0">
                                    <div class="flex items-center justify-between mb-1">
                                        <h3
                                            class="text-base font-semibold text-gray-900 {{ !$notification->is_read ? 'font-bold' : '' }}">
                                            {{ $notification->title }}
                                        </h3>
                                        @if (!$notification->is_read)
                                            <span
                                                class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                                Baru
                                            </span>
                                        @endif
                                    </div>

                                    <p class="text-sm text-gray-600 mb-2">{{ $notification->message }}</p>

                                    <!-- Additional Info -->
                                    @if ($notification->related_item_id || $notification->related_claim_id)
                                        <div class="flex items-center space-x-4 text-xs text-gray-500">
                                            @if ($notification->related_item_id)
                                                <span class="flex items-center">
                                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor"
                                                        viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                                                    </svg>
                                                    ID: {{ $notification->related_item_id }}
                                                </span>
                                            @endif
                                            @if ($notification->related_claim_id)
                                                <span class="flex items-center">
                                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor"
                                                        viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                                    </svg>
                                                    Klaim #{{ $notification->related_claim_id }}
                                                </span>
                                            @endif
                                        </div>
                                    @endif>

                                    <div class="flex items-center justify-between mt-3">
                                        <span class="text-xs text-gray-500">
                                            <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                            </svg>
                                            {{ $notification->created_at->diffForHumans() }}
                                        </span>

                                        <div class="flex items-center space-x-2">
                                            @if (!$notification->is_read)
                                                <form method="POST"
                                                    action="{{ route('notifications.read', $notification) }}"
                                                    class="inline">
                                                    @csrf
                                                    <button type="submit"
                                                        class="text-xs text-blue-600 hover:text-blue-800 font-medium">
                                                        Tandai dibaca
                                                    </button>
                                                </form>
                                            @endif
                                            <button onclick="deleteNotification({{ $notification->id }})"
                                                class="text-xs text-red-600 hover:text-red-800 font-medium">
                                                Hapus
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-12 text-center">
                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
                        </svg>
                        <h3 class="mt-2 text-sm font-medium text-gray-900">Semua Beres!</h3>
                        <p class="mt-1 text-sm text-gray-500">Tidak ada notifikasi baru untuk saat ini.</p>
                    </div>
                @endforelse
            </div>

            <!-- Pagination -->
            @if ($notifications->hasPages())
                <div class="mt-8">
                    {{ $notifications->links() }}
                </div>
            @endif
        </div>
    </div>

    <script>
        function filterNotifications(type) {
            const allNotifications = document.querySelectorAll('[data-read]');
            const tabAll = document.getElementById('tab-all');
            const tabUnread = document.getElementById('tab-unread');

            if (type === 'all') {
                allNotifications.forEach(notif => {
                    notif.style.display = 'block';
                });
                tabAll.classList.add('text-blue-600', 'border-b-2', 'border-blue-600');
                tabAll.classList.remove('text-gray-600');
                tabUnread.classList.remove('text-blue-600', 'border-b-2', 'border-blue-600');
                tabUnread.classList.add('text-gray-600');
            } else if (type === 'unread') {
                allNotifications.forEach(notif => {
                    if (notif.getAttribute('data-read') === '0') {
                        notif.style.display = 'block';
                    } else {
                        notif.style.display = 'none';
                    }
                });
                tabUnread.classList.add('text-blue-600', 'border-b-2', 'border-blue-600');
                tabUnread.classList.remove('text-gray-600');
                tabAll.classList.remove('text-blue-600', 'border-b-2', 'border-blue-600');
                tabAll.classList.add('text-gray-600');
            }
        }

        function deleteNotification(id) {
            if (confirm('Apakah Anda yakin ingin menghapus notifikasi ini?')) {
                // You can implement AJAX delete here
                // For now, we'll just show an alert
                alert('Fitur hapus akan segera tersedia');
            }
        }
    </script>
@endsection
