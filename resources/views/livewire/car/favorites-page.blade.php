<section x-data="{
    pendingRefresh: false,
    setupEcho() {
        if (window.Echo) {
            window.Echo.private('favorite-car-updated.{{ auth()->id() }}')
                .listen('FavoriteCarUpdated', (e) => {
                    if (!document.hidden) {
                        console.log(e);
                        $wire.$refresh();
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
            $wire.$refresh();
            pendingRefresh = false;
        }
    });
">
    <div class="container">
        <div class="flex items-center justify-start gap-1">
            <h2 class="mx-large">
                My Favourite Cars:
            </h2>
            <h1 class="font-bold text-primary">{{ $favorites->total() }}</h1>
        </div>

        @if($favorites->count() > 0)
        <div class="car-items-listing">
            @foreach($favorites as $car)
            <div class="car-item card" wire:key="car-{{ $car->id }}" style="transition: all 0.3s ease;">
                <a href="{{ route('car.show', $car) }}">
                    @if($car->images->first())
                    <img src="{{ asset('storage/' . $car->images->first()->image_path) }}"
                        alt="{{ $car->year }} {{ $car->maker->name }} {{ $car->model->name }}"
                        class="car-item-img rounded-t" />
                    @else
                    <div class="car-item-img rounded-t"
                        style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); display: flex; align-items: center; justify-content: center; color: white; font-size: 24px;">
                        {{ $car->maker->name[0] }}{{ $car->model->name[0] }}
                    </div>
                    @endif
                </a>
                <div class="p-medium">
                    <div class="flex items-center justify-between">
                        <small class="m-0 text-muted">{{ $car->city->name }}, {{ $car->state->name }}</small>
                        @livewire('car.favorite-button', ['car' => $car], key('fav-btn-' . $car->id))
                    </div>
                    <h2 class="car-item-title">{{ $car->year }} - {{ $car->maker->name }} {{ $car->model->name }}</h2>
                    <p class="car-item-price">${{ number_format($car->price, 0) }}</p>
                    <hr />
                    <p class="m-0">
                        <span class="car-item-badge">{{ $car->carType->name }}</span>
                        <span class="car-item-badge">{{ $car->fuelType->name }}</span>
                    </p>
                </div>
            </div>

            @endforeach
        </div>
        @else
        <div class="text-center py-12 ">
            <h3>No favorites yet</h3>
            <p class="py-6">Start browsing cars and add them to your favorites!</p>
            <br>
            <a href="{{ route('car.search') }}" class="btn btn-primary">Browse Cars</a>
        </div>
        @endif
        {{-- Pagination --}}
        @if($favorites->hasPages())
            <nav class="pagination my-large">
                @if($favorites->onFirstPage())
                    <span class="pagination-item disabled">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" style="width: 18px">
                            <path stroke-linecap="round" stroke-linejoin="round" d="m18.75 4.5-7.5 7.5 7.5 7.5m-6-15L5.25 12l7.5 7.5" />
                        </svg>
                    </span>
                @else
                    <a href="{{ $favorites->url(1) }}" wire:navigate class="pagination-item">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" style="width: 18px">
                            <path stroke-linecap="round" stroke-linejoin="round" d="m18.75 4.5-7.5 7.5 7.5 7.5m-6-15L5.25 12l7.5 7.5" />
                        </svg>
                    </a>
                @endif

                @if($favorites->onFirstPage())
                    <span class="pagination-item disabled">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" style="width: 18px">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5 8.25 12l7.5-7.5" />
                        </svg>
                    </span>
                @else
                    <a href="{{ $favorites->previousPageUrl() }}" wire:navigate class="pagination-item">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" style="width: 18px">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5 8.25 12l7.5-7.5" />
                        </svg>
                    </a>
                @endif

                @foreach(range(1, $favorites->lastPage()) as $page)
                    @if($page == $favorites->currentPage())
                        <span class="pagination-item active">{{ $page }}</span>
                    @else
                        <a href="{{ $favorites->url($page) }}" wire:navigate class="pagination-item">{{ $page }}</a>
                    @endif
                @endforeach

                @if($favorites->hasMorePages())
                    <a href="{{ $favorites->nextPageUrl() }}" wire:navigate class="pagination-item">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" style="width: 18px">
                            <path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5" />
                        </svg>
                    </a>
                @else
                    <span class="pagination-item disabled">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" style="width: 18px">
                            <path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5" />
                        </svg>
                    </span>
                @endif

                @if($favorites->currentPage() == $favorites->lastPage())
                    <span class="pagination-item disabled">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" style="width: 18px">
                            <path stroke-linecap="round" stroke-linejoin="round" d="m5.25 4.5 7.5 7.5-7.5 7.5m6-15 7.5 7.5-7.5 7.5" />
                        </svg>
                    </span>
                @else
                    <a href="{{ $favorites->url($favorites->lastPage()) }}" wire:navigate class="pagination-item">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" style="width: 18px">
                            <path stroke-linecap="round" stroke-linejoin="round" d="m5.25 4.5 7.5 7.5-7.5 7.5m6-15 7.5 7.5-7.5 7.5" />
                        </svg>
                    </a>
                @endif
            </nav>
            @endif
    </div>
</section>
