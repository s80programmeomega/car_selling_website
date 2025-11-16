<?php

namespace App\Livewire\Admin;

use App\Models\State;
use Livewire\Component;
use Livewire\WithPagination;

/**
 * States CRUD Component
 * Manages geographical states
 */
class States extends Component
{
    use WithPagination;

    public $name, $code, $stateId;
    public $isEditing = false;
    public $search = '';

    protected $rules = [
        'name' => 'required|string|max:255',
        'code' => 'required|string|max:10',
    ];

    public function create()
    {
        $this->validate();
        State::create(['name' => $this->name, 'code' => $this->code]);
        $this->reset(['name', 'code']);
        session()->flash('message', 'State created successfully.');
    }

    public function edit($id)
    {
        $state = State::findOrFail($id);
        $this->stateId = $id;
        $this->name = $state->name;
        $this->code = $state->code;
        $this->isEditing = true;
    }

    public function update()
    {
        $this->validate();
        State::findOrFail($this->stateId)->update(['name' => $this->name, 'code' => $this->code]);
        $this->reset(['name', 'code', 'stateId', 'isEditing']);
        session()->flash('message', 'State updated successfully.');
    }

    public function delete($id)
    {
        State::findOrFail($id)->delete();
        session()->flash('message', 'State deleted successfully.');
    }

    public function cancel()
    {
        $this->reset(['name', 'code', 'stateId', 'isEditing']);
    }

    public function render()
    {
        return view('livewire.admin.states', [
            'states' => State::where('name', 'like', "%{$this->search}%")
                ->withCount(['cities', 'cars'])
                ->latest()
                ->paginate(10)
        ]);
    }
}
