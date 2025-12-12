<?php

namespace App\Livewire\Settings\Car;

use App\Models\Subscription;
use App\Models\Maker;
use App\Models\State;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;

/**
 * Component for managing email subscriptions
 */
class ManageSubscriptions extends Component
{
    public $subscriptions;
    public $showCreateForm = false;

    // Form fields
    public $type = Subscription::TYPE_NEW_CARS;
    public $frequency = Subscription::FREQUENCY_DAILY;
    public $maker_id = null;
    public $price_min = null;
    public $price_max = null;
    public $state_id = null;

    public function mount()
    {
        $this->loadSubscriptions();
    }

    public function loadSubscriptions()
    {
        $this->subscriptions = Auth::user()->subscriptions()->latest()->get();
    }

    public function createSubscription()
    {
        $filters = array_filter([
            'maker_id' => $this->maker_id,
            'price_min' => $this->price_min,
            'price_max' => $this->price_max,
            'state_id' => $this->state_id,
        ]);

        Auth::user()->subscriptions()->create([
            'type' => $this->type,
            'frequency' => $this->frequency,
            'filters' => $filters,
            'is_active' => true,
        ]);

        $this->reset(['type', 'frequency', 'maker_id', 'price_min', 'price_max', 'state_id']);
        $this->showCreateForm = false;
        $this->loadSubscriptions();
        session()->flash('message', 'Subscription created successfully!');
    }

    public function toggleSubscription($subscriptionId)
    {
        $subscription = Subscription::findOrFail($subscriptionId);

        if ($subscription->user_id !== Auth::id()) {
            return;
        }

        $subscription->is_active ? $subscription->unsubscribe() : $subscription->resubscribe();
        $this->loadSubscriptions();
    }

    public function deleteSubscription($subscriptionId)
    {
        $subscription = Subscription::findOrFail($subscriptionId);

        if ($subscription->user_id !== Auth::id()) {
            return;
        }

        $subscription->delete();
        $this->loadSubscriptions();
        session()->flash('message', 'Subscription deleted successfully!');
    }

    public function render()
    {
        return view('livewire.settings.car.manage-subscriptions', [
            'makers' => Maker::orderBy('name')->get(),
            'states' => State::orderBy('name')->get(),
            'types' => Subscription::getTypes(),
            'frequencies' => Subscription::getFrequencies(),
        ]);
    }
}
