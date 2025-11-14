<div x-data="{
    interval: {{ rand(30, 180) }},
    timerId: null,
    startPolling() {
        this.timerId = setTimeout(() => {
            $wire.$refresh();
            this.interval = Math.floor(Math.random() * 9) + 30;
            this.startPolling();
        }, this.interval * 1000);
    },
    stopPolling() {
        if (this.timerId) clearTimeout(this.timerId);
    }
}" x-init="
    startPolling();
    document.addEventListener('visibilitychange', () => {
        if (document.hidden) {
            stopPolling();
        } else {
            startPolling();
        }
    });
">

    <h1 x-text="interval"></h1>
    <div class="car-items-listing">
        @forelse($latest_cars as $car)
        <div class="car-item card" wire:key="car-{{ $car->id }}" style="transition: all 0.5s ease;">
            <a href="{{ route('car.show', $car->id) }}">
                <img src="{{ $car->images->first() ? asset('storage/' . $car->images->first()->image_path) : 'https://placehold.co/400x300?text=' . urlencode($car->maker->name) }}"
                    alt="{{ $car->maker->name }} {{ $car->model->name }}" class="car-item-img rounded-t" />
            </a>
            <div class="p-medium">
                <div class="flex items-center justify-between">
                    <small class="m-0 text-muted">{{ $car->city->name ?? 'N/A' }}</small>
                    @livewire('car.favorite-button', ['car' => $car], key('fav-' . $car->id))
                </div>
                <h2 class="car-item-title">{{ $car->year }} - {{ $car->maker->name }} {{ $car->model->name }}</h2>
                <p class="car-item-price">${{ number_format($car->price) }}</p>
                <hr />
                <p class="m-0">
                    <span class="car-item-badge">{{ $car->carType->name }}</span>
                    <span class="car-item-badge">{{ $car->fuelType->name }}</span>
                </p>
            </div>
        </div>
        @empty
        <p>No cars available at the moment.</p>
        @endforelse
    </div>

    @if($latest_cars->hasPages())
    <nav class="pagination my-large">
        @if ($latest_cars->onFirstPage())
        <span class="pagination-item" style="opacity: 0.5; cursor: not-allowed;">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                stroke="currentColor" style="width: 18px">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="m18.75 4.5-7.5 7.5 7.5 7.5m-6-15L5.25 12l7.5 7.5" />
            </svg>
        </span>
        @else
        <a href="#" wire:click.prevent="gotoPage(1)" class="pagination-item">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                stroke="currentColor" style="width: 18px">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="m18.75 4.5-7.5 7.5 7.5 7.5m-6-15L5.25 12l7.5 7.5" />
            </svg>
        </a>
        @endif

        @if ($latest_cars->onFirstPage())
        <span class="pagination-item" style="opacity: 0.5; cursor: not-allowed;">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                stroke="currentColor" style="width: 18px">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5 8.25 12l7.5-7.5" />
            </svg>
        </span>
        @else
        <a href="#" wire:click.prevent="previousPage" class="pagination-item">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                stroke="currentColor" style="width: 18px">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5 8.25 12l7.5-7.5" />
            </svg>
        </a>
        @endif

        @foreach(range(1, $latest_cars->lastPage()) as $page)
        @if($page == $latest_cars->currentPage())
        <span class="pagination-item active">{{ $page }}</span>
        @else
        <a href="#" wire:click.prevent="gotoPage({{ $page }})" class="pagination-item">{{ $page }}</a>
        @endif
        @endforeach

        @if ($latest_cars->hasMorePages())
        <a href="#" wire:click.prevent="nextPage" class="pagination-item">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                stroke="currentColor" style="width: 18px">
                <path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5" />
            </svg>
        </a>
        @else
        <span class="pagination-item" style="opacity: 0.5; cursor: not-allowed;">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                stroke="currentColor" style="width: 18px">
                <path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5" />
            </svg>
        </span>
        @endif

        @if ($latest_cars->hasMorePages())
        <a href="#" wire:click.prevent="gotoPage({{ $latest_cars->lastPage() }})" class="pagination-item">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                stroke="currentColor" style="width: 18px">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="m5.25 4.5 7.5 7.5-7.5 7.5m6-15 7.5 7.5-7.5 7.5" />
            </svg>
        </a>
        @else
        <span class="pagination-item" style="opacity: 0.5; cursor: not-allowed;">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                stroke="currentColor" style="width: 18px">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="m5.25 4.5 7.5 7.5-7.5 7.5m6-15 7.5 7.5-7.5 7.5" />
            </svg>
        </span>
        @endif
    </nav>
    @endif
</div>
