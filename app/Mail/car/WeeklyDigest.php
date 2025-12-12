<?php

namespace App\Mail\car;

use App\Models\Car;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

/**
 * Weekly digest email with latest cars and updates
 */
class WeeklyDigest extends Mailable
{
    use Queueable, SerializesModels;

    public $latestCars;
    public $featuredCars;
    public $stats;

    public function __construct(public User $user)
    {
        // Get latest cars from the past week
        $this->latestCars = Car::published()
            ->available()
            ->where('created_at', '>=', now()->subWeek())
            ->with(['maker', 'model', 'images'])
            ->latest()
            ->take(5)
            ->get();

        // Get featured cars
        $this->featuredCars = Car::published()
            ->featured()
            ->available()
            ->with(['maker', 'model', 'images'])
            ->inRandomOrder()
            ->take(3)
            ->get();

        // Get stats
        $this->stats = [
            'new_cars_count' => Car::where('created_at', '>=', now()->subWeek())->count(),
            'total_cars' => Car::published()->available()->count(),
        ];
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: '🚗 Your Weekly Car Digest',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.weekly-digest',
        );
    }
}
