<div class="container mx-auto px-4 py-8" x-data="{
    pendingRefresh: false,
    setupEcho() {
        if (window.Echo) {
            window.Echo.channel('car-created')
                .listen('CarCreated', (e) => {
                        if (!document.hidden) {
                            console.log(e);
                            $wire.$refresh();
                            } else {
                                this.pendingRefresh = true;
                                }
                });
            window.Echo.channel('car-deleted')
            .listen('CarDeleted', (e) => {
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

    {{-- Loading Overlay --}}
    <div wire:loading.flex
        style="position: fixed; top: 0; left: 0; right: 0; bottom: 0; background: rgba(255,255,255,0.8); z-index: 9999; align-items: center; justify-content: center;">
        <div style="text-align: center;">
            <svg class="animate-spin text-blue-700" style="width: 48px; height: 48px;"
                xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4">
                </circle>
                <path class="opacity-75" fill="currentColor"
                    d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                </path>
            </svg>
            <p style="margin-top: 1rem; color: var(--primary-color); font-weight: bold;">Searching...</p>
        </div>
    </div>

    {{-- Search Header --}}
    <div class="mb-8">
        <h1 class="text-3xl font-bold mb-4">Search Cars</h1>

        {{-- Search Input --}}
        <div class="relative">
            <input type="text" wire:model.live.debounce.300ms="search"
                placeholder="Search by maker, model, color, location..."
                class="w-full px-4 py-3 border rounded-lg focus:ring-2 focus:ring-blue-500">
            <div class="absolute right-3 top-3 text-gray-400">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                </svg>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-4 gap-6">
        {{-- Filters Sidebar --}}
        <div class="lg:col-span-1">
            <div class="bg-white rounded-lg shadow p-6 sticky top-4">
                <div class="flex justify-between items-center mb-4">
                    <h2 class="text-xl font-semibold">Filters</h2>
                    <button wire:click="clearFilters" class="text-sm text-blue-600 hover:text-blue-800">
                        Clear All
                    </button>
                </div>

                {{-- Maker Filter --}}
                <div class="mb-4">
                    <label class="block text-sm font-medium mb-2">Maker</label>
                    <select wire:model.live="maker_id" class="w-full border rounded px-3 py-2">
                        <option value="">All Makers</option>
                        @foreach($makers as $maker)
                        <option value="{{ $maker->id }}">{{ $maker->name }}</option>
                        @endforeach
                    </select>
                </div>

                {{-- Car Type Filter --}}
                <div class="mb-4">
                    <label class="block text-sm font-medium mb-2">Car Type</label>
                    <select wire:model.live="car_type_id" class="w-full border rounded px-3 py-2">
                        <option value="">All Types</option>
                        @foreach($carTypes as $type)
                        <option value="{{ $type->id }}">{{ $type->name }}</option>
                        @endforeach
                    </select>
                </div>

                {{-- Fuel Type Filter --}}
                <div class="mb-4">
                    <label class="block text-sm font-medium mb-2">Fuel Type</label>
                    <select wire:model.live="fuel_type_id" class="w-full border rounded px-3 py-2">
                        <option value="">All Fuel Types</option>
                        @foreach($fuelTypes as $fuel)
                        <option value="{{ $fuel->id }}">{{ $fuel->name }}</option>
                        @endforeach
                    </select>
                </div>

                {{-- State Filter --}}
                <div class="mb-4">
                    <label class="block text-sm font-medium mb-2">State</label>
                    <select wire:model.live="state_id" class="w-full border rounded px-3 py-2">
                        <option value="">All States</option>
                        @foreach($states as $state)
                        <option value="{{ $state->id }}">{{ $state->name }}</option>
                        @endforeach
                    </select>
                </div>

                {{-- Year Range --}}
                <div class="mb-4">
                    <label class="block text-sm font-medium mb-2">Year Range</label>
                    <div class="grid grid-cols-2 gap-2">
                        <input type="number" wire:model.live.debounce.500ms="year_from" placeholder="From"
                            class="border rounded px-3 py-2">
                        <input type="number" wire:model.live.debounce.500ms="year_to" placeholder="To"
                            class="border rounded px-3 py-2">
                    </div>
                </div>

                {{-- Price Range --}}
                <div class="mb-4">
                    <label class="block text-sm font-medium mb-2">Price Range</label>
                    <div class="grid grid-cols-2 gap-2">
                        <input type="number" wire:model.live.debounce.500ms="price_from" placeholder="Min"
                            class="border rounded px-3 py-2">
                        <input type="number" wire:model.live.debounce.500ms="price_to" placeholder="Max"
                            class="border rounded px-3 py-2">
                    </div>
                </div>

                {{-- Sort By --}}
                <div class="mb-4">
                    <label class="block text-sm font-medium mb-2">Sort By</label>
                    <select wire:model.live="sort_by" class="w-full border rounded px-3 py-2">
                        <option value="year">Year (Newest)</option>
                        <option value="price">Price (Highest)</option>
                        <option value="mileage">Mileage (Lowest)</option>
                    </select>
                </div>
            </div>
        </div>

        {{-- Results --}}
        <div class="lg:col-span-3">
            {{-- Results Count --}}
            <div class="mb-4 text-gray-600">
                Found {{ $cars->total() }} car(s)
            </div>

            {{-- Loading Indicator --}}
            <div wire:loading class="mb-4">
                <div class="bg-blue-50 border border-blue-200 rounded p-3 text-blue-700">
                    Searching...
                </div>
            </div>

            {{-- Cars Grid --}}
            <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6">
                @forelse($cars as $car)
                <div class="bg-white rounded-lg shadow hover:shadow-lg transition" x-data="{
                    pendingRefresh: false,
                    setupEcho() {
                        if (window.Echo) {
                            window.Echo.channel('cars')
                                .listen('CarDataChanged', (e) => {
                                    if (e.car_id == {{ $car->id }}) {
                                        if (!document.hidden) {
                                            console.log(e);
                                            $wire.$refresh();
                                            } else {
                                                this.pendingRefresh = true;
                                                }
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
                    {{-- Car Image --}}
                    <div class="aspect-video bg-gray-200 rounded-t-lg overflow-hidden">
                        @if($car->images->first())
                        <img src="{{ Storage::url($car->images->first()->image_path) }}"
                            alt="{{ $car->maker->name }} {{ $car->model->name }}" class="w-full h-full object-cover">
                        @endif
                    </div>

                    {{-- Car Details --}}
                    <div class="p-4">
                        <h3 class="font-bold text-lg mb-2">
                            {{ $car->maker->name }} {{ $car->model->name }}
                        </h3>

                        <div class="text-2xl font-bold text-blue-600 mb-2">
                            ${{ number_format($car->price, 2) }}
                        </div>

                        <div class="text-sm text-gray-600 space-y-1">
                            <div>{{ $car->year }} • {{ number_format($car->mileage) }} miles</div>
                            <div>{{ $car->city->name }}, {{ $car->state->name }}</div>
                            <div>{{ $car->fuelType->name }} • {{ $car->transmission }}</div>
                        </div>

                        <a href="{{ route('car.show', $car) }}"
                            class="mt-4 block w-full bg-blue-600 text-white text-center py-2 rounded hover:bg-blue-700 transition">
                            View Details
                        </a>
                    </div>
                </div>
                @empty
                <div class="col-span-full text-center py-12">
                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <h3 class="mt-2 text-sm font-medium text-gray-900">No cars found</h3>
                    <p class="mt-1 text-sm text-gray-500">Try adjusting your search or filters</p>
                </div>
                @endforelse
            </div>

            {{-- Pagination --}}
            <div class="mt-8">
                {{ $cars->links() }}
            </div>
        </div>
    </div>
</div>
