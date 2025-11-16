<div>
    <div class="bg-white rounded-lg shadow p-6 mb-4">
        <div class="flex items-center justify-between">
            <div>
                <h3 class="text-xl font-bold">Reviews</h3>
                <p class="text-sm text-gray-600">
                    {{ number_format($averageRating, 1) }} ★ ({{ $totalReviews }} reviews)
                </p>
            </div>
        </div>
    </div>

    @forelse($reviews as $review)
        <div class="bg-white rounded-lg shadow p-6 mb-4">
            <div class="flex items-start justify-between">
                <div class="flex-1">
                    <div class="flex items-center gap-2 mb-2">
                        <h4 class="font-semibold">{{ $review->reviewer->username }}</h4>
                        <span class="text-yellow-400">
                            @for($i = 1; $i <= 5; $i++)
                                {{ $i <= $review->rating ? '★' : '☆' }}
                            @endfor
                        </span>
                    </div>
                    <p class="text-gray-700">{{ $review->comment }}</p>
                </div>
                <span class="text-sm text-gray-500">{{ $review->created_at->diffForHumans() }}</span>
            </div>
        </div>
    @empty
        <div class="bg-white rounded-lg shadow p-6">
            <p class="text-gray-500 text-center">No reviews yet. Be the first to review!</p>
        </div>
    @endforelse

    <div class="mt-4">{{ $reviews->links() }}</div>
</div>
