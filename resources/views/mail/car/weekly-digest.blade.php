@extends('mail.car.layouts.base')

@section('header')
    <h2>🚗 Your Weekly Car Digest</h2>
    <p>Hello {{ $user->first_name }}! Here's what's new this week.</p>
@endsection

@section('content')
    {{-- <style>
        .stats { background: #f8f9fa; padding: 20px; border-radius: 8px; margin: 20px 0; text-align: center; }
        .car-card { border: 1px solid #e0e0e0; border-radius: 8px; padding: 15px; margin-bottom: 20px; }
        .car-title { font-size: 18px; font-weight: bold; color: #333; margin-bottom: 8px; }
        .car-price { font-size: 20px; color: #e9580c; font-weight: bold; margin-bottom: 10px; }
        .car-details { font-size: 14px; color: #666; margin-bottom: 10px; }
        .btn { display: inline-block; padding: 12px 24px; background: #e9580c; color: white; text-decoration: none; border-radius: 5px; margin-top: 10px; }
    </style> --}}

    <div class="stats">
        <h3>📊 This Week's Stats</h3>
        <p><strong>{{ $stats['new_cars_count'] }}</strong> new cars added</p>
        <p><strong>{{ $stats['total_cars'] }}</strong> total cars available</p>
    </div>

    @if($latestCars->isNotEmpty())
        <h2>🆕 Latest Arrivals</h2>
        @foreach($latestCars as $car)
            <div class="car-card">
                <div class="car-title">{{ $car->year }} {{ $car->maker->name }} {{ $car->model->name }}</div>
                <div class="car-price">${{ number_format($car->price, 2) }}</div>
                <div class="car-details">
                    📍 {{ $car->city->name }}, {{ $car->state->name }} |
                    🛣️ {{ number_format($car->mileage) }} miles
                </div>
                <a href="{{ url('/cars/' . $car->id) }}" class="btn">View Details</a>
            </div>
        @endforeach
    @endif

    @if($featuredCars->isNotEmpty())
        <h2>⭐ Featured Cars</h2>
        @foreach($featuredCars as $car)
            <div class="car-card">
                <div class="car-title">{{ $car->year }} {{ $car->maker->name }} {{ $car->model->name }}</div>
                <div class="car-price">${{ number_format($car->price, 2) }}</div>
                <a href="{{ url('/cars/' . $car->id) }}" class="btn">View Details</a>
            </div>
        @endforeach
    @endif

    <div style="text-align: center; margin-top: 30px;">
        <a href="{{ url('/cars') }}" class="btn">Browse All Cars</a>
    </div>
@endsection

@section('footer')
    <p>You're receiving this because you subscribed to our weekly digest.</p>
    <p><a href="{{ url('/dashboard/settings') }}">Update Preferences</a> | <a href="{{ url('/subscriptions/unsubscribe-all') }}">Unsubscribe</a></p>
@endsection
