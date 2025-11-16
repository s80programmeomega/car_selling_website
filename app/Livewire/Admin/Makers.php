<?php

namespace App\Livewire\Admin;

use App\Models\Maker;
use Illuminate\Support\Facades\Cache;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;

/**
 * Makers CRUD Component
 * Manages car manufacturers with inline editing
 */
class Makers extends Component
{
    use WithPagination, WithFileUploads;

    public $name, $logo, $makerId;
    public $isEditing = false;
    public $search = '';

    protected $rules = [
        'name' => 'required|string|max:255',
        'logo' => 'nullable|image',
        // 'logo' => 'nullable|image|max:1024',
    ];

    public function create()
    {
        $this->validate();

        $data = ['name' => $this->name];
        if ($this->logo) {
            $data['logo'] = $this->logo->store('makers', 'public');
        }

        Maker::create($data);
        $this->reset(['name', 'logo']);
        session()->flash('message', 'Maker created successfully.');
    }

    public function edit($id)
    {
        $maker = Maker::findOrFail($id);
        $this->makerId = $id;
        $this->name = $maker->name;
        $this->isEditing = true;
    }

    public function update()
    {
        $this->validate();

        $maker = Maker::findOrFail($this->makerId);
        $data = ['name' => $this->name];

        if ($this->logo) {
            $data['logo'] = $this->logo->store('makers', 'public');
        }

        $maker->update($data);
        $this->reset(['name', 'logo', 'makerId', 'isEditing']);
        session()->flash('message', 'Maker updated successfully.');
    }

    public function delete($id)
    {
        Maker::findOrFail($id)->delete();
        session()->flash('message', 'Maker deleted successfully.');
    }

    public function cancel()
    {
        $this->reset(['name', 'logo', 'makerId', 'isEditing']);
    }

    public function render()
    {
        return view('livewire.admin.makers', [
            'makers' => Maker::where('name', 'like', "%{$this->search}%")
                ->withCount('cars')
                ->latest()
                ->paginate(10)
        ]);
    }
}
