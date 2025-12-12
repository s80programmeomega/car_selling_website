<div>
    <form wire:submit.prevent="subscribe" class="footer-newsletter">
        <input
            type="email"
            wire:model="email"
            placeholder="Your email address"
            class="footer-input"
            required
        />
        <button type="submit" class="btn btn-primary" wire:loading.attr="disabled">
            <span wire:loading.remove>Subscribe</span>
            <span wire:loading>...</span>
        </button>
    </form>

    @if($message)
        <div style="margin-top: 12px; padding: 8px 12px; border-radius: 6px; font-size: 13px;
            @if($messageType === 'success') background: rgba(34, 197, 94, 0.1); color: #22c55e; border: 1px solid rgba(34, 197, 94, 0.3);
            @elseif($messageType === 'error') background: rgba(239, 68, 68, 0.1); color: #ef4444; border: 1px solid rgba(239, 68, 68, 0.3);
            @else background: rgba(59, 130, 246, 0.1); color: #3b82f6; border: 1px solid rgba(59, 130, 246, 0.3);
            @endif">
            {{ $message }}
        </div>
    @endif
</div>
