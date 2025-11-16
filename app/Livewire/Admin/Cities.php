<?php

namespace App\Livewire\Admin;

use App\Models\City;
use App\Models\State;
use Illuminate\Support\Facades\Cache;
use Livewire\Component;
use Livewire\WithPagination;

/**
 * Cities CRUD Component
 * Manages cities with state relationship
 */
class Cities extends Component
{
    use WithPagination;

    public $name, $state_id, $cityId;
    public $isEditing = false;
    public $search = '';

    protected $rules = [
        'name' => 'required|string|max:255',
        'state_id' => 'required|exists:states,id',
    ];

    public function create()
    {
        $this->validate();
        City::create(['name' => $this->name, 'state_id' => $this->state_id]);
        Cache::tags(['dropdowns'])->forget("cities-state-{$this->state_id}");
        $this->reset(['name', 'state_id']);
        session()->flash('message', 'City created successfully.');
    }

    public function edit($id)
    {
        $city = City::findOrFail($id);
        $this->cityId = $id;
        $this->name = $city->name;
        $this->state_id = $city->state_id;
        $this->isEditing = true;
    }

    public function update()
    {
        $this->validate();
        City::findOrFail($this->cityId)->update(['name' => $this->name, 'state_id' => $this->state_id]);
        Cache::tags(['dropdowns'])->forget("cities-state-{$this->state_id}");
        $this->reset(['name', 'state_id', 'cityId', 'isEditing']);
        session()->flash('message', 'City updated successfully.');
    }

    public function delete($id)
    {
        City::findOrFail($id)->delete();
        session()->flash('message', 'City deleted successfully.');
    }

    public function cancel()
    {
        $this->reset(['name', 'state_id', 'cityId', 'isEditing']);
    }

    public function render()
    {
        return view('livewire.admin.cities', [
            'cities' => City::with('state')
                ->where('name', 'like', "%{$this->search}%")
                ->withCount('cars')
                ->latest()
                ->paginate(10),
            'states' => State::orderBy('name')->get()
        ]);
    }
}
