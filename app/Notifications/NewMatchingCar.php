<?php

namespace App\Notifications;

use App\Models\Car;
use App\Models\Subscription;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Collection;

/**
 * Notification sent when new cars match user's subscription criteria
 */
class NewMatchingCar extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(
        public Collection $cars,
        public Subscription $subscription
    ) {}

    /**
     * Get the notification's delivery channels.
     */
    public function via(object $notifiable): array
    {
        $channels = [];

        // Check if user wants in-app notifications
        if ($notifiable->notify_in_app) {
            $channels[] = 'database';
        }

        // Check if user wants email digest/subscription emails
        if ($notifiable->receive_email_digest && $this->subscription->is_active) {
            $channels[] = 'mail';
        }

        return $channels;
    }


    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        $count = $this->cars->count();
        $message = (new MailMessage)
            ->subject("🚗 {$count} New Car" . ($count > 1 ? 's' : '') . ' Matching Your Preferences')
            ->greeting("Hello {$notifiable->first_name}!")
            ->line("We found {$count} new car" . ($count > 1 ? 's' : '') . ' that match your subscription preferences:');

        // Add each car to the email with link to car details
        foreach ($this->cars->take(5) as $car) {
            $carTitle = "{$car->year} {$car->maker->name} {$car->model->name}";
            $carUrl = route('car.show', ['car' => $car]);
            $message->line("[**{$carTitle}** - \${$car->price}]({$carUrl})");
        }

        if ($count > 5) {
            $message->line('...and ' . ($count - 5) . ' more!');
        }

        $message
            ->action('View All Cars', route('car.index'))
            ->line('Update your subscription preferences anytime in your account settings.');

        // Add unsubscribe link
        $message
            ->line('')
            ->line('[Unsubscribe from this alert](' . route('subscriptions.unsubscribe', ['token' => $this->subscription->unsubscribe_token]) . ')');

        return $message;
    }

    /**
     * Get the array representation of the notification.
     */
    public function toArray(object $notifiable): array
    {
        return [
            'title' => $this->cars->count() . ' New Matching Car' . ($this->cars->count() > 1 ? 's' : ''),
            'type' => 'new_matching_cars',
            'subscription_id' => $this->subscription->id,
            'car_count' => $this->cars->count(),
            'cars' => $this->cars->map(fn($car) => [
                'id' => $car->id,
                'title' => "{$car->year} {$car->maker->name} {$car->model->name}",
                'price' => $car->price,
                'url' => url(route('car.show', ['car' => $car])),
            ])->toArray(),
        ];
    }
}
