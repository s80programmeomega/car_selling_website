<div class="container-small">
    <h1 class="car-details-page-title">Add new car</h1>
    <form wire:submit.prevent="save" enctype="multipart/form-data" class="card add-new-car-form">
        <div class="form-content">
            <div class="form-details">
                <div class="row">
                    <div class="col">
                        <div class="form-group">
                            <label>Maker</label>
                            <select wire:model.live="maker_id">
                                <option value="">Maker</option>
                                @foreach($makers as $maker)
                                <option value="{{ $maker->id }}">{{ $maker->name }}</option>
                                @endforeach
                            </select>
                            @error('maker_id') <span class="error">{{ $message }}</span> @enderror
                        </div>
                    </div>
                    <div class="col">
                        <div class="form-group">
                            <label>Model</label>
                            <select wire:model="model_id">
                                <option value="">Model</option>
                                @foreach($models as $model)
                                <option value="{{ $model->id }}">{{ $model->name }}</option>
                                @endforeach
                            </select>
                            @error('model_id') <span class="error">{{ $message }}</span> @enderror
                        </div>
                    </div>
                    <div class="col">
                        <div class="form-group">
                            <label>Year</label>
                            <select wire:model="year">
                                <option value="">Year</option>
                                @for($y = 2025; $y >= 1990; $y--)
                                <option value="{{ $y }}">{{ $y }}</option>
                                @endfor
                            </select>
                            @error('year') <span class="error">{{ $message }}</span> @enderror
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label>Car Type</label>
                    <div class="row">
                        @foreach($carTypes as $type)
                        <div class="col">
                            <label class="inline-radio">
                                <input type="radio" wire:model="car_type_id" value="{{ $type->id }}" />
                                {{ $type->name }}
                            </label>
                        </div>
                        @endforeach
                    </div>
                    @error('car_type_id') <span class="error">{{ $message }}</span> @enderror
                </div>
                <div class="form-group">
                    <label>Condition</label>
                    <div class="row">
                        <div class="col">
                            <label class="inline-radio">
                                <input type="radio" wire:model="condition" value="new" />
                                New
                            </label>
                        </div>
                        <div class="col">
                            <label class="inline-radio">
                                <input type="radio" wire:model="condition" value="used" />
                                Used
                            </label>
                        </div>
                        <div class="col">
                            <label class="inline-radio">
                                <input type="radio" wire:model="condition" value="certified" />
                                Certified
                            </label>
                        </div>
                    </div>
                    @error('condition') <span class="error">{{ $message }}</span> @enderror
                </div>
                <div class="row">
                    <div class="col">
                        <div class="form-group">
                            <label>Price</label>
                            <input type="number" wire:model="price" placeholder="Price" />
                            @error('price') <span class="error">{{ $message }}</span> @enderror
                        </div>
                    </div>
                    <div class="col">
                        <div class="form-group">
                            <label>Vin Code</label>
                            <input wire:model="vin_code" placeholder="Vin Code" />
                            @error('vin_code') <span class="error">{{ $message }}</span> @enderror
                        </div>
                    </div>
                    <div class="col">
                        <div class="form-group">
                            <label>Mileage (ml)</label>
                            <input type="number" wire:model="mileage" placeholder="Mileage" />
                            @error('mileage') <span class="error">{{ $message }}</span> @enderror
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col">
                        <div class="form-group">
                            <label>Color</label>
                            <input wire:model="color" placeholder="Exterior Color" />
                        </div>
                    </div>
                    <div class="col">
                        <div class="form-group">
                            <label>Interior Color</label>
                            <input wire:model="interior_color" placeholder="Interior Color" />
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col">
                        <div class="form-group">
                            <label>Doors</label>
                            <input type="number" wire:model="doors" placeholder="Number of Doors" />
                        </div>
                    </div>
                    <div class="col">
                        <div class="form-group">
                            <label>Seats</label>
                            <input type="number" wire:model="seats" placeholder="Number of Seats" />
                        </div>
                    </div>
                    <div class="col">
                        <div class="form-group">
                            <label>Engine Size</label>
                            <input wire:model="engine_size" placeholder="e.g., 2.0L" />
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label>Fuel Type</label>
                    <div class="row">
                        @foreach($fuelTypes as $fuel)
                        <div class="col">
                            <label class="inline-radio">
                                <input type="radio" wire:model="fuel_type_id" value="{{ $fuel->id }}" />
                                {{ $fuel->name }}
                            </label>
                        </div>
                        @endforeach
                    </div>
                    @error('fuel_type_id') <span class="error">{{ $message }}</span> @enderror
                </div>
                <div class="form-group">
                    <label>Transmission</label>
                    <div class="row">
                        <div class="col">
                            <label class="inline-radio">
                                <input type="radio" wire:model="transmission" value="automatic" />
                                Automatic
                            </label>
                        </div>
                        <div class="col">
                            <label class="inline-radio">
                                <input type="radio" wire:model="transmission" value="manual" />
                                Manual
                            </label>
                        </div>
                    </div>
                    @error('transmission') <span class="error">{{ $message }}</span> @enderror
                </div>
                <div class="row">
                    <div class="col">
                        <div class="form-group">
                            <label>Number of Owners</label>
                            <input type="number" wire:model="number_of_owners" placeholder="Number of Previous Owners" />
                        </div>
                    </div>
                    <div class="col">
                        <div class="form-group">
                            <label class="checkbox">
                                <input type="checkbox" wire:model="accident_history" />
                                Accident History
                            </label>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col">
                        <div class="form-group">
                            <label>State/Region</label>
                            <select wire:model.live="state_id">
                                <option value="">State/Region</option>
                                @foreach($states as $state)
                                <option value="{{ $state->id }}">{{ $state->name }}</option>
                                @endforeach
                            </select>
                            @error('state_id') <span class="error">{{ $message }}</span> @enderror
                        </div>
                    </div>
                    <div class="col">
                        <div class="form-group">
                            <label>City</label>
                            <select wire:model="city_id">
                                <option value="">City</option>
                                @foreach($cities as $city)
                                <option value="{{ $city->id }}">{{ $city->name }}</option>
                                @endforeach
                            </select>
                            @error('city_id') <span class="error">{{ $message }}</span> @enderror
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col">
                        <div class="form-group">
                            <label>Address</label>
                            <input wire:model="address" placeholder="Address" />
                            @error('address') <span class="error">{{ $message }}</span> @enderror
                        </div>
                    </div>
                    <div class="col">
                        <div class="form-group">
                            <label>Phone</label>
                            <input wire:model="phone" placeholder="Phone" />
                            @error('phone') <span class="error">{{ $message }}</span> @enderror
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="row">
                        @php
                        $half = ceil($allFeatures->count() / 2);
                        @endphp
                        <div class="col">
                            @foreach($allFeatures->take($half) as $feature)
                            <label class="checkbox">
                                <input type="checkbox" wire:model="features" value="{{ $feature->id }}" />
                                {{ $feature->name }}
                            </label>
                            @endforeach
                        </div>
                        <div class="col">
                            @foreach($allFeatures->skip($half) as $feature)
                            <label class="checkbox">
                                <input type="checkbox" wire:model="features" value="{{ $feature->id }}" />
                                {{ $feature->name }}
                            </label>
                            @endforeach
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label>Detailed Description</label>
                    <textarea wire:model="description" rows="10"></textarea>
                </div>
                <div class="form-group">
                    <label>Status</label>
                    <select wire:model="status">
                        <option value="available">Available</option>
                        <option value="pending">Pending</option>
                        <option value="sold">Sold</option>
                    </select>
                </div>
                <div class="form-group">
                    <label class="checkbox">
                        <input type="checkbox" wire:model="published" />
                        Published
                    </label>
                    <label class="checkbox">
                        <input type="checkbox" wire:model="featured" />
                        Featured
                    </label>
                </div>
            </div>
            <div class="form-images">
                <div class="form-image-upload">
                    <div class="upload-placeholder">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" style="width: 48px">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M12 9v6m3-3H9m12 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                        </svg>
                    </div>
                    <input id="carFormImageUpload" type="file" wire:model="images" multiple />
                </div>
                <div id="imagePreviews" class="car-form-images"></div>
            </div>
        </div>
        <div class="p-medium" style="width: 100%">
            <div class="flex justify-end gap-1">
                <button type="button" wire:click="resetForm" class="btn btn-default">Reset</button>
                <button type="submit" class="btn btn-primary">Submit</button>
            </div>
        </div>
    </form>
</div>
