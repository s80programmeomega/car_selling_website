<?php

namespace App\Jobs;

use App\Models\Car;
use App\Models\Subscription;
use App\Notifications\NewMatchingCar;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Collection;

/**
 * Job to send notifications about new cars matching subscriptions
 *
 * This job runs periodically to check for new cars and notify subscribers
 */
class SendNewCarNotifications implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(
        public string $frequency = Subscription::FREQUENCY_DAILY,
        public ?int $carId = null,
    ) {}

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        // Get all active subscriptions for new cars with the specified frequency
        // Also ensure the user wants to receive email digest
        $subscriptions = Subscription::active()
            ->ofType(Subscription::TYPE_NEW_CARS)
            ->withFrequency($this->frequency)
            ->dueForSending()
            ->with('user')
            ->whereHas('user', function ($query) {
                $query->where('receive_email_digest', true);
            })
            ->get();

        foreach ($subscriptions as $subscription) {
            // For instant notifications, only check the new car
            if ($this->frequency === Subscription::FREQUENCY_INSTANT && $this->carId) {
                $query = Car::published()
                    ->available()
                    ->where('id', $this->carId);
            } else {
                // For scheduled notifications, check since last sent
                $since = $subscription->last_sent_at ?? now()->subDay();
                $query = Car::published()
                    ->available()
                    ->where('created_at', '>=', $since);
            }

            // // Get cars created since last notification
            // $since = $subscription->last_sent_at ?? now()->subDay();

            // // Build query based on subscription filters
            // $query = Car::published()
            //     ->available()
            //     ->where('created_at', '>=', $since);

            // Apply filters from subscription
            if ($filters = $subscription->filters) {
                if (isset($filters['maker_id'])) {
                    $query->where('maker_id', $filters['maker_id']);
                }

                if (isset($filters['model_id'])) {
                    $query->where('model_id', $filters['model_id']);
                }

                if (isset($filters['price_min'])) {
                    $query->where('price', '>=', $filters['price_min']);
                }

                if (isset($filters['price_max'])) {
                    $query->where('price', '<=', $filters['price_max']);
                }

                if (isset($filters['state_id'])) {
                    $query->where('state_id', $filters['state_id']);
                }

                if (isset($filters['city_id'])) {
                    $query->where('city_id', $filters['city_id']);
                }

                if (isset($filters['car_type_id'])) {
                    $query->where('car_type_id', $filters['car_type_id']);
                }
            }

            $matchingCars = $query->with(['maker', 'model'])->get();

            // Only send notification if there are matching cars
            if ($matchingCars->isNotEmpty()) {
                $subscription->user->notify(new NewMatchingCar($matchingCars, $subscription));
                // Only mark as sent for scheduled notifications
                if ($this->frequency !== Subscription::FREQUENCY_INSTANT) {
                    $subscription->markAsSent();
                }
            }
        }
    }
}
