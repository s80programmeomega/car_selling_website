@extends('car_template.base')

@section('title')
Home Page
@endsection

@section('content')
<!-- Home Slider -->
<section class="hero-slider">
    <!-- Carousel wrapper -->
    <div class="hero-slides">
        <!-- Item 1 -->
        <div class="hero-slide">
            <div class="container">
                <div class="slide-content">
                    <h1 class="hero-slider-title">
                        Buy <strong>The Best Cars</strong> <br />
                        in your region
                    </h1>
                    <div class="hero-slider-content">
                        <p>
                            Use powerful search tool to find your desired cars based on
                            multiple search criteria: Maker, Model, Year, Price Range, Car
                            Type, etc...
                        </p>

                        <a href="{{ route('car.search') }}" class="btn btn-hero-slider">Find the car</a>

                    </div>
                </div>
                <div class="slide-image">
                    <img src="/img/view-3d-car.jpg" alt="" class="img-responsive" />
                </div>
            </div>
        </div>
        <!-- Item 2 -->
        <div class="hero-slide">
            <div class="flex container">
                <div class="slide-content">
                    <h2 class="hero-slider-title">
                        Do you want to <br />
                        <strong>sell your car?</strong>
                    </h2>
                    <div class="hero-slider-content">
                        <p>
                            Submit your car in our user friendly interface, describe it,
                            upload photos and the perfect buyer will find it...
                        </p>

                        <a href="{{ route('car.create') }}" class="btn btn-hero-slider">Add Your Car</a>

                    </div>
                </div>
                <div class="slide-image">
                    <img src="/img/car-png-39071.png" alt="" class="img-responsive" />
                </div>
            </div>
        </div>
        <button type="button" class="hero-slide-prev">
            <svg style="width: 18px" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                viewBox="0 0 6 10">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M5 1 1 5l4 4" />
            </svg>
            <span class="sr-only">Previous</span>
        </button>
        <button type="button" class="hero-slide-next">
            <svg style="width: 18px" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                viewBox="0 0 6 10">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="m1 9 4-4-4-4" />
            </svg>
            <span class="sr-only">Next</span>
        </button>
    </div>
</section>
<!--/ Home Slider -->

<!-- Find a car form -->
<section class="find-a-car" style="margin-top: 1.5rem;">
    <div class="container">
        @livewire('car.home-search-form')
    </div>
</section>
<!--/ Find a car form -->


<!-- New Cars -->
<section style="padding-top: 3rem;">
    <div class="container">
        <h2>Latest Added Cars</h2>
        <div class="car-items-listing">
            @forelse($latest_cars as $car)
            <div class="car-item card">
                <a href="{{ route('car.show', $car->id) }}">
                    <img src="{{ $car->images->first() ? asset('storage/' . $car->images->first()->image_path) : 'https://placehold.co/400x300?text=' . urlencode($car->maker->name)  }}"
                        alt="{{ $car->maker->name }} {{ $car->model->name }}" class="car-item-img rounded-t" />
                </a>
                <div class="p-medium">
                    <div class="flex items-center justify-between">
                        <small class="m-0 text-muted">{{ $car->city->name ?? 'N/A' }}</small>
                        <div class="flex items-center justify-between">
                            <small class="m-0 text-muted">{{ $car->city->name ?? 'N/A' }}</small>
                            @livewire('car.favorite-button', ['car' => $car], key($car->id))
                        </div>

                        {{-- <button class="btn-heart">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                stroke="currentColor" style="width: 20px">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12Z" />
                            </svg>
                        </button> --}}
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

        {{-- Pagination --}}
        @if($latest_cars->hasPages())
            <nav class="pagination my-large">
                {{-- First Page --}}
                @if ($latest_cars->onFirstPage())
                    <span class="pagination-item" style="opacity: 0.5; cursor: not-allowed;">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" style="width: 18px">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="m18.75 4.5-7.5 7.5 7.5 7.5m-6-15L5.25 12l7.5 7.5" />
                        </svg>
                    </span>
                @else
                    <a href="{{ $latest_cars->url(1) }}" class="pagination-item">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" style="width: 18px">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="m18.75 4.5-7.5 7.5 7.5 7.5m-6-15L5.25 12l7.5 7.5" />
                        </svg>
                    </a>
                @endif

                {{-- Previous Page --}}
                @if ($latest_cars->onFirstPage())
                    <span class="pagination-item" style="opacity: 0.5; cursor: not-allowed;">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" style="width: 18px">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5 8.25 12l7.5-7.5" />
                        </svg>
                    </span>
                @else
                    <a href="{{ $latest_cars->previousPageUrl() }}" class="pagination-item">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" style="width: 18px">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5 8.25 12l7.5-7.5" />
                        </svg>
                    </a>
                @endif

                {{-- Page Numbers --}}
                @foreach(range(1, $latest_cars->lastPage()) as $page)
                    @if($page == $latest_cars->currentPage())
                        <span class="pagination-item active">{{ $page }}</span>
                    @else
                        <a href="{{ $latest_cars->url($page) }}" class="pagination-item">{{ $page }}</a>
                    @endif
                @endforeach

                {{-- Next Page --}}
                @if ($latest_cars->hasMorePages())
                    <a href="{{ $latest_cars->nextPageUrl() }}" class="pagination-item">
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

                {{-- Last Page --}}
                @if ($latest_cars->hasMorePages())
                    <a href="{{ $latest_cars->url($latest_cars->lastPage()) }}" class="pagination-item">
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
</section>

@endsection
