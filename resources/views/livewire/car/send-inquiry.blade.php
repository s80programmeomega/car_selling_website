<div>
    @if (session()->has('message'))
    <div class="success-message mb-medium">{{ session('message') }}</div>
    @endif

    <div class="card p-large">
        <h3 class="mb-medium" style="font-size: 1.25rem; font-weight: bold;">Contact Seller</h3>
        <form wire:submit.prevent="submit">
            <div class="form-group">
                <label>Name</label>
                <input wire:model="name" type="text" required placeholder="Your name">
                @error('name') <span class="text-error">{{ $message }}</span> @enderror
            </div>

            <div class="form-group">
                <label>Email</label>
                <input wire:model="email" type="email" required placeholder="Your email">
                @error('email') <span class="text-error">{{ $message }}</span> @enderror
            </div>

            <div class="form-group">
                <label>Phone (Optional)</label>
                <input wire:model="phone" type="text" placeholder="Your phone number">
                @error('phone') <span class="text-error">{{ $message }}</span> @enderror
            </div>

            <div class="form-group">
                <label>Message</label>
                <textarea wire:model="message" rows="4" required placeholder="I'm interested in this car..."></textarea>
                @error('message') <span class="text-error">{{ $message }}</span> @enderror
            </div>

            <button type="submit" class="btn btn-primary">
                Send Inquiry
            </button>
        </form>
    </div>
</div>
