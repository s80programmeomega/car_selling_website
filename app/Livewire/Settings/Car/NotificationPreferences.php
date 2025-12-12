<?php

namespace App\Livewire\Settings\Car;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;

/**
 * Component for managing user notification preferences
 */
class NotificationPreferences extends Component
{
    public bool $notify_inquiry_received = false;
    public bool $notify_inquiry_response = false;
    public bool $notify_favorite_update = false;
    public bool $notify_review_received = false;
    public bool $notify_car_sold = false;
    public bool $notify_in_app = false;
    public bool $receive_email_digest = false;

    public function mount()
    {
        $user = Auth::user();
        $this->notify_inquiry_received = (bool) $user->notify_inquiry_received;
        $this->notify_inquiry_response = (bool) $user->notify_inquiry_response;
        $this->notify_favorite_update = (bool) $user->notify_favorite_update;
        $this->notify_review_received = (bool) $user->notify_review_received;
        $this->notify_car_sold = (bool) $user->notify_car_sold;
        $this->notify_in_app = (bool) $user->notify_in_app;
        $this->receive_email_digest = (bool) $user->receive_email_digest;
    }

    public function save()
    {
        $user = Auth::user();
        $user->update([
            'notify_inquiry_received' => $this->notify_inquiry_received,
            'notify_inquiry_response' => $this->notify_inquiry_response,
            'notify_favorite_update' => $this->notify_favorite_update,
            'notify_review_received' => $this->notify_review_received,
            'notify_car_sold' => $this->notify_car_sold,
            'notify_in_app' => $this->notify_in_app,
            'receive_email_digest' => $this->receive_email_digest,
        ]);

        session()->flash('message', 'Notification preferences updated successfully!');
    }

    public function render()
    {
        return view('livewire.settings.car.notification-preferences');
    }
}
