<div>
    @auth
        <button
            wire:click="toggleSubscription"
            class="btn {{ $isSubscribed ? 'btn-success' : 'btn-primary' }}"
            style="width: 100%;">
            {{ $isSubscribed ? '✓ Subscribed' : 'Subscribe to Newsletter' }}
        </button>
        @if($message)
            <p style="margin-top: 8px; font-size: 13px; color: #22c55e;">{{ $message }}</p>
        @endif
    @else
        <form class="footer-newsletter">
            <input type="email" placeholder="Your email address" class="footer-input" readonly />
            <a href="{{ route('login') }}" class="btn btn-primary">Login to Subscribe</a>
        </form>
        <p style="margin-top: 8px; font-size: 12px; color: #888;">Login required to subscribe</p>
    @endauth
</div>
