<?php

namespace App\Livewire\Car;

use App\Models\Subscription;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class QuickNewsletterSubscribe extends Component
{
    public $isSubscribed = false;
    public $message = '';

    public function mount()
    {
        if (Auth::check()) {
            $this->isSubscribed = Subscription::where('user_id', Auth::id())
                ->where('type', Subscription::TYPE_NEWSLETTER)
                ->where('is_active', true)
                ->exists();
        }
    }

    public function toggleSubscription()
    {
        if (!Auth::check()) {
            $this->message = 'Please login to subscribe';
            return;
        }

        $subscription = Subscription::where('user_id', Auth::id())
            ->where('type', Subscription::TYPE_NEWSLETTER)
            ->first();

        if ($subscription) {
            $subscription->is_active ? $subscription->unsubscribe() : $subscription->resubscribe();
            $this->isSubscribed = $subscription->is_active;
            $this->message = $subscription->is_active ? 'Subscribed!' : 'Unsubscribed';
        } else {
            Subscription::create([
                'user_id' => Auth::id(),
                'type' => Subscription::TYPE_NEWSLETTER,
                'frequency' => Subscription::FREQUENCY_WEEKLY,
                'is_active' => true,
            ]);
            $this->isSubscribed = true;
            $this->message = 'Subscribed!';
        }
    }

    public function render()
    {
        return view('livewire.car.quick-newsletter-subscribe');
    }
}
