<?php

namespace App\Notifications;

use App\Models\Car;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Notification;

/**
 * Notification sent when a favorited car's price drops
 */
class FavoriteCarPriceDropped extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(
        public Car $car,
        public float $oldPrice,
        public float $newPrice
    ) {}

    /**
     * Get the notification's delivery channels.
     */
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
            $channels[] = 'broadcast';
        }

        // Send email
        $channels[] = 'mail';

        return $channels;
    }




    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        $carTitle = "{$this->car->year} {$this->car->maker->name} {$this->car->model->name}";
        $discount = $this->oldPrice - $this->newPrice;
        $percentageOff = round(($discount / $this->oldPrice) * 100, 1);

        return (new MailMessage)
            ->subject('Price Drop Alert! 🎉')
            ->greeting("Great news, {$notifiable->first_name}!")
            ->line("A car in your favorites has dropped in price!")
            ->line("**{$carTitle}**")
            ->line("**Old Price:** \${$this->oldPrice}")
            ->line("**New Price:** \${$this->newPrice}")
            ->line("**You Save:** \${$discount} ({$percentageOff}% off)")
            ->action('View Car', url(route("car.show", ['car' => $this->car])))
            ->line("Don't miss this opportunity!");
    }

    /**
     * Get the array representation of the notification.
     */
    public function toArray(object $notifiable): array
    {
        return [
            'title' => '🎉 Price Drop Alert!',
            'type' => 'price_drop',
            'message' => "{$this->car->year} {$this->car->maker->name} dropped by \$" . number_format($this->oldPrice - $this->newPrice, 2),
            'car_id' => $this->car->id,
            'car_title' => "{$this->car->year} {$this->car->maker->name} {$this->car->model->name}",
            'old_price' => $this->oldPrice,
            'new_price' => $this->newPrice,
            'discount' => $this->oldPrice - $this->newPrice,
            'url' => url(route("car.show", ['car' => $this->car])),
        ];
    }

    /**
     * Get the broadcastable representation of the notification.
     */
    public function toBroadcast(object $notifiable): BroadcastMessage
    {
        $discount = $this->oldPrice - $this->newPrice;

        return new BroadcastMessage([
            'title' => 'Price Drop Alert!',
            'message' => "Your favorite {$this->car->year} {$this->car->maker->name} dropped by \${$discount}",
            'url' => url(route("car.show", ['car' => $this->car])),
        ]);
    }
}
