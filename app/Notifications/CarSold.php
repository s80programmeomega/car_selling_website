<?php

namespace App\Notifications;

use App\Models\Car;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Notification;

/**
 * Notification sent when a car is marked as sold
 */
class CarSold extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(public Car $car) {}

    public function via(object $notifiable): array
    {
        $channels = [];

        // Only send if user wants this specific notification type
        if (!$notifiable->notify_car_sold) {
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


    public function toMail(object $notifiable): MailMessage
    {
        $carTitle = "{$this->car->year} {$this->car->maker->name} {$this->car->model->name}";

        return (new MailMessage)
            ->subject('🎉 Congratulations! Your Car is Sold')
            ->greeting("Hello " . ($notifiable->first_name ?? $notifiable->username) . "!")
            ->line("Great news! Your car has been marked as sold.")
            ->line("**{$carTitle}**")
            ->line("**Price:** \${$this->car->price}")
            ->action('View Car', route("car.show", ['car' => $this->car]))
            ->line('Thank you for using our platform!');
    }

    public function toArray(object $notifiable): array
    {
        return [
            'title' => '🎉 Your Car is Sold!',
            'type' => 'car_sold',
            'message' => "Your {$this->car->year} {$this->car->maker->name} {$this->car->model->name} has been sold for \${$this->car->price}",
            'car_id' => $this->car->id,
            'car_title' => "{$this->car->year} {$this->car->maker->name} {$this->car->model->name}",
            'price' => $this->car->price,
            'url' => url(route("car.show", ['car' => $this->car])),
        ];
    }

    public function toBroadcast(object $notifiable): BroadcastMessage
    {
        return new BroadcastMessage([
            'title' => 'Car Sold!',
            'message' => "Your {$this->car->year} {$this->car->maker->name} has been sold",
            'url' => url(route("car.show", ['car' => $this->car])),
        ]);
    }
}
