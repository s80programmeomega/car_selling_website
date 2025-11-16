<div class="p-6">
    <div class="flex items-center justify-between mb-6">
        <h2 class="text-2xl font-bold">Car Inquiries</h2>
        <span class="bg-red-500 text-white px-3 py-1 rounded">{{ $unreadCount }} Unread</span>
    </div>

    @if (session()->has('message'))
    <div class="mb-4 p-4 bg-green-100 text-green-700 rounded">{{ session('message') }}</div>
    @endif

    <div class="flex gap-4 mb-4">
        <input wire:model.live="search" type="text" placeholder="Search inquiries..."
            class="flex-1 border rounded px-3 py-2">
        <select wire:model.live="filter" class="border rounded px-3 py-2">
            <option value="all">All</option>
            <option value="unread">Unread</option>
            <option value="read">Read</option>
        </select>
    </div>

    <div class="bg-white rounded shadow overflow-hidden">
        <table class="w-full">
            <thead class="bg-gray-100">
                <tr>
                    <th class="px-4 py-2 text-left">Status</th>
                    <th class="px-4 py-2 text-left">Car</th>
                    <th class="px-4 py-2 text-left">From</th>
                    <th class="px-4 py-2 text-left">Message</th>
                    <th class="px-4 py-2 text-left">Date</th>
                    <th class="px-4 py-2 text-left">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($inquiries as $inquiry)
                <tr class="border-t {{ !$inquiry->is_read ? 'bg-blue-50' : '' }}">
                    <td class="px-4 py-2">
                        @if($inquiry->is_read)
                        <span class="bg-green-100 text-green-800 px-2 py-1 rounded text-xs">Read</span>
                        @else
                        <span class="bg-yellow-100 text-yellow-800 px-2 py-1 rounded text-xs">Unread</span>
                        @endif
                    </td>
                    <td class="px-4 py-2">{{ $inquiry->car->maker->name }} {{ $inquiry->car->model->name }}</td>
                    <td class="px-4 py-2">
                        <div>{{ $inquiry->name }}</div>
                        <div class="text-sm text-gray-500">{{ $inquiry->email }}</div>
                        @if($inquiry->phone)
                        <div class="text-sm text-gray-500">{{ $inquiry->phone }}</div>
                        @endif
                    </td>
                    <td class="px-4 py-2">{{ Str::limit($inquiry->message, 50) }}</td>
                    <td class="px-4 py-2">{{ $inquiry->created_at->format('M d, Y') }}</td>
                    <td class="px-4 py-2">
                        @if(!$inquiry->is_read)
                        <button wire:click="markAsRead({{ $inquiry->id }})"
                            class="text-blue-500 hover:underline mr-2">Mark Read</button>
                        @else
                        <button wire:click="markAsUnread({{ $inquiry->id }})"
                            class="text-blue-500 hover:underline mr-2">Mark Unread</button>
                        @endif
                        <button wire:click="delete({{ $inquiry->id }})" onclick="return confirm('Are you sure?')"
                            class="text-red-500 hover:underline">Delete</button>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="mt-4">{{ $inquiries->links() }}</div>
</div>