<?php

namespace App\Notifications;

use App\Models\Review;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Auth;

/**
 * Notification sent when user receives a review
 */
class ReviewReceived extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(public Review $review) {}

    /**
     * Get the notification's delivery channels.
     */
    public function via(object $notifiable): array
    {
        $channels = [];

        // Only send if user wants this specific notification type
        if (!$notifiable->notify_review_received) {
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
        $stars = str_repeat('⭐', $this->review->rating);

        return (new MailMessage)
            ->subject('You Received a New Review')
            ->greeting("Hello {$notifiable->first_name}!")
            ->line("You have received a new review!")
            ->line("**Rating:** {$stars} ({$this->review->rating}/5)")
            ->line("**From:** {$this->review->reviewer->name}")
            ->line("**Comment:**")
            ->line($this->review->comment)
            ->action('View Review', url(route('admin.reviews')))
            ->line('Thank you for being a valued member!');
    }

    /**
     * Get the array representation of the notification.
     */
    public function toArray(object $notifiable): array
    {
        return [
            'title' => 'New Review Received',
            'message' => "{$this->review->reviewer->name} left you a {$this->review->rating}-star review",
            'type' => 'review_received',
            'review_id' => $this->review->id,
            'rating' => $this->review->rating,
            'reviewer_name' => $this->review->reviewer->name,
            'comment' => $this->review->comment,
            'url' => url(route('admin.reviews')),
        ];
    }


    /**
     * Get the broadcastable representation of the notification.
     */
    public function toBroadcast(object $notifiable): BroadcastMessage
    {
        return new BroadcastMessage([
            'title' => 'New Review Received',
            'message' => "{$this->review->reviewer->name} left you a {$this->review->rating}-star review",
            'url' => url(route('admin.reviews')),
        ]);
    }
}
