
<div>
    @if (session()->has('success'))
    <div class="card" style="background: #d4edda; border-color: #c3e6cb; color: #155724; margin-bottom: 1.5rem;">
        <p class="m-0">{{ session('success') }}</p>
    </div>
    @endif

    @if (session()->has('error'))
    <div class="card" style="background: #f8d7da; border-color: #f5c6cb; color: #721c24; margin-bottom: 1.5rem;">
        <p class="m-0">{{ session('error') }}</p>
    </div>
    @endif

    <form wire:submit.prevent="submit" class="card">
        <div class="form-group @error('name') has-error @enderror">
            <label for="name">Name <span style="color: red;">*</span></label>
            <input type="text" id="name" wire:model="name" placeholder="Your full name">
            @error('name') <span class="text-danger">{{ $message }}</span> @enderror
        </div>

        <div class="form-group @error('email') has-error @enderror">
            <label for="email">Email <span style="color: red;">*</span></label>
            <input type="email" id="email" wire:model="email" placeholder="your.email@example.com">
            @error('email') <span class="text-danger">{{ $message }}</span> @enderror
        </div>

        <div class="form-group @error('subject') has-error @enderror">
            <label for="subject">Subject <span style="color: red;">*</span></label>
            <input type="text" id="subject" wire:model="subject" placeholder="What is this about?">
            @error('subject') <span class="text-danger">{{ $message }}</span> @enderror
        </div>

        <div class="form-group @error('message') has-error @enderror">
            <label for="message">Message <span style="color: red;">*</span></label>
            <textarea id="message" wire:model="message" rows="6" placeholder="Your message..."></textarea>
            @error('message') <span class="text-danger">{{ $message }}</span> @enderror
        </div>


        <button type="submit" class="btn btn-primary" wire:loading.attr="disabled">
            <span wire:loading.remove>Send Message</span>
            <span wire:loading>Sending...</span>
        </button>
    </form>
</div>
