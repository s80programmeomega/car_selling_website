<section>
    {{-- Search Header with Filters Toggle and Sort --}}
    <div class="sm:flex items-center justify-between mb-medium">
        <div class="flex items-center">
            <button class="show-filters-button flex items-center" wire:click="$dispatch('toggle-filters')">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                    stroke="currentColor" style="width: 20px">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M6 13.5V3.75m0 9.75a1.5 1.5 0 0 1 0 3m0-3a1.5 1.5 0 0 0 0 3m0 3.75V16.5m12-3V3.75m0 9.75a1.5 1.5 0 0 1 0 3m0-3a1.5 1.5 0 0 0 0 3m0 3.75V16.5m-6-9V3.75m0 3.75a1.5 1.5 0 0 1 0 3m0-3a1.5 1.5 0 0 0 0 3m0 9.75V10.5" />
                </svg>
                Filters
            </button>
            <h2>Define your search criteria</h2>
        </div>

        <select wire:model.live="sort_by" class="sort-dropdown">
            <option value="year">Order By Year (Newest)</option>
            <option value="price">Order By Price (Highest)</option>
            <option value="mileage">Order By Mileage (Lowest)</option>
        </select>
    </div>

    <div class="search-car-results-wrapper">
        {{-- Filters Sidebar --}}
        <div class="search-cars-sidebar" wire:ignore.self>
            {{-- Found Cars Count Card --}}
            <div class="card card-found-cars">
                <p class="m-0">
                    Found <strong wire:loading.remove>{{ $cars->total() }}</strong>
                    <strong wire:loading>...</strong> cars
                </p>

                <button class="close-filters-button" @click="open = false">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" style="width: 24px">
                        <path fill-rule="evenodd"
                            d="M5.47 5.47a.75.75 0 0 1 1.06 0L12 10.94l5.47-5.47a.75.75 0 1 1 1.06 1.06L13.06 12l5.47 5.47a.75.75 0 1 1-1.06 1.06L12 13.06l-5.47 5.47a.75.75 0 0 1-1.06-1.06L10.94 12 5.47 6.53a.75.75 0 0 1 0-1.06Z"
                            clip-rule="evenodd" />
                    </svg>
                </button>
                {{-- <button class="close-filters-button" onclick="document.querySelector('.search-cars-sidebar').classList.remove('opened')">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" style="width: 24px">
                        <path fill-rule="evenodd"
                            d="M5.47 5.47a.75.75 0 0 1 1.06 0L12 10.94l5.47-5.47a.75.75 0 1 1 1.06 1.06L13.06 12l5.47 5.47a.75.75 0 1 1-1.06 1.06L12 13.06l-5.47 5.47a.75.75 0 0 1-1.06-1.06L10.94 12 5.47 6.53a.75.75 0 0 1 0-1.06Z"
                            clip-rule="evenodd" />
                    </svg>
                </button> --}}
            </div>

            {{-- Find a Car Form --}}
            <section class="find-a-car">
                <form class="find-a-car-form card flex p-medium" wire:submit.prevent>
                    <div class="find-a-car-inputs">
                        {{-- Search Input --}}
                        <div class="form-group">
                            <label class="mb-medium">Search</label>
                            <input
                                type="text"
                                wire:model.live.debounce.300ms="search"
                                placeholder="Search by maker, model, color..."
                            />
                        </div>

                        {{-- Maker --}}
                        <div class="form-group">
                            <label class="mb-medium">Maker</label>
                            <select wire:model.live="maker_id">
                                <option value="">All Makers</option>
                                @foreach($makers as $maker)
                                    <option value="{{ $maker->id }}">{{ $maker->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        {{-- Model (Dynamic based on Maker) --}}
                        <div class="form-group">
                            <label class="mb-medium">Model</label>
                            <select wire:model.live="model_id">
                                <option value="">All Models</option>
                                @if($maker_id)
                                    @foreach($models as $model)
                                        <option value="{{ $model->id }}">{{ $model->name }}</option>
                                    @endforeach
                                @endif
                            </select>
                        </div>

                        {{-- Car Type --}}
                        <div class="form-group">
                            <label class="mb-medium">Type</label>
                            <select wire:model.live="car_type_id">
                                <option value="">All Types</option>
                                @foreach($carTypes as $type)
                                    <option value="{{ $type->id }}">{{ $type->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        {{-- Year Range --}}
                        <div class="form-group">
                            <label class="mb-medium">Year</label>
                            <div class="flex gap-1">
                                <input
                                    type="number"
                                    placeholder="Year From"
                                    wire:model.live.debounce.500ms="year_from"
                                />
                                <input
                                    type="number"
                                    placeholder="Year To"
                                    wire:model.live.debounce.500ms="year_to"
                                />
                            </div>
                        </div>

                        {{-- Price Range --}}
                        <div class="form-group">
                            <label class="mb-medium">Price</label>
                            <div class="flex gap-1">
                                <input
                                    type="number"
                                    placeholder="Price From"
                                    wire:model.live.debounce.500ms="price_from"
                                />
                                <input
                                    type="number"
                                    placeholder="Price To"
                                    wire:model.live.debounce.500ms="price_to"
                                />
                            </div>
                        </div>

                        {{-- Mileage --}}
                        <div class="form-group">
                            <label class="mb-medium">Mileage</label>
                            <select wire:model.live="mileage">
                                <option value="">Any Mileage</option>
                                <option value="10000">10,000 or less</option>
                                <option value="20000">20,000 or less</option>
                                <option value="30000">30,000 or less</option>
                                <option value="50000">50,000 or less</option>
                                <option value="100000">100,000 or less</option>
                                <option value="150000">150,000 or less</option>
                                <option value="200000">200,000 or less</option>
                            </select>
                        </div>

                        {{-- State --}}
                        <div class="form-group">
                            <label class="mb-medium">State</label>
                            <select wire:model.live="state_id">
                                <option value="">All States</option>
                                @foreach($states as $state)
                                    <option value="{{ $state->id }}">{{ $state->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        {{-- City (Dynamic based on State) --}}
                        <div class="form-group">
                            <label class="mb-medium">City</label>
                            <select wire:model.live="city_id">
                                <option value="">All Cities</option>
                                @if($state_id)
                                    @foreach($cities as $city)
                                        <option value="{{ $city->id }}">{{ $city->name }}</option>
                                    @endforeach
                                @endif
                            </select>
                        </div>

                        {{-- Fuel Type --}}
                        <div class="form-group">
                            <label class="mb-medium">Fuel Type</label>
                            <select wire:model.live="fuel_type_id">
                                <option value="">All Fuel Types</option>
                                @foreach($fuelTypes as $fuel)
                                    <option value="{{ $fuel->id }}">{{ $fuel->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    {{-- Action Buttons --}}
                    <div class="flex">
                        <button type="button" class="btn btn-find-a-car-reset" wire:click="clearFilters">
                            <span wire:loading.remove wire:target="clearFilters">Reset</span>
                            <span wire:loading wire:target="clearFilters" class="flex items-center">
                                <svg class="animate-spin -ml-1 mr-2 h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                </svg>
                                Resetting
                            </span>
                        </button>
                        <button type="button" class="btn btn-primary btn-find-a-car-submit">
                            <span wire:loading.remove>Search</span>
                            <span wire:loading class="flex items-center">
                                <svg class="animate-spin -ml-1 mr-2 h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                </svg>
                                Searching
                            </span>
                        </button>
                    </div>

                </form>
            </section>
        </div>

        {{-- Results Section --}}
        <div class="search-cars-results">
            {{-- Loading Overlay --}}
            <div wire:loading.flex style="position: fixed; top: 0; left: 0; right: 0; bottom: 0; background: rgba(255,255,255,0.8); z-index: 9999; align-items: center; justify-content: center;">
                <div style="text-align: center;">
                    <svg class="animate-spin" style="width: 48px; height: 48px; color: var(--primary-color);" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                    <p style="margin-top: 1rem; color: var(--primary-color); font-weight: bold;">Searching...</p>
                </div>
            </div>

            {{-- Car Items Grid --}}
            <div class="car-items-listing" wire:loading.class="opacity-50">
                @forelse($cars as $car)
                    <div class="car-item card" style="transition: all 0.3s;">
                        <a href="{{ route('car.show', $car) }}">
                            @if($car->images->first())
                                <img src="{{ Storage::url($car->images->first()->image_path) }}"
                                     alt="{{ $car->year }} {{ $car->maker->name }} {{ $car->model->name }}"
                                     class="car-item-img rounded-t" />
                            @else
                                <div class="car-item-img rounded-t" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); display: flex; align-items: center; justify-content: center; color: white; font-size: 24px;">
                                    {{ $car->maker->name[0] }}{{ $car->model->name[0] }}
                                </div>
                            @endif
                        </a>
                        <div class="p-medium">
                            <div class="flex items-center justify-between">
                                <small class="m-0 text-muted">{{ $car->city->name }}, {{ $car->state->name }}</small>
                                <div class="flex items-center justify-between">
                                    <small class="m-0 text-muted">{{ $car->city->name }}, {{ $car->state->name }}</small>
                                    @livewire('car.favorite-button', ['car' => $car], key($car->id))
                                </div>

                                {{-- <button class="btn-heart" title="Add to favorites">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                        stroke-width="1.5" stroke="currentColor" style="width: 20px">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12Z" />
                                    </svg>
                                </button> --}}
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
                @empty
                    <div style="grid-column: 1 / -1; text-align: center; padding: 3rem;">
                        <svg style="width: 64px; height: 64px; margin: 0 auto; color: var(--text-muted-color);" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <h3 style="margin-top: 1rem; color: var(--text-color);">No cars found</h3>
                        <p style="color: var(--text-muted-color);">Try adjusting your search criteria or filters</p>
                        <button wire:click="clearFilters" class="btn btn-primary" style="margin-top: 1rem;">
                            Clear All Filters
                        </button>
                    </div>
                @endforelse
            </div>

            {{-- Pagination --}}
            @if($cars->hasPages())
                <nav class="pagination my-large">
                    {{-- First Page --}}
                    @if ($cars->onFirstPage())
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

                    {{-- Previous Page --}}
                    @if ($cars->onFirstPage())
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

                    {{-- Page Numbers --}}
                    @foreach(range(1, $cars->lastPage()) as $page)
                        @if($page == $cars->currentPage())
                            <span class="pagination-item active">{{ $page }}</span>
                        @else
                            <a href="#" wire:click.prevent="gotoPage({{ $page }})" class="pagination-item">{{ $page }}</a>
                        @endif
                    @endforeach

                    {{-- Next Page --}}
                    @if ($cars->hasMorePages())
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

                    {{-- Last Page --}}
                    @if ($cars->hasMorePages())
                        <a href="#" wire:click.prevent="gotoPage({{ $cars->lastPage() }})" class="pagination-item">
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
                        </a>
                    @endif
                </nav>
            @endif

        </div>
    </div>

</section>
