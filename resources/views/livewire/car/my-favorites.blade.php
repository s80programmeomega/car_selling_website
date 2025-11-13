<div class="container mx-auto px-4 py-8">
    <h1 class="text-3xl font-bold mb-6">My Favorites</h1>

    @if($favorites->count() > 0)
    <div class="car-items-listing">
        @foreach($favorites as $car)
        <div class="car-item card">
            <a href="{{ route('car.show', $car) }}">
                @if($car->images->first())
                <img src="{{ Storage::url($car->images->first()->image_path) }}"
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
                    @livewire('car.favorite-button', ['car' => $car], key($car->id))
                </div>
                <h2 class="car-item-title">{{ $car->year }} - {{ $car->maker->name }} {{ $car->model->name }}</h2>
                <p class="car-item-price">${{ number_format($car->price, 0) }}</p>
                <hr />
                <p class="m-0">
                    <span class="car-item-badge">{{ $car->carType->name }}</span>
                    <span class="car-item-badge">{{ $car->fuelType->name }}</span>
                    @if($car->mileage)
                    <span class="car-item-badge">{{ number_format($car->mileage) }} mi</span>
                    @endif
                </p>
            </div>
        </div>
        @endforeach
    </div>

    {{ $favorites->links() }}
    @else
    <div class="text-center py-12">
        <svg class="mx-auto h-16 w-16 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
        </svg>
        <h3 class="mt-4 text-lg font-medium">No favorites yet</h3>
        <p class="mt-2 text-gray-500">Start browsing cars and add them to your favorites!</p>
        <a href="{{ route('car.search') }}" class="mt-4 btn btn-primary">Browse Cars</a>
    </div>
    @endif
</div>
