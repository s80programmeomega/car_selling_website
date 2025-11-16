<?php

namespace App\Livewire\Admin;

use App\Models\Feature;
use Livewire\Component;
use Livewire\WithPagination;

/**
 * Features CRUD Component
 * Manages car features (GPS, Sunroof, etc.)
 */
class Features extends Component
{
    use WithPagination;

    public $name, $description, $category, $featureId;
    public $isEditing = false;
    public $search = '';

    protected $rules = [
        'name' => 'required|string|max:255',
        'description' => 'nullable|string',
        'category' => 'nullable|string|max:255',
    ];

    public function create()
    {
        $this->validate();
        Feature::create([
            'name' => $this->name,
            'description' => $this->description,
            'category' => $this->category
        ]);
        $this->reset(['name', 'description', 'category']);
        session()->flash('message', 'Feature created successfully.');
    }

    public function edit($id)
    {
        $feature = Feature::findOrFail($id);
        $this->featureId = $id;
        $this->name = $feature->name;
        $this->description = $feature->description;
        $this->category = $feature->category;
        $this->isEditing = true;
    }

    public function update()
    {
        $this->validate();
        Feature::findOrFail($this->featureId)->update([
            'name' => $this->name,
            'description' => $this->description,
            'category' => $this->category
        ]);
        $this->reset(['name', 'description', 'category', 'featureId', 'isEditing']);
        session()->flash('message', 'Feature updated successfully.');
    }

    public function delete($id)
    {
        Feature::findOrFail($id)->delete();
        session()->flash('message', 'Feature deleted successfully.');
    }

    public function cancel()
    {
        $this->reset(['name', 'description', 'category', 'featureId', 'isEditing']);
    }

    public function render()
    {
        return view('livewire.admin.features', [
            'features' => Feature::where('name', 'like', "%{$this->search}%")
                ->orWhere('category', 'like', "%{$this->search}%")
                ->withCount('cars')
                ->latest()
                ->paginate(10)
        ]);
    }
}
