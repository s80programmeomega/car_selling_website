<div class="relative" x-data="{
    open: @entangle('showDropdown'),
    toasts: [],
    visibilityInterval: null,

    init() {
        // Listen for notifications on user's private channel
        Echo.private('user.{{ auth()->id() }}')
            .notification((notification) => {
                console.log('New notification received:', notification);

                // Only refresh if page is visible
                if (!document.hidden) {
                    $wire.call('loadNotifications');
                }

                // Show toast notification
                this.showToast(notification);
            });

        // Setup visibility change listener
        this.setupVisibilityRefresh();
    },

    setupVisibilityRefresh() {
        // Refresh when page becomes visible
        document.addEventListener('visibilitychange', () => {
            if (!document.hidden) {
                // Refresh when user returns to tab
                $wire.call('loadNotifications');
            }
        });

        // Refresh every 30 seconds when dropdown is open AND page is visible
        this.$watch('open', (isOpen) => {
            if (isOpen) {
                // Refresh immediately when opened (only if visible)
                if (!document.hidden) {
                    $wire.call('loadNotifications');
                }

                // Start interval for real-time updates
                this.visibilityInterval = setInterval(() => {
                    if (!document.hidden) {
                        $wire.call('loadNotifications');
                    }
                }, 30000); // 30 seconds
            } else {
                // Clear interval when closed
                if (this.visibilityInterval) {
                    clearInterval(this.visibilityInterval);
                    this.visibilityInterval = null;
                }
            }
        });
    },

    showToast(notification) {
        const toast = {
            id: Date.now(),
            title: notification.title || 'Notification',
            message: notification.message || '',
            url: notification.url || null
        };

        // Add toast to array
        this.toasts.push(toast);

        // Auto-remove after 5 seconds
        setTimeout(() => {
            this.removeToast(toast.id);
        }, 5000);
    },

    removeToast(id) {
        this.toasts = this.toasts.filter(toast => toast.id !== id);
    },

    goToNotification(url) {
        if (url) {
            window.location.href = url;
        }
    }
}">
    <!-- Notification Bell Button -->
    <button @click="open = !open" class="relative p-2 text-gray-600 hover:text-gray-900">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9">
            </path>
        </svg>
        @if($unreadCount > 0)
        <span
            class="absolute top-0 right-0 inline-flex items-center justify-center px-2 py-1 text-xs font-bold leading-none text-white transform translate-x-1/2 -translate-y-1/2 bg-red-600 rounded-full">
            {{ $unreadCount }}
        </span>
        @endif
    </button>

    <div x-show="open" @click.away="open = false"
        class="absolute right-0 mt-2 w-80 bg-white rounded-lg shadow-lg z-50 max-h-96 overflow-y-auto">
        <div class="p-4 border-b flex justify-between items-center">
            <h3 class="font-semibold">Notifications</h3>
            @if($unreadCount > 0)
            <button wire:click="markAllAsRead" class="text-sm text-blue-600 hover:text-blue-800">
                Mark all read
            </button>
            @endif
        </div>

        <div class="divide-y">
            @forelse($notifications as $notification)
            <div wire:click="markAsRead('{{ $notification->id }}')"
                class="p-4 hover:bg-gray-50 cursor-pointer {{ $notification->read_at ? '' : 'bg-blue-50' }}">
                <p class="text-sm font-medium">{{ $notification->data['title'] ?? 'Notification' }}</p>
                <p class="text-xs text-gray-600 mt-1">{{ $notification->data['message'] ?? '' }}</p>
                <p class="text-xs text-gray-400 mt-1">{{ $notification->created_at->diffForHumans() }}</p>
            </div>
            @empty
            <div class="p-8 text-center text-gray-500">
                <p>No new notifications</p>
            </div>
            @endforelse
        </div>

        @if($notifications->count() > 0)
        <div class="p-3 border-t text-center">
            <a href="{{ route('notifications.index') }}" class="text-sm text-blue-600 hover:text-blue-800">
                View all notifications
            </a>
        </div>
        @endif
    </div>

    <!-- Toast Notifications Container -->
    <div class="fixed top-4 right-4 z-50 space-y-2" style="max-width: 400px;">
        <template x-for="toast in toasts" :key="toast.id">
            <div
                x-show="true"
                x-transition:enter="transform transition ease-out duration-300"
                x-transition:enter-start="translate-x-full opacity-0"
                x-transition:enter-end="translate-x-0 opacity-100"
                x-transition:leave="transform transition ease-in duration-200"
                x-transition:leave-start="translate-x-0 opacity-100"
                x-transition:leave-end="translate-x-full opacity-0"
                class="bg-white rounded-lg shadow-lg border-l-4 border-blue-500 p-4 cursor-pointer hover:shadow-xl transition-shadow"
                @click="goToNotification(toast.url); removeToast(toast.id)">

                <div class="flex items-start">
                    <!-- Icon -->
                    <div class="flex-shrink-0">
                        <svg class="w-6 h-6 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9">
                            </path>
                        </svg>
                    </div>

                    <!-- Content -->
                    <div class="ml-3 flex-1">
                        <p class="text-sm font-semibold text-gray-900" x-text="toast.title"></p>
                        <p class="text-sm text-gray-600 mt-1" x-text="toast.message"></p>
                    </div>

                    <!-- Close Button -->
                    <button
                        @click.stop="removeToast(toast.id)"
                        class="ml-3 flex-shrink-0 text-gray-400 hover:text-gray-600">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
            </div>
        </template>
    </div>
</div>
