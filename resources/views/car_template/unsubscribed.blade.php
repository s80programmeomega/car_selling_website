@extends('car_template.base')

@section('title', 'Unsubscribed Successfully')

@section('content')
<section style="padding: 3rem 0;">
    <div class="container-small">
        <div class="card" style="padding: 3rem; text-align: center;">
            <!-- Success Icon -->
            <div style="margin-bottom: 2rem;">
                <svg style="width: 80px; height: 80px; margin: 0 auto; color: #03ac4f;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>

            <!-- Title -->
            <h1 style="font-size: 2rem; font-weight: bold; margin-bottom: 1rem; color: var(--text-color);">
                Successfully Unsubscribed
            </h1>

            <!-- Message -->
            <p style="font-size: 1.125rem; color: var(--text-color); margin-bottom: 1.5rem;">
                You have been unsubscribed from <strong style="color: var(--primary-color);">{{ ucfirst(str_replace('_', ' ', $subscription->type)) }}</strong> notifications.
            </p>

            <p style="color: var(--text-muted-color); margin-bottom: 2.5rem;">
                You will no longer receive emails for this subscription. You can manage your other subscriptions anytime from your account settings.
            </p>

            <!-- Action Buttons -->
            <div style="display: flex; flex-direction: column; gap: 1rem; align-items: center;">
                @auth
                    <a href="{{ route('settings.subscriptions') }}" class="btn btn-primary" style="min-width: 250px;">
                        Manage Subscriptions
                    </a>
                @else
                    <a href="{{ route('login') }}" class="btn btn-primary" style="min-width: 250px;">
                        Login to Manage Subscriptions
                    </a>
                @endauth

                <a href="{{ url('/') }}" class="btn-link" style="font-size: 1rem;">
                    Return to Homepage
                </a>
            </div>
        </div>
    </div>
</section>
@endsection
