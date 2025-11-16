<div>
    @if (session()->has('message'))
    <div class="success-message mb-medium">{{ session('message') }}</div>
    @endif

    <div class="card p-large">
        <h3 class="mb-medium" style="font-size: 1.25rem; font-weight: bold;">Write a Review</h3>
        <form wire:submit.prevent="submit">
            <div class="form-group">
                <label>Pick Your Rating</label>
                <div class="flex gap-1">
                    @for($i = 1; $i <= 5; $i++)
                    <button type="button" wire:click="$set('rating', {{ $i }})"
                        style="font-size: 1.875rem; color: {{ $rating >= $i ? '#fbbf24' : '#d1d5db' }}; background: none; border: none; cursor: pointer; padding: 0;">
                        ★
                    </button>
                    @endfor
                </div>
                @error('rating') <span class="text-error">{{ $message }}</span> @enderror
            </div>

            <div class="form-group">
                <label>Comment (Optional)</label>
                <textarea wire:model="comment" rows="4" placeholder="Share your experience..."></textarea>
                @error('comment') <span class="text-error">{{ $message }}</span> @enderror
            </div>

            <button type="submit" class="btn btn-primary">
                Submit Review
            </button>
        </form>
    </div>
</div>
