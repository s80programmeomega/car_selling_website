<div class="car-details card"
    x-data="{
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
    }"
    x-init="
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

    <div class="flex items-center justify-between">
        <p class="car-details-price">${{ number_format($car->price) }}</p>
        <button class="btn-heart">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                stroke="currentColor" style="width: 20px">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12Z" />
            </svg>
        </button>
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
</div>
