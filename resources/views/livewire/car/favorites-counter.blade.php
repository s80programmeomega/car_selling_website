<div x-data="{
    pendingRefresh: false,
    setupEcho() {
        if (window.Echo) {
            window.Echo.private('favorite-car-updated.{{ auth()->id() }}')
                .listen('FavoriteCarUpdated', (e) => {
                    if (!document.hidden) {
                        console.log(e);
                        $wire.updateCount();
                    } else {
                        this.pendingRefresh = true;
                    }
                });
            window.Echo.channel('car-deleted')
                .listen('CarDeleted', (e) => {
                    if (!document.hidden) {
                        console.log(e);
                        $wire.updateCount();
                    } else {
                        this.pendingRefresh = true;
                    }
                });
        }
    }
}" x-init="
    setupEcho();
    document.addEventListener('visibilitychange', () => {
        if (!document.hidden && pendingRefresh) {
            $wire.updateCount();
            pendingRefresh = false;
        }
    });
">
    <a href="{{ route('favorites') }}" class="btn-favorites" title="My Favorites">
        <i class="fas fa-heart"></i>
        <span class="favorites-badge">{{ $count }}</span>
    </a>
</div>
