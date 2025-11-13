<form wire:submit.prevent="search" class="find-a-car-form card flex p-medium">
    <div class="find-a-car-inputs">
        {{-- Maker --}}
        <div>
            <select wire:model.live="maker_id">
                <option value="">Maker</option>
                @foreach($makers as $maker)
                    <option value="{{ $maker->id }}">{{ $maker->name }}</option>
                @endforeach
            </select>
        </div>

        {{-- Model (Dynamic) --}}
        <div>
            <select wire:model.live="model_id">
                <option value="">Model</option>
                @foreach($models as $model)
                    <option value="{{ $model->id }}">{{ $model->name }}</option>
                @endforeach
            </select>
        </div>

        {{-- State --}}
        <div>
            <select wire:model.live="state_id">
                <option value="">State/Region</option>
                @foreach($states as $state)
                    <option value="{{ $state->id }}">{{ $state->name }}</option>
                @endforeach
            </select>
        </div>

        {{-- City (Dynamic) --}}
        <div>
            <select wire:model.live="city_id">
                <option value="">City</option>
                @foreach($cities as $city)
                    <option value="{{ $city->id }}">{{ $city->name }}</option>
                @endforeach
            </select>
        </div>

        {{-- Car Type --}}
        <div>
            <select wire:model.live="car_type_id">
                <option value="">Type</option>
                @foreach($carTypes as $type)
                    <option value="{{ $type->id }}">{{ $type->name }}</option>
                @endforeach
            </select>
        </div>

        {{-- Year From --}}
        <div>
            <input type="number" placeholder="Year From" wire:model.live.debounce.500ms="year_from" />
        </div>

        {{-- Year To --}}
        <div>
            <input type="number" placeholder="Year To" wire:model.live.debounce.500ms="year_to" />
        </div>

        {{-- Price From --}}
        <div>
            <input type="number" placeholder="Price From" wire:model.live.debounce.500ms="price_from" />
        </div>

        {{-- Price To --}}
        <div>
            <input type="number" placeholder="Price To" wire:model.live.debounce.500ms="price_to" />
        </div>

        {{-- Fuel Type --}}
        <div>
            <select wire:model.live="fuel_type_id">
                <option value="">Fuel Type</option>
                @foreach($fuelTypes as $fuel)
                    <option value="{{ $fuel->id }}">{{ $fuel->name }}</option>
                @endforeach
            </select>
        </div>
    </div>

    {{-- Action Buttons --}}
    <div>
        <button type="button" class="btn btn-find-a-car-reset" wire:click="resetForm">
            <span wire:loading.remove wire:target="resetForm">Reset</span>
            <span wire:loading wire:target="resetForm" class="flex items-center">
                <svg class="animate-spin -ml-1 mr-2 h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                Resetting
            </span>
        </button>

        <button type="submit" class="btn btn-primary btn-find-a-car-submit">
            <span wire:loading.remove wire:target="search">Search</span>
            <span wire:loading wire:target="search" class="flex items-center">
                <svg class="animate-spin -ml-1 mr-2 h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                Searching
            </span>
        </button>
    </div>
</form>
