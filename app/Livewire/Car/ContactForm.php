<?php

namespace App\Livewire\Car;

use Illuminate\Support\Facades\Mail;
use Livewire\Component;

class ContactForm extends Component
{
    public $name = '';
    public $email = '';
    public $subject = '';
    public $message = '';

    protected $rules = [
        'name' => 'required|min:3',
        'email' => 'required|email',
        'subject' => 'required|min:5',
        'message' => 'required|min:10',
    ];

    public function submit()
    {
        $this->validate();

        // Send email (configure your mail settings in .env)
        // Mail::to('admin@example.com')->send(new ContactMail($this->all()));

        session()->flash('success', 'Thank you for contacting us! We will get back to you soon.');

        $this->reset();
    }

    public function render()
    {
        return view('livewire.car.contact-form');
    }
}