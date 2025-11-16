<div class="p-6">
    <div class="mb-6">
        <h2 class="text-2xl font-bold">Manage Fuel Types</h2>
    </div>

    @if (session()->has('message'))
        <div class="mb-4 p-4 bg-green-100 text-green-700 rounded">
            {{ session('message') }}
        </div>
    @endif

    <!-- Create/Edit Form -->
    <div class="mb-6 p-4 bg-white rounded shadow">
        <h3 class="text-lg font-semibold mb-4">{{ $isEditing ? 'Edit' : 'Create' }} Fuel Type</h3>
        <form wire:submit.prevent="{{ $isEditing ? 'update' : 'create' }}">
            <div class="mb-4">
                <label class="block mb-2">Name</label>
                <input type="text" wire:model="name" placeholder="Enter fuel type name" class="w-full border rounded px-3 py-2">
                @error('name') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>
            <div class="mb-4">
                <label class="block mb-2">Description</label>
                <textarea wire:model="description" placeholder="Enter description" rows="3" class="w-full border rounded px-3 py-2"></textarea>
                @error('description') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>
            <div class="flex gap-2">
                <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
                    {{ $isEditing ? 'Update' : 'Create' }}
                </button>
                @if($isEditing)
                    <button type="button" wire:click="cancel" class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600">
                        Cancel
                    </button>
                @endif
            </div>
        </form>
    </div>

    <!-- Search -->
    <div class="mb-4">
        <input type="text" wire:model.live="search" placeholder="Search fuel types..." class="w-full border rounded px-3 py-2">
    </div>

    <!-- List -->
    <div class="bg-white rounded shadow overflow-hidden">
        <table class="w-full">
            <thead class="bg-gray-100">
                <tr>
                    <th class="px-4 py-2 text-left">Name</th>
                    <th class="px-4 py-2 text-left">Description</th>
                    <th class="px-4 py-2 text-left">Cars Count</th>
                    <th class="px-4 py-2 text-left">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($fuelTypes as $fuelType)
                    <tr class="border-t">
                        <td class="px-4 py-2">{{ $fuelType->name }}</td>
                        <td class="px-4 py-2">{{ Str::limit($fuelType->description, 50) }}</td>
                        <td class="px-4 py-2">{{ $fuelType->cars_count }}</td>
                        <td class="px-4 py-2">
                            <button wire:click="edit({{ $fuelType->id }})" class="text-blue-500 hover:underline mr-2">Edit</button>
                            <button wire:click="delete({{ $fuelType->id }})" onclick="return confirm('Are you sure?')" class="text-red-500 hover:underline">Delete</button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="mt-4">{{ $fuelTypes->links() }}</div>
</div>
