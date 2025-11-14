<div class="car-images-carousel" x-data="{
    interval: {{ rand(15, 30) }},
    timerId: null,
    startPolling() {
        this.timerId = setTimeout(() => {
            $wire.$refresh();
            this.interval = Math.floor(Math.random() * 9) + 15;
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
    <div class="car-image-wrapper">
        <img src="{{ $car->images->first() ? asset('storage/' . $car->images->first()->image_path) : 'https://placehold.co/800x600?text=No+Image' }}"
            alt="{{ $car->maker->name }} {{ $car->model->name }}" class="car-active-image" id="activeImage" />
    </div>
    <div class="car-image-thumbnails">
        @foreach($car->images as $image)
        <img src="{{ asset('storage/' . $image->image_path) }}" alt="{{ $car->maker->name }}" />
        @endforeach
    </div>

    @if($car->images->count() > 1)
    <button class="carousel-button prev-button" id="prevButton">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
            style="width: 64px">
            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5 8.25 12l7.5-7.5" />
        </svg>
    </button>
    <button class="carousel-button next-button" id="nextButton">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
            style="width: 64px">
            <path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5" />
        </svg>
    </button>
    @endif
</div>
