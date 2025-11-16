<?php

namespace App\Events;

use App\Models\Car;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class CarDataChanged implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public function __construct(public Car $car)
    {
    }

    public function broadcastOn(): array
    {
        return [
            new Channel('cars'),
        ];
    }

    public function broadcastWith(): array
    {
        return [
            'car_id' => $this->car->id,
            'timestamp' => now()->timestamp,
        ];
    }
}
