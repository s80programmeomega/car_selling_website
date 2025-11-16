<?php

namespace App\Livewire\Admin;

use App\Models\CarModel;
use App\Models\Maker;
use Illuminate\Support\Facades\Cache;
use Livewire\Component;
use Livewire\WithPagination;

/**
 * Car Models CRUD Component
 * Manages car models with maker relationship
 */
class CarModels extends Component
{
    use WithPagination;

    public $name, $maker_id, $modelId;
    public $isEditing = false;
    public $search = '';

    protected $rules = [
        'name' => 'required|string|max:255',
        'maker_id' => 'required|exists:makers,id',
    ];

    public function create()
    {
        $this->validate();
        CarModel::create(['name' => $this->name, 'maker_id' => $this->maker_id]);
        Cache::tags(['dropdowns'])->forget("models-maker-{$this->maker_id}");
        $this->reset(['name', 'maker_id']);
        session()->flash('message', 'Model created successfully.');
    }

    public function edit($id)
    {
        $model = CarModel::findOrFail($id);
        $this->modelId = $id;
        $this->name = $model->name;
        $this->maker_id = $model->maker_id;
        $this->isEditing = true;
    }

    public function update()
    {
        $this->validate();
        $model = CarModel::findOrFail($this->modelId);
        $model->update(['name' => $this->name, 'maker_id' => $this->maker_id]);
        Cache::tags(['dropdowns'])->forget("models-maker-{$this->maker_id}");
        $this->reset(['name', 'maker_id', 'modelId', 'isEditing']);
        session()->flash('message', 'Model updated successfully.');
    }

    public function delete($id)
    {
        CarModel::findOrFail($id)->delete();
        session()->flash('message', 'Model deleted successfully.');
    }

    public function cancel()
    {
        $this->reset(['name', 'maker_id', 'modelId', 'isEditing']);
    }

    public function render()
    {
        return view('livewire.admin.car-models', [
            'models' => CarModel::with('maker')
                ->where('name', 'like', "%{$this->search}%")
                ->withCount('cars')
                ->latest()
                ->paginate(10),
            'makers' => Maker::orderBy('name')->get()
        ]);
    }
}
