<?php

namespace App\Notifications;

use App\Models\Car;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

/**
 * Notification sent when a favorited car is updated
 */
class FavoriteCarUpdated extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(
        public Car $car,
        public string $updateType
    ) {}

    public function via(object $notifiable): array
    {
        $channels = [];

        // Only send if user wants this specific notification type
        if (!$notifiable->notify_favorite_update) {
            return $channels;
        }

        // Send database and broadcast for in-app display
        if ($notifiable->notify_in_app) {
            $channels[] = 'database';
        }

        // Send email
        $channels[] = 'mail';

        return $channels;
    }


    public function toMail(object $notifiable): MailMessage
    {
        $carTitle = "{$this->car->year} {$this->car->maker->name} {$this->car->model->name}";

        return (new MailMessage)
            ->subject('Update on Your Favorite Car')
            ->greeting("Hello {$notifiable->first_name}!")
            ->line('A car in your favorites has been updated.')
            ->line("**{$carTitle}**")
            ->line("**Update:** {$this->updateType}")
            ->action('View Car', url(route('car.show', ['car' => $this->car])))
            ->line("Check it out before it's gone!");
    }

    public function toArray(object $notifiable): array
    {
        return [
            'title' => 'Favorite Car Updated',
            'type' => 'favorite_car_updated',
            'message' => "{$this->car->year} {$this->car->maker->name} {$this->car->model->name}: {$this->updateType}",
            'car_id' => $this->car->id,
            'car_title' => "{$this->car->year} {$this->car->maker->name} {$this->car->model->name}",
            'update_type' => $this->updateType,
            'url' => url(route('car.show', ['car' => $this->car])),
        ];
    }
}
