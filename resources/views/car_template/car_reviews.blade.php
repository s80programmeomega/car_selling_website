@extends('car_template.base')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        <div>
            @auth
                @livewire('car.add-review', ['car' => $car])
            @else
                <div class="bg-white rounded-lg shadow p-6">
                    <p class="text-center">Please <a href="{{ route('login') }}" class="text-blue-500 hover:underline">login</a> to write a review.</p>
                </div>
            @endauth
        </div>
        <div>
            @livewire('car.reviews-list', ['car' => $car])
        </div>
    </div>
</div>
@endsection
