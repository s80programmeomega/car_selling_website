<?php

namespace App\Livewire\Car;

use App\Models\Car;
use App\Models\CarImage;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class ManageImages extends Component
{
    use WithFileUploads;

    public Car $car;
    public $images = [];
    public $newImages = [];
    public $deleteImages = [];
    public $positions = [];

    public function mount(Car $car)
    {
        $this->car = $car;
        $this->loadImages();
    }

    public function loadImages()
    {
        $this->images = $this->car->images()->orderBy('sort_order')->get();
        $this->positions = $this->images->pluck('sort_order', 'id')->toArray();
    }

    public function updateImages()
    {
        try {
            DB::beginTransaction();

            // Delete selected images
            if (!empty($this->deleteImages)) {
                foreach ($this->deleteImages as $imageId) {
                    $image = CarImage::find($imageId);
                    if ($image && $image->car_id === $this->car->id) {
                        Storage::disk('public')->delete($image->image_path);
                        $image->delete();
                    }
                }
            }

            // Update positions
            foreach ($this->positions as $imageId => $position) {
                CarImage::where('id', $imageId)
                    ->where('car_id', $this->car->id)
                    ->update(['sort_order' => $position]);
            }

            // Update is_primary (first image by sort_order)
            $this->car->images()->update(['is_primary' => false]);
            $firstImage = $this->car->images()->orderBy('sort_order')->first();
            if ($firstImage) {
                $firstImage->update(['is_primary' => true]);
            }

            DB::commit();

            $this->deleteImages = [];
            $this->loadImages();
            session()->flash('message', 'Images updated successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Failed to update images: ' . $e->getMessage());
            session()->flash('error', 'Failed to update images.');
        }
    }

    public function addImages()
    {
        $this->validate([
            'newImages.*' => 'image|max:2048',
        ]);

        try {
            DB::beginTransaction();

            $existingCount = $this->car->images()->count();
            foreach ($this->newImages as $index => $image) {
                $path = $image->store('cars', 'public');
                $this->car->images()->create([
                    'image_path' => $path,
                    'is_primary' => $existingCount === 0 && $index === 0,
                    'sort_order' => $existingCount + $index,
                ]);
            }

            DB::commit();

            $this->newImages = [];
            $this->loadImages();
            session()->flash('message', 'Images added successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Failed to add images: ' . $e->getMessage());
            session()->flash('error', 'Failed to add images.');
        }
    }

    public function render()
    {
        return view('livewire.car.manage-images');
    }
}
