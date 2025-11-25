<?php

namespace App\Livewire\Car;

use App\Mail\car\ContactMessageReceived;
use App\Models\ContactMessage;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\RateLimiter;
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

    protected $messages = [
        'name.required' => 'Please enter your name.',
        'name.min' => 'Name must be at least 3 characters.',
        'email.required' => 'Please enter your email address.',
        'email.email' => 'Please enter a valid email address.',
        'subject.required' => 'Please enter a subject.',
        'subject.min' => 'Subject must be at least 5 characters.',
        'message.required' => 'Please enter your message.',
        'message.min' => 'Message must be at least 10 characters.',
    ];

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    public function submit()
    {
        // Check if rate limiting is enabled
        if (config('services.contact_form.rate_limit_enabled', true)) {
            $rateLimitError = $this->checkRateLimits();
            if ($rateLimitError) {
                session()->flash('error', $rateLimitError);
                return;
            }
        }

        $validated = $this->validate();

        // Hit rate limiters only if enabled
        if (config('services.contact_form.rate_limit_enabled', true)) {
            $this->hitRateLimiters();
        }

        $contactMessage = ContactMessage::create([
            ...$validated,
            'ip_address' => request()->ip(),
        ]);

        Mail::to(config('mail.admin_email', 'admin@example.com'))
            ->send(new ContactMessageReceived($contactMessage));

        session()->flash('success', 'Thank you for contacting us! We will get back to you soon.');

        $this->reset();
    }

    protected function checkRateLimits()
    {
        $ipKey = 'contact-form:ip:' . request()->ip();
        $emailKey = 'contact-form:email:' . $this->email;

        // Check email rate limit first
        $emailLimit = config('services.contact_form.email.limit', 3);
        if (RateLimiter::tooManyAttempts($emailKey, $emailLimit)) {
            $seconds = RateLimiter::availableIn($emailKey);
            $minutes = ceil($seconds / 60);
            return "This email has submitted too many messages. Please try again in {$minutes} minute(s).";
        }

        // Progressive IP rate limiting
        $ipAttempts = RateLimiter::attempts($ipKey);
        $tier1 = config('services.contact_form.ip.tier1');
        $tier2 = config('services.contact_form.ip.tier2');
        $tier3 = config('services.contact_form.ip.tier3');

        if ($ipAttempts < $tier1['limit']) {
            // Tier 1: First few attempts (e.g., 3 in 10 minutes)
            if (RateLimiter::tooManyAttempts($ipKey, $tier1['limit'])) {
                $seconds = RateLimiter::availableIn($ipKey);
                $minutes = ceil($seconds / 60);
                return "Too many submissions. Please try again in {$minutes} minute(s).";
            }
        } elseif ($ipAttempts < $tier2['limit']) {
            // Tier 2: More attempts (e.g., 5 in 1 hour)
            if (RateLimiter::tooManyAttempts($ipKey, $tier2['limit'])) {
                $seconds = RateLimiter::availableIn($ipKey);
                $minutes = ceil($seconds / 60);
                return "Too many submissions. Please try again in {$minutes} minute(s).";
            }
        } else {
            // Tier 3: Final limit (e.g., 10 in 24 hours)
            if (RateLimiter::tooManyAttempts($ipKey, $tier3['limit'])) {
                $seconds = RateLimiter::availableIn($ipKey);
                $hours = ceil($seconds / 3600);
                return "You have exceeded the daily limit. Please try again in {$hours} hour(s).";
            }
        }

        return null;
    }

    protected function hitRateLimiters()
    {
        $ipKey = 'contact-form:ip:' . request()->ip();
        $emailKey = 'contact-form:email:' . $this->email;
        $ipAttempts = RateLimiter::attempts($ipKey);

        // Determine which tier to use for decay time
        $tier1 = config('services.contact_form.ip.tier1');
        $tier2 = config('services.contact_form.ip.tier2');
        $tier3 = config('services.contact_form.ip.tier3');

        if ($ipAttempts < $tier1['limit']) {
            $decaySeconds = $tier1['decay_minutes'] * 60;
        } elseif ($ipAttempts < $tier2['limit']) {
            $decaySeconds = $tier2['decay_minutes'] * 60;
        } else {
            $decaySeconds = $tier3['decay_minutes'] * 60;
        }

        RateLimiter::hit($ipKey, $decaySeconds);
        RateLimiter::hit($emailKey, config('services.contact_form.email.decay_minutes', 60) * 60);
    }

    public function render()
    {
        return view('livewire.car.contact-form');
    }
}
