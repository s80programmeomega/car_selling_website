<div class="p-6"x-data="{
    pendingRefresh: false,
    setupEcho() {
        if (window.Echo) {
            window.Echo.channel('cars')
                .listen('CarDataChanged', (e) => {
                    if (!document.hidden) {
                        $wire.$refresh();
                    } else {
                        this.pendingRefresh = true;
                    }
                });
        }
    }
}" x-init="
    setupEcho();
    document.addEventListener('visibilitychange', () => {
        if (!document.hidden && pendingRefresh) {
            $wire.$refresh();
            pendingRefresh = false;
        }
    });
">
    <div class="flex items-center justify-between mb-6">
        <div>
            <h2 class="text-2xl font-bold">Manage Reviews</h2>
            <p class="text-sm text-gray-600">
                Average: {{ number_format($averageRating, 1) }} ★ | Total: {{ $totalReviews }}
            </p>
        </div>
    </div>

    @if (session()->has('message'))
    <div class="mb-4 p-4 bg-green-100 text-green-700 rounded">{{ session('message') }}</div>
    @endif

    <div class="flex gap-4 mb-4">
        <input wire:model.live="search" type="text" placeholder="Search reviews..."
            class="flex-1 border rounded px-3 py-2">
        <select wire:model.live="filterRating" class="border rounded px-3 py-2">
            <option value="">All Ratings</option>
            <option value="5">5 Stars</option>
            <option value="4">4 Stars</option>
            <option value="3">3 Stars</option>
            <option value="2">2 Stars</option>
            <option value="1">1 Star</option>
        </select>
    </div>

    <div class="bg-white rounded shadow overflow-hidden">
        <table class="w-full">
            <thead class="bg-gray-100">
                <tr>
                    <th class="px-4 py-2 text-left">Reviewer</th>
                    <th class="px-4 py-2 text-left">Seller</th>
                    <th class="px-4 py-2 text-left">Car</th>
                    <th class="px-4 py-2 text-left">Rating</th>
                    <th class="px-4 py-2 text-left">Comment</th>
                    <th class="px-4 py-2 text-left">Date</th>
                    <th class="px-4 py-2 text-left">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($reviews as $review)
                <tr class="border-t">
                    <td class="px-4 py-2">{{ $review->reviewer->username }}</td>
                    <td class="px-4 py-2">{{ $review->seller->name }}</td>
                    <td class="px-4 py-2">
                        @if($review->car)
                        {{ $review->car->maker->name }} {{ $review->car->model->name }}
                        @else
                        <span class="text-gray-400">N/A</span>
                        @endif
                    </td>
                    <td class="px-4 py-2">
                        <span class="text-yellow-400">
                            @for($i = 1; $i <= 5; $i++) {{ $i <=$review->rating ? '★' : '☆' }}
                                @endfor
                        </span>
                    </td>
                    <td class="px-4 py-2">{{ Str::limit($review->comment, 50) }}</td>
                    <td class="px-4 py-2">{{ $review->created_at->format('M d, Y') }}</td>
                    <td class="px-4 py-2">
                        <button wire:click="delete({{ $review->id }})" onclick="return confirm('Are you sure?')"
                            class="text-red-500 hover:underline">Delete</button>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="mt-4">{{ $reviews->links() }}</div>
</div>
