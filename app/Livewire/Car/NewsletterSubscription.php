<?php

namespace App\Livewire\Car;

use App\Models\NewsletterSubscriber;
use Livewire\Component;

class NewsletterSubscription extends Component
{
    public $email = '';
    public $message = '';
    public $messageType = '';

    public function subscribe()
    {
        $this->validate([
            'email' => 'required|email',
        ]);

        // Check if already subscribed
        $existing = NewsletterSubscriber::where('email', $this->email)->first();

        if ($existing) {
            if ($existing->is_active) {
                $this->messageType = 'info';
                $this->message = 'You are already subscribed!';
            } else {
                $existing->update(['is_active' => true]);
                $this->messageType = 'success';
                $this->message = 'Welcome back! Subscription reactivated.';
            }
            return;
        }

        // Create new subscription
        NewsletterSubscriber::create(['email' => $this->email]);

        $this->messageType = 'success';
        $this->message = 'Successfully subscribed! Check your email for updates.';
        $this->email = '';
    }

    public function render()
    {
        return view('livewire.car.newsletter-subscription');
    }
}
