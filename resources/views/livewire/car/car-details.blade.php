<div class="car-details card"
    x-data="{
        pendingRefresh: false,
        setupEcho() {
            if (window.Echo) {
                window.Echo.channel('car-updated')
                    .listen('CarDataChanged', (e) => {
                        console.log('hello test before refresh!');
                        if (e.car_id == {{ $car->id }}) {
                            if (!document.hidden) {
                                console.log(e);
                                $wire.$refresh();
                                console.log('hello test after refresh!');
                                } else {
                                    this.pendingRefresh = true;
                                    }
                                    }
                    });
            }
        }
    }"
    x-init="
        setupEcho();
        document.addEventListener('visibilitychange', () => {
            if (!document.hidden && pendingRefresh) {
                $wire.$refresh();
                pendingRefresh = false;
            }
        });
    ">

    <div class="flex items-center justify-between">
        <p class="car-details-price">${{ number_format($car->price) }}</p>
        @livewire('car.favorite-button', ['car' => $car], key('fav-' . $car->id))
    </div>

    <hr />
    <table class="car-details-table">
        <tbody>
            <tr>
                <th>Maker</th>
                <td>{{ $car->maker->name }}</td>
            </tr>
            <tr>
                <th>Model</th>
                <td>{{ $car->model->name }}</td>
            </tr>
            <tr>
                <th>Year</th>
                <td>{{ $car->year }}</td>
            </tr>
            <tr>
                <th>Car Type</th>
                <td>{{ $car->carType->name }}</td>
            </tr>
            <tr>
                <th>Fuel Type</th>
                <td>{{ $car->fuelType->name }}</td>
            </tr>
            <tr>
                <th>Transmission</th>
                <td>{{ ucfirst($car->transmission) }}</td>
            </tr>
            <tr>
                <th>Mileage</th>
                <td>{{ number_format($car->mileage) }} miles</td>
            </tr>
            <tr>
                <th>Condition</th>
                <td>{{ ucfirst($car->condition) }}</td>
            </tr>
            <tr>
                <th>Color</th>
                <td>{{ $car->color }}</td>
            </tr>
        </tbody>
    </table>
    <hr />

    <div class="flex gap-1 my-medium">
        <img src="/img/avatar.png" alt="{{ $car->owner->name }}" class="car-details-owner-image" />
        <div>
            <h3 class="car-details-owner">{{ $car->owner->name }}</h3>
            <div class="text-muted">{{ $car->owner->cars->count() }} cars</div>
        </div>
    </div>
    <a href="tel:{{ $car->phone }}" class="car-details-phone">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
            stroke="currentColor" style="width: 16px">
            <path stroke-linecap="round" stroke-linejoin="round"
                d="M10.5 1.5H8.25A2.25 2.25 0 0 0 6 3.75v16.5a2.25 2.25 0 0 0 2.25 2.25h7.5A2.25 2.25 0 0 0 18 20.25V3.75a2.25 2.25 0 0 0-2.25-2.25H13.5m-3 0V3h3V1.5m-3 0h3m-3 18.75h3" />
        </svg>
        {{ $car->phone }}
    </a>
    <a href="{{ route('car.inquiry', $car) }}" class="car-details-phone" style="margin-top: 0.5rem;">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" style="width: 16px">
            <path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 0 1-2.25 2.25h-15a2.25 2.25 0 0 1-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0 0 19.5 4.5h-15a2.25 2.25 0 0 0-2.25 2.25m19.5 0v.243a2.25 2.25 0 0 1-1.07 1.916l-7.5 4.615a2.25 2.25 0 0 1-2.36 0L3.32 8.91a2.25 2.25 0 0 1-1.07-1.916V6.75" />
        </svg>
        Make An Inquiry
    </a>


</div>
