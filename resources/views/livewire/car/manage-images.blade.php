<div class="container">
    <h1 class="car-details-page-title">
        Manage Images for: {{ $car->year }} - {{ $car->maker->name }} {{ $car->model->name }}
    </h1>

    @if (session()->has('message'))
        <div class="alert alert-success">{{ session('message') }}</div>
    @endif

    @if (session()->has('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <div class="car-images-wrapper">
        <!-- Update/Delete Existing Images -->
        <form wire:submit.prevent="updateImages" class="card p-medium form-update-images">
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Delete</th>
                            <th>Image</th>
                            <th>Position</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($images as $image)
                        <tr>
                            <td>
                                <input type="checkbox" wire:model="deleteImages" value="{{ $image->id }}" />
                            </td>
                            <td>
                                <img src="{{ asset('storage/' . $image->image_path) }}"
                                     alt=""
                                     class="my-cars-img-thumbnail"
                                     style="width: 120px" />
                            </td>
                            <td>
                                <input type="number"
                                       wire:model="positions.{{ $image->id }}"
                                       value="{{ $image->sort_order }}"
                                       style="width: 80px" />
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="p-medium" style="width: 100%">
                <div class="flex justify-end gap-1">
                    <button type="submit" class="btn btn-primary">Update Images</button>
                </div>
            </div>
        </form>

        <!-- Add New Images -->
        <form wire:submit.prevent="addImages" class="card form-images p-medium mb-large">
            <div class="form-image-upload">
                <div class="upload-placeholder">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" style="width: 48px">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M12 9v6m3-3H9m12 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                    </svg>
                </div>
                <input type="file" wire:model="newImages" multiple accept="image/*" />
            </div>

            @error('newImages.*') <span class="error">{{ $message }}</span> @enderror

            <div class="p-medium" style="width: 100%">
                <div class="flex justify-end gap-1">
                    <button type="submit" class="btn btn-primary">Add Images</button>
                </div>
            </div>
        </form>
    </div>
</div>
