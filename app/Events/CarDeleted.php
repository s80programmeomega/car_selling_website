<?php

namespace App\Events;

use App\Models\Car;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class CarDeleted implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public array $car_data = [];

    /**
     * Create a new event instance.
     */
    public function __construct(array $car_data)
    {
        $this->car_data = $car_data;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): array
    {
        return [
            new Channel('car-deleted'),
        ];
    }

    public function broadcastWith(): array
    {
        return [
            'car_id' => $this->car_data['id'],
            'maker' => $this->car_data['maker'],
            'model' => $this->car_data['model'],
            'year' => $this->car_data['year'],
            'price' => $this->car_data['price'],
            'timestamp' => now(),
        ];
    }

    public function broadcastQueue(): string
    {
        return 'cars';
    }
}
