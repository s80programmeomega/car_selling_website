<div class="p-6" x-data="{
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
    {{-- Loading Overlay --}}
    <div wire:loading.flex
        style="position: fixed; top: 0; left: 0; right: 0; bottom: 0; background: rgba(255,255,255,0.8); z-index: 9999; align-items: center; justify-content: center;">
        <div style="text-align: center;">
            <svg class="animate-spin text-blue-700" style="width: 48px; height: 48px;"
                xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4">
                </circle>
                <path class="opacity-75" fill="currentColor"
                    d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                </path>
            </svg>
            <p style="margin-top: 1rem; color: var(--primary-color); font-weight: bold;">Searching...</p>
        </div>
    </div>
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
