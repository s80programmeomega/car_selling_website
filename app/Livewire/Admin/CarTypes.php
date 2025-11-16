<?php

namespace App\Livewire\Admin;

use App\Models\CarType;
use Livewire\Component;
use Livewire\WithPagination;

/**
 * Car Types CRUD Component
 * Manages vehicle types (Sedan, SUV, etc.)
 */
class CarTypes extends Component
{
    use WithPagination;

    public $name, $description, $typeId;
    public $isEditing = false;
    public $search = '';

    protected $rules = [
        'name' => 'required|string|max:255',
        'description' => 'nullable|string',
    ];

    public function create()
    {
        $this->validate();
        CarType::create(['name' => $this->name, 'description' => $this->description]);
        $this->reset(['name', 'description']);
        session()->flash('message', 'Car type created successfully.');
    }

    public function edit($id)
    {
        $type = CarType::findOrFail($id);
        $this->typeId = $id;
        $this->name = $type->name;
        $this->description = $type->description;
        $this->isEditing = true;
    }

    public function update()
    {
        $this->validate();
        CarType::findOrFail($this->typeId)->update(['name' => $this->name, 'description' => $this->description]);
        $this->reset(['name', 'description', 'typeId', 'isEditing']);
        session()->flash('message', 'Car type updated successfully.');
    }

    public function delete($id)
    {
        CarType::findOrFail($id)->delete();
        session()->flash('message', 'Car type deleted successfully.');
    }

    public function cancel()
    {
        $this->reset(['name', 'description', 'typeId', 'isEditing']);
    }

    public function render()
    {
        return view('livewire.admin.car-types', [
            'carTypes' => CarType::where('name', 'like', "%{$this->search}%")
                ->withCount('cars')
                ->latest()
                ->paginate(10)
        ]);
    }
}
