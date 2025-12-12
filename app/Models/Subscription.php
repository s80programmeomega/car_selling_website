<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Yajra\Auditable\AuditableTrait;

class Subscription extends Model
{
    /** @use HasFactory<\Database\Factories\SubscriptionFactory> */
    use HasFactory, AuditableTrait;

    /**
     * Subscription types
     */
    const TYPE_NEW_CARS = 'new_cars';

    const TYPE_PRICE_DROPS = 'price_drops';
    const TYPE_NEWSLETTER = 'newsletter';
    const TYPE_SIMILAR_CARS = 'similar_cars';

    /**
     * Frequency options
     */
    const FREQUENCY_INSTANT = 'instant';

    const FREQUENCY_DAILY = 'daily';
    const FREQUENCY_WEEKLY = 'weekly';

    protected $fillable = [
        'user_id',
        'type',
        'is_active',
        'frequency',
        'filters',
        'last_sent_at',
        'unsubscribe_token',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'filters' => 'array',
        'last_sent_at' => 'datetime',
    ];

    /**
     * Boot method to generate unsubscribe token
     */
    protected static function booted()
    {
        static::creating(function ($subscription) {
            if (empty($subscription->unsubscribe_token)) {
                $subscription->unsubscribe_token = Str::random(64);
            }
        });
    }

    /**
     * Relationship: User who owns this subscription
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Scope: Active subscriptions only
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope: Filter by subscription type
     */
    public function scopeOfType($query, string $type)
    {
        return $query->where('type', $type);
    }

    /**
     * Scope: Filter by frequency
     */
    public function scopeWithFrequency($query, string $frequency)
    {
        return $query->where('frequency', $frequency);
    }

    /**
     * Scope: Subscriptions that need to be sent
     * Based on frequency and last_sent_at
     */
    public function scopeDueForSending($query)
    {
        return $query->where(function ($q) {
            $q
                ->where('frequency', self::FREQUENCY_INSTANT)
                ->orWhere(function ($q) {
                    $q
                        ->where('frequency', self::FREQUENCY_DAILY)
                        ->where(function ($q) {
                            $q
                                ->whereNull('last_sent_at')
                                ->orWhere('last_sent_at', '<', now()->subDay());
                        });
                })
                ->orWhere(function ($q) {
                    $q
                        ->where('frequency', self::FREQUENCY_WEEKLY)
                        ->where(function ($q) {
                            $q
                                ->whereNull('last_sent_at')
                                ->orWhere('last_sent_at', '<', now()->subWeek());
                        });
                });
        });
    }

    /**
     * Mark subscription as sent
     */
    public function markAsSent()
    {
        $this->update(['last_sent_at' => now()]);
    }

    /**
     * Unsubscribe (deactivate)
     */
    public function unsubscribe()
    {
        $this->update(['is_active' => false]);
    }

    /**
     * Resubscribe (activate)
     */
    public function resubscribe()
    {
        $this->update(['is_active' => true]);
    }

    /**
     * Get available subscription types
     */
    public static function getTypes(): array
    {
        return [
            self::TYPE_NEW_CARS => 'New Car Listings',
            self::TYPE_PRICE_DROPS => 'Price Drops',
            self::TYPE_NEWSLETTER => 'Newsletter',
            self::TYPE_SIMILAR_CARS => 'Similar Cars',
        ];
    }

    /**
     * Get available frequencies
     */
    public static function getFrequencies(): array
    {
        return [
            self::FREQUENCY_INSTANT => 'Instant',
            self::FREQUENCY_DAILY => 'Daily Digest',
            self::FREQUENCY_WEEKLY => 'Weekly Digest',
        ];
    }
}
