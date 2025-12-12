<div class="p-6">
    <div class="flex items-center justify-between mb-6">
        <h2 class="text-2xl font-bold">Contact Messages</h2>
        <span class="bg-red-500 text-white px-3 py-1 rounded">{{ $unreadCount }} Unread</span>
    </div>

    @if (session()->has('message'))
    <div class="mb-4 p-4 bg-green-100 text-green-700 rounded">{{ session('message') }}</div>
    @endif

    <div class="flex gap-4 mb-4">
        <input wire:model.live="search" type="text" placeholder="Search messages..."
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
                    <th class="px-4 py-2 text-left">Name</th>
                    <th class="px-4 py-2 text-left">Email</th>
                    <th class="px-4 py-2 text-left">Subject</th>
                    <th class="px-4 py-2 text-left">Message</th>
                    <th class="px-4 py-2 text-left">Date</th>
                    <th class="px-4 py-2 text-left">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($messages as $message)
                <tr class="border-t {{ !$message->is_read ? 'bg-blue-50' : '' }}">
                    <td class="px-4 py-2">
                        @if($message->is_read)
                        <span class="bg-green-100 text-green-800 px-2 py-1 rounded text-xs">Read</span>
                        @else
                        <span class="bg-yellow-100 text-yellow-800 px-2 py-1 rounded text-xs">Unread</span>
                        @endif
                    </td>
                    <td class="px-4 py-2">{{ $message->name }}</td>
                    <td class="px-4 py-2">{{ $message->email }}</td>
                    <td class="px-4 py-2">{{ Str::limit($message->subject, 30) }}</td>
                    <td class="px-4 py-2">{{ Str::limit($message->message, 50) }}</td>
                    <td class="px-4 py-2">{{ $message->created_at->format('M d, Y') }}</td>
                    <td class="px-4 py-2">
                        {{-- Add View button in Actions --}}
                        <button wire:click="view({{ $message->id }})"
                            class="text-green-500 hover:underline mr-2">View</button>
                        @if(!$message->is_read)
                        <button wire:click="markAsRead({{ $message->id }})"
                            class="text-blue-500 hover:underline mr-2">Mark Read</button>
                        @else
                        <button wire:click="markAsUnread({{ $message->id }})"
                            class="text-blue-500 hover:underline mr-2">Mark Unread</button>
                        @endif
                        <button wire:click="delete({{ $message->id }})" onclick="return confirm('Are you sure?')"
                            class="text-red-500 hover:underline">Delete</button>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="px-4 py-8 text-center text-gray-500">No messages found</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">{{ $messages->links() }}</div>

    {{-- modal to view contact message --}}
    @if($viewingMessage)
    <div class="fixed inset-0 flex items-center justify-center z-50" style="background-color: rgba(0, 0, 0, 0.5);"
        wire:click="closeView">

        <div class="bg-white rounded-lg p-6 max-w-2xl w-full mx-4" wire:click.stop>
            <h3 class="text-xl font-bold mb-4">Message Details</h3>
            <div class="space-y-3">
                <div><strong>From:</strong> {{ $viewingMessage->name }}</div>
                <div><strong>Email:</strong> {{ $viewingMessage->email }}</div>
                <div><strong>Subject:</strong> {{ $viewingMessage->subject }}</div>
                <div><strong>Message:</strong><br>{{ $viewingMessage->message }}</div>
                <div><strong>Date:</strong> {{ $viewingMessage->created_at->format('M d, Y h:i A') }}</div>
            </div>
            <button wire:click="closeView"
                class="mt-4 bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600">Close</button>
        </div>
    </div>
    @endif
</div>
