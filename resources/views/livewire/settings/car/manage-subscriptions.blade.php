<div class="space-y-6">
    <div class="bg-white rounded-lg shadow p-6">
        <div class="flex justify-between items-center mb-4">
            <h2 class="text-xl font-semibold">Email Subscriptions</h2>
            <button wire:click="$toggle('showCreateForm')" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">
                + New Subscription
            </button>
        </div>

        @if (session()->has('message'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                {{ session('message') }}
            </div>
        @endif

        @if($showCreateForm)
            <div class="bg-gray-50 p-4 rounded-lg mb-6">
                <h3 class="font-medium mb-4">Create New Subscription</h3>
                <form wire:submit.prevent="createSubscription" class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium mb-1">Subscription Type</label>
                        <select wire:model="type" class="w-full border-gray-300 rounded-lg">
                            @foreach($types as $key => $label)
                                <option value="{{ $key }}">{{ $label }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-medium mb-1">Frequency</label>
                        <select wire:model="frequency" class="w-full border-gray-300 rounded-lg">
                            @foreach($frequencies as $key => $label)
                                <option value="{{ $key }}">{{ $label }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium mb-1">Maker (Optional)</label>
                            <select wire:model="maker_id" class="w-full border-gray-300 rounded-lg">
                                <option value="">All Makers</option>
                                @foreach($makers as $maker)
                                    <option value="{{ $maker->id }}">{{ $maker->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label class="block text-sm font-medium mb-1">State (Optional)</label>
                            <select wire:model="state_id" class="w-full border-gray-300 rounded-lg">
                                <option value="">All States</option>
                                @foreach($states as $state)
                                    <option value="{{ $state->id }}">{{ $state->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium mb-1">Min Price (Optional)</label>
                            <input type="number" wire:model="price_min" class="w-full border-gray-300 rounded-lg" placeholder="0">
                        </div>

                        <div>
                            <label class="block text-sm font-medium mb-1">Max Price (Optional)</label>
                            <input type="number" wire:model="price_max" class="w-full border-gray-300 rounded-lg" placeholder="100000">
                        </div>
                    </div>

                    <div class="flex gap-2">
                        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">
                            Create Subscription
                        </button>
                        <button type="button" wire:click="$toggle('showCreateForm')" class="bg-gray-300 text-gray-700 px-4 py-2 rounded-lg hover:bg-gray-400">
                            Cancel
                        </button>
                    </div>
                </form>
            </div>
        @endif

        <div class="space-y-3">
            @forelse($subscriptions as $subscription)
                <div class="border rounded-lg p-4 flex justify-between items-center">
                    <div>
                        <h4 class="font-medium">{{ $types[$subscription->type] }}</h4>
                        <p class="text-sm text-gray-600">{{ $frequencies[$subscription->frequency] }}</p>
                        @if($subscription->filters)
                            <p class="text-xs text-gray-500 mt-1">
                                Filters: {{ collect($subscription->filters)->count() }} applied
                            </p>
                        @endif
                    </div>
                    <div class="flex gap-2">
                        <button wire:click="toggleSubscription({{ $subscription->id }})"
                                class="px-3 py-1 rounded {{ $subscription->is_active ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-700' }}">
                            {{ $subscription->is_active ? 'Active' : 'Paused' }}
                        </button>
                        <button wire:click="deleteSubscription({{ $subscription->id }})"
                                class="px-3 py-1 rounded bg-red-100 text-red-700 hover:bg-red-200">
                            Delete
                        </button>
                    </div>
                </div>
            @empty
                <p class="text-gray-500 text-center py-8">No subscriptions yet. Create one to get started!</p>
            @endforelse
        </div>
    </div>
</div>
