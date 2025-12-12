<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;

class NewsletterSubscriber extends Model
{
    // use HasFactory, Notifiable;

    protected $fillable = ['email', 'is_active', 'unsubscribe_token'];

    protected $casts = ['is_active' => 'boolean'];

    protected static function booted()
    {
        static::creating(function ($subscriber) {
            if (empty($subscriber->unsubscribe_token)) {
                $subscriber->unsubscribe_token = Str::random(64);
            }
        });
    }
}
