<?php

namespace App\Http\Controllers;

use App\Models\NewsletterSubscriber;
use App\Models\Subscription;
use App\Notifications\NewsletterEmail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;

class SubscriptionController extends Controller
{
    /**
     * Unsubscribe using token (one-click unsubscribe)
     */
    public function unsubscribe($token)
    {
        $subscription = Subscription::where('unsubscribe_token', $token)->firstOrFail();
        $subscription->unsubscribe();

        return view('car_template.unsubscribed', ['subscription' => $subscription]);
    }
}
