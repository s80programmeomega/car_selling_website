<?php

namespace App\Events;

use App\Models\Car;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class CarCreated implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * Create a new event instance.
     */
    public function __construct(public Car $car)
    {
        // dd('Instance created');
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): array
    {
        return [
            new Channel('car-created'),
        ];
    }

    /**
     * The event's broadcast name.
     */
    // public function broadcastAs(): string
    // {
    //     return 'CarCreated';
    // }

    public function broadcastWith(): array
    {
        return [
            'car_id' => $this->car->id,
            'timestamp' => now(),
        ];
    }

    public function broadcastQueue(): string
    {
        return 'cars';
    }
}
