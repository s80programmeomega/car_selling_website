<?php

namespace App\Livewire\Car;

use App\Models\Car;
use App\Models\CarInquiry;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class SendInquiry extends Component
{
    public Car $car;
    public $name;
    public $email;
    public $phone;
    public $message;

    protected $rules = [
        'name' => 'required|string|max:255',
        'email' => 'required|email|max:255',
        'phone' => 'nullable|string|max:255',
        'message' => 'required|string|max:1000',
    ];

    public function mount(Car $car)
    {
        $this->car = $car;

        if (Auth::check()) {
            $this->name = Auth::user()->name;
            $this->email = Auth::user()->email;
        }
    }

    public function submit()
    {
        $this->validate();

        CarInquiry::create([
            'car_id' => $this->car->id,
            'user_id' => Auth::id(),
            'name' => $this->name,
            'email' => $this->email,
            'phone' => $this->phone,
            'message' => $this->message,
        ]);

        session()->flash('message', 'Inquiry sent successfully. The seller will contact you soon.');
        return redirect()->route('car.show', $this->car);
    }

    public function render()
    {
        return view('livewire.car.send-inquiry');
    }
}
