@extends('car_template.base')

@section('title', $car->maker->name . ' ' . $car->model->name . ' - ' . $car->year)

@section('content')
<div class="container">
    <h1 class="car-details-page-title">{{ $car->maker->name }} {{ $car->model->name }} - {{ $car->year }}</h1>
    <div class="car-details-region">{{ $car->city->name }}, {{ $car->state->name }} - {{
        $car->created_at->diffForHumans() }}</div>

    <div class="flex gap-1 my-medium">
        @can('update', $car)
            <a href="{{ route('car.edit', $car) }}" class="btn btn-primary">Edit Car</a>
            <a href="{{ route('car.images', $car) }}" class="btn btn-default">Manage Images</a>
        @endcan

        @can('delete', $car)
            <form action="{{ route('car.destroy', $car) }}" method="POST"
                onsubmit="return confirm('Are you sure you want to delete this car?');" style="display: inline;">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger">Delete Car</button>
            </form>
        @endcan
    </div>

    <div class="car-details-content">

        <div class="car-images-and-description">
            @livewire('car.car-images', ['carId' => $car->id])

            <div class="card car-detailed-description">
                <h2 class="car-details-title">Detailed Description</h2>
                <p>{{ $car->description ?? 'No description available.' }}</p>
            </div>
            <div class="card car-detailed-description">
                <h2 class="car-details-title">Car Features</h2>
                <ul class="car-specifications">
                    @foreach($allFeatures as $feature)
                    <li>
                        @if(in_array($feature->id, $carFeatureIds))
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                            style="color: rgb(0, 192, 102)">
                            <path fill-rule="evenodd"
                                d="M2.25 12c0-5.385 4.365-9.75 9.75-9.75s9.75 4.365 9.75 9.75-4.365 9.75-9.75 9.75S2.25 17.385 2.25 12Zm13.36-1.814a.75.75 0 1 0-1.22-.872l-3.236 4.53L9.53 12.22a.75.75 0 0 0-1.06 1.06l2.25 2.25a.75.75 0 0 0 1.14-.094l3.75-5.25Z"
                                clip-rule="evenodd" />
                        </svg>
                        @else
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                            style="color: red">
                            <path fill-rule="evenodd"
                                d="M12 2.25c-5.385 0-9.75 4.365-9.75 9.75s4.365 9.75 9.75 9.75 9.75-4.365 9.75-9.75S17.385 2.25 12 2.25Zm3 10.5a.75.75 0 0 0 0-1.5H9a.75.75 0 0 0 0 1.5h6Z"
                                clip-rule="evenodd" />
                        </svg>
                        @endif
                        {{ $feature->name }}
                    </li>
                    @endforeach
                </ul>
            </div>

            <!-- Reviews Section -->
            <div class="card car-detailed-description">
                <h2 class="car-details-title">Customer Reviews</h2>
                @php
                $reviews = $car->reviews()->with('reviewer')->latest()->limit(5)->get();
                $averageRating = $car->reviews()->avg('rating');
                $totalReviews = $car->reviews()->count();
                @endphp

                @if($totalReviews > 0)
                <div style="margin-bottom: 1rem;">
                    <span style="font-size: 2rem; font-weight: bold;">{{ number_format($averageRating, 1) }}</span>
                    <span style="color: #fbbf24; font-size: 1.5rem;">
                        @for($i = 1; $i <= 5; $i++) {{ $i <=round($averageRating) ? '★' : '☆' }} @endfor </span>
                            <span style="color: #6b7280;">({{ $totalReviews }} {{ Str::plural('review', $totalReviews)
                                }})</span>
                </div>
                <hr>

                @foreach($reviews as $review)
                <div style="border-bottom: 1px solid #e5e7eb; padding-bottom: 1rem; margin-bottom: 1rem;">
                    <div
                        style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 0.5rem;">
                        <div>
                            <strong>{{ $review->reviewer->username ?? $review->reviewer->username ?? 'Anonymous'
                                }}</strong>
                            <span style="color: #fbbf24; margin-left: 0.5rem;">
                                @for($i = 1; $i <= 5; $i++) {{ $i <=$review->rating ? '★' : '☆' }}
                                    @endfor
                            </span>
                        </div>
                        <span style="font-size: 0.875rem; color: #6b7280;">{{ $review->created_at->diffForHumans()
                            }}</span>
                    </div>
                    @if($review->comment)
                    <p style="color: #374151;">{{ $review->comment }}</p>
                    @endif
                </div>
                @endforeach

                @if($totalReviews > 5)
                <a href="{{ route('car.reviews', $car) }}" class="btn btn-default" style="margin-top: 1rem;">View All
                    Reviews</a>
                @endif
                @else
                <p style="color: #6b7280;">No reviews yet. Be the first to review this car!</p>
                @endif

                @auth
                <a href="{{ route('car.reviews', $car) }}" class="btn btn-primary" style="margin-top: 1rem;">Write a
                    Review</a>
                @else
                <a href="{{ route('login') }}" class="btn btn-primary" style="margin-top: 1rem;">Login to Write a
                    Review</a>
                @endauth
            </div>

        </div>
        <div class="car-details card">
            @livewire('car.car-details', ['carId' => $car->id])
        </div>
    </div>
</div>
@endsection
