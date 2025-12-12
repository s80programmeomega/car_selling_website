<?php

namespace App\Notifications;

use App\Models\Car;
use App\Models\CarInquiry;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Notification;

/**
 * Notification sent to car owner when they receive an inquiry
 */
class CarInquiryReceived extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(
        public CarInquiry $inquiry,
        public Car $car
    ) {}

    /**
     * Get the notification's delivery channels.
     */
    public function via(object $notifiable): array
    {
        $channels = [];

        // Only send if user wants this specific notification type
        if (!$notifiable->notify_inquiry_received) {
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

        return (new MailMessage)
            ->subject('New Inquiry for Your Car')
            ->greeting("Hello {$notifiable->first_name}!")
            ->line("You have received a new inquiry for your car: **{$carTitle}**")
            ->line("**From:** {$this->inquiry->name}")
            ->line("**Email:** {$this->inquiry->email}")
            ->line("**Phone:** {$this->inquiry->phone}")
            ->line("**Message:**")
            ->line($this->inquiry->message)
            ->action('View Inquiry', url(route('admin.inquiries')))
            ->line('Thank you for using our platform!');
    }

    /**
     * Get the array representation of the notification (for database).
     */
    public function toArray(object $notifiable): array
    {
        return [
            'title' => 'New Inquiry Received',
            'type' => 'inquiry_received',
            'message' => "New inquiry from {$this->inquiry->name} for your {$this->car->year} {$this->car->maker->name}",
            'inquiry_id' => $this->inquiry->id,
            'car_id' => $this->car->id,
            'car_title' => "{$this->car->year} {$this->car->maker->name} {$this->car->model->name}",
            'from_name' => $this->inquiry->name,
            'from_email' => $this->inquiry->email,
            'message' => $this->inquiry->message,
            'url' => url(route('admin.inquiries')),
        ];
    }

    /**
     * Get the broadcastable representation of the notification.
     */
    public function toBroadcast(object $notifiable): BroadcastMessage
    {
        return new BroadcastMessage([
            'title' => 'New Inquiry Received',
            'message' => "You have a new inquiry for your {$this->car->year} {$this->car->maker->name}",
            'url' => url(route('admin.inquiries')),
        ]);
    }
}
