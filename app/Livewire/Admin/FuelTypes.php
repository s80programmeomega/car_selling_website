<?php

namespace App\Livewire\Admin;

use App\Models\FuelType;
use Livewire\Component;
use Livewire\WithPagination;

/**
 * Fuel Types CRUD Component
 * Manages fuel types (Gasoline, Diesel, Electric, etc.)
 */
class FuelTypes extends Component
{
    use WithPagination;

    public $name, $description, $fuelTypeId;
    public $isEditing = false;
    public $search = '';

    protected $rules = [
        'name' => 'required|string|max:255',
        'description' => 'nullable|string',
    ];

    public function create()
    {
        $this->validate();
        FuelType::create(['name' => $this->name, 'description' => $this->description]);
        $this->reset(['name', 'description']);
        session()->flash('message', 'Fuel type created successfully.');
    }

    public function edit($id)
    {
        $fuelType = FuelType::findOrFail($id);
        $this->fuelTypeId = $id;
        $this->name = $fuelType->name;
        $this->description = $fuelType->description;
        $this->isEditing = true;
    }

    public function update()
    {
        $this->validate();
        FuelType::findOrFail($this->fuelTypeId)->update(['name' => $this->name, 'description' => $this->description]);
        $this->reset(['name', 'description', 'fuelTypeId', 'isEditing']);
        session()->flash('message', 'Fuel type updated successfully.');
    }

    public function delete($id)
    {
        FuelType::findOrFail($id)->delete();
        session()->flash('message', 'Fuel type deleted successfully.');
    }

    public function cancel()
    {
        $this->reset(['name', 'description', 'fuelTypeId', 'isEditing']);
    }

    public function render()
    {
        return view('livewire.admin.fuel-types', [
            'fuelTypes' => FuelType::where('name', 'like', "%{$this->search}%")
                ->withCount('cars')
                ->latest()
                ->paginate(10)
        ]);
    }
}
