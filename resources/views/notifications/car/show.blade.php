@extends('car_template.base')

@section('title', 'Notification Details')

@section('content')
<section style="padding: 3rem 0;">
    <div class="container">
        <!-- Back Button -->
        <div style="margin-bottom: 2rem;">
            <a href="{{ route('notifications.index') }}" style="color: var(--primary-color); text-decoration: none; font-weight: 500;">
                <i class="fas fa-arrow-left" style="margin-right: 0.5rem;"></i>
                Back to Notifications
            </a>
        </div>

        <div style="display: grid; grid-template-columns: 2fr 1fr; gap: 2rem;">
            <!-- Main Content -->
            <div>
                <div class="card">
                    <!-- Header -->
                    <div style="display: flex; justify-content: space-between; align-items: start; margin-bottom: 1.5rem;">
                        <div style="flex: 1;">
                            <h1 style="font-size: 2rem; font-weight: bold; margin-bottom: 0.5rem;">
                                {{ $notification->data['title'] ?? 'Notification' }}
                            </h1>
                            <div style="display: flex; gap: 1rem; align-items: center; color: var(--text-muted-color); font-size: 0.875rem;">
                                <span>
                                    <i class="far fa-clock" style="margin-right: 0.25rem;"></i>
                                    {{ $notification->created_at->format('M d, Y \a\t h:i A') }}
                                </span>
                                @if($notification->read_at)
                                    <span style="color: #10b981;">
                                        <i class="fas fa-check-circle" style="margin-right: 0.25rem;"></i>
                                        Read
                                    </span>
                                @else
                                    <span style="color: var(--primary-color);">
                                        <i class="fas fa-circle" style="margin-right: 0.25rem; font-size: 0.5rem;"></i>
                                        Unread
                                    </span>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Notification Type Badge -->
                    <div style="margin-bottom: 1.5rem;">
                        @php
                            $type = $notification->data['type'] ?? 'general';
                            $badges = [
                                'inquiry_received' => ['color' => '#3b82f6', 'icon' => 'fa-envelope', 'label' => 'Inquiry'],
                                'car_sold' => ['color' => '#10b981', 'icon' => 'fa-check-circle', 'label' => 'Car Sold'],
                                'price_drop' => ['color' => '#f59e0b', 'icon' => 'fa-tag', 'label' => 'Price Drop'],
                                'favorite_car_updated' => ['color' => '#8b5cf6', 'icon' => 'fa-heart', 'label' => 'Favorite Updated'],
                                'review_received' => ['color' => '#ec4899', 'icon' => 'fa-star', 'label' => 'Review'],
                                'new_matching_cars' => ['color' => '#06b6d4', 'icon' => 'fa-car', 'label' => 'New Cars'],
                            ];
                            $badge = $badges[$type] ?? ['color' => '#6b7280', 'icon' => 'fa-bell', 'label' => 'Notification'];
                        @endphp
                        <span style="display: inline-block; padding: 0.5rem 1rem; background: {{ $badge['color'] }}; color: white; border-radius: 9999px; font-size: 0.875rem; font-weight: 500;">
                            <i class="fas {{ $badge['icon'] }}" style="margin-right: 0.25rem;"></i>
                            {{ $badge['label'] }}
                        </span>
                    </div>

                    <!-- Content Based on Type -->
                    @if($type === 'inquiry_received')
                        <div style="margin-bottom: 1.5rem;">
                            <h3 style="font-weight: 600; margin-bottom: 1rem;">Inquiry Details</h3>
                            <div style="background: var(--bg-secondary-color); padding: 1rem; border-radius: 0.5rem;">
                                <p style="margin-bottom: 0.5rem;"><strong>Car:</strong> {{ $notification->data['car_title'] ?? 'N/A' }}</p>
                                <p style="margin-bottom: 0.5rem;"><strong>From:</strong> {{ $notification->data['from_name'] ?? 'N/A' }}</p>
                                <p style="margin-bottom: 0.5rem;"><strong>Email:</strong> {{ $notification->data['from_email'] ?? 'N/A' }}</p>
                                <p style="margin-bottom: 0;"><strong>Message:</strong></p>
                                <p style="margin-top: 0.5rem; padding: 0.75rem; background: white; border-radius: 0.25rem;">
                                    {{ $notification->data['message'] ?? 'No message' }}
                                </p>
                            </div>
                        </div>

                    @elseif($type === 'price_drop')
                        <div style="margin-bottom: 1.5rem;">
                            <h3 style="font-weight: 600; margin-bottom: 1rem;">Price Drop Details</h3>
                            <div style="background: var(--bg-secondary-color); padding: 1rem; border-radius: 0.5rem;">
                                <p style="margin-bottom: 0.5rem;"><strong>Car:</strong> {{ $notification->data['car_title'] ?? 'N/A' }}</p>
                                <p style="margin-bottom: 0.5rem;"><strong>Old Price:</strong> ${{ number_format($notification->data['old_price'] ?? 0, 2) }}</p>
                                <p style="margin-bottom: 0.5rem;"><strong>New Price:</strong> <span style="color: #10b981; font-weight: 600;">${{ number_format($notification->data['new_price'] ?? 0, 2) }}</span></p>
                                <p style="margin-bottom: 0;"><strong>You Save:</strong> <span style="color: #10b981; font-weight: 600;">${{ number_format($notification->data['discount'] ?? 0, 2) }}</span></p>
                            </div>
                        </div>

                    @elseif($type === 'car_sold')
                        <div style="margin-bottom: 1.5rem;">
                            <h3 style="font-weight: 600; margin-bottom: 1rem;">Car Details</h3>
                            <div style="background: var(--bg-secondary-color); padding: 1rem; border-radius: 0.5rem;">
                                <p style="margin-bottom: 0.5rem;"><strong>Car:</strong> {{ $notification->data['car_title'] ?? 'N/A' }}</p>
                                <p style="margin-bottom: 0;"><strong>Sold Price:</strong> ${{ number_format($notification->data['price'] ?? 0, 2) }}</p>
                            </div>
                        </div>

                    @elseif($type === 'review_received')
                        <div style="margin-bottom: 1.5rem;">
                            <h3 style="font-weight: 600; margin-bottom: 1rem;">Review Details</h3>
                            <div style="background: var(--bg-secondary-color); padding: 1rem; border-radius: 0.5rem;">
                                <p style="margin-bottom: 0.5rem;"><strong>From:</strong> {{ $notification->data['reviewer_name'] ?? 'N/A' }}</p>
                                <p style="margin-bottom: 0.5rem;">
                                    <strong>Rating:</strong>
                                    @for($i = 1; $i <= 5; $i++)
                                        <i class="fas fa-star" style="color: {{ $i <= ($notification->data['rating'] ?? 0) ? '#f59e0b' : '#d1d5db' }};"></i>
                                    @endfor
                                </p>
                                <p style="margin-bottom: 0;"><strong>Comment:</strong></p>
                                <p style="margin-top: 0.5rem; padding: 0.75rem; background: white; border-radius: 0.25rem;">
                                    {{ $notification->data['comment'] ?? 'No comment' }}
                                </p>
                            </div>
                        </div>

                    @elseif($type === 'new_matching_cars')
                        <div style="margin-bottom: 1.5rem;">
                            <h3 style="font-weight: 600; margin-bottom: 1rem;">Matching Cars ({{ $notification->data['car_count'] ?? 0 }})</h3>
                            @if(isset($notification->data['cars']) && is_array($notification->data['cars']))
                                @foreach($notification->data['cars'] as $car)
                                    <div style="background: var(--bg-secondary-color); padding: 1rem; border-radius: 0.5rem; margin-bottom: 0.75rem;">
                                        <p style="margin-bottom: 0.25rem; font-weight: 600;">{{ $car['title'] ?? 'N/A' }}</p>
                                        <p style="margin-bottom: 0.25rem; color: var(--primary-color); font-weight: 600;">${{ number_format($car['price'] ?? 0, 2) }}</p>
                                        @if(isset($car['url']))
                                            <a href="{{ $car['url'] }}" style="color: var(--primary-color); text-decoration: none; font-size: 0.875rem;">
                                                View Car <i class="fas fa-arrow-right" style="margin-left: 0.25rem;"></i>
                                            </a>
                                        @endif
                                    </div>
                                @endforeach
                            @endif
                        </div>

                    @else
                        <div style="margin-bottom: 1.5rem;">
                            <p style="color: var(--text-muted-color); line-height: 1.6;">
                                {{ $notification->data['message'] ?? $notification->data['car_title'] ?? 'No additional details available.' }}
                            </p>
                        </div>
                    @endif

                    <!-- Action Button -->
                    @if(isset($notification->data['url']))
                        <a href="{{ $notification->data['url'] }}" class="btn btn-primary" style="display: inline-block;">
                            <i class="fas fa-external-link-alt" style="margin-right: 0.5rem;"></i>
                            View Related Item
                        </a>
                    @endif
                </div>
            </div>

            <!-- Sidebar Actions -->
            <div>
                <div class="card">
                    <h3 style="font-weight: 600; margin-bottom: 1rem;">Actions</h3>

                    @if(!$notification->read_at)
                        <form action="{{ route('notifications.read', $notification->id) }}" method="POST" style="margin-bottom: 0.75rem;">
                            @csrf
                            <button type="submit" class="btn btn-primary" style="width: 100%;">
                                <i class="fas fa-check" style="margin-right: 0.5rem;"></i>
                                Mark as Read
                            </button>
                        </form>
                    @endif

                    <form action="{{ route('notifications.destroy', $notification->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this notification?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger" style="width: 100%;">
                            <i class="fas fa-trash" style="margin-right: 0.5rem;"></i>
                            Delete Notification
                        </button>
                    </form>
                </div>

                <!-- Metadata -->
                <div class="card" style="margin-top: 1rem;">
                    <h3 style="font-weight: 600; margin-bottom: 1rem;">Information</h3>
                    <div style="font-size: 0.875rem;">
                        <p style="margin-bottom: 0.5rem; color: var(--text-muted-color);">
                            <strong>Received:</strong><br>
                            {{ $notification->created_at->format('F d, Y') }}<br>
                            {{ $notification->created_at->format('h:i A') }}
                        </p>
                        @if($notification->read_at)
                            <p style="margin-bottom: 0; color: var(--text-muted-color);">
                                <strong>Read:</strong><br>
                                {{ $notification->read_at->format('F d, Y') }}<br>
                                {{ $notification->read_at->format('h:i A') }}
                            </p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
