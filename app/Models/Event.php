<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Event extends Model
{
    /** @use HasFactory<\Database\Factories\EventFactory> */
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'description',
        'location',
        'start_date',
        'end_date',
        'special_start_date',
        'special_end_date',
        'capacity',
        'ticket_price',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'special_start_date' => 'datetime',
        'special_end_date' => 'datetime',
        'start_date' => 'datetime',
        'end_date' => 'datetime',
        'capacity' => 'integer',
        'ticket_price' => 'decimal:2',
    ];

    public function tickets()
    {
        return $this->hasMany(Ticket::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function scopeUpcoming($query)
    {
        return $query->where('start_date', '>', now());
    }
    public function scopePast($query)
    {
        return $query->where('end_date', '<', now());
    }
    public function scopeSpecial($query)
    {
        return $query->whereNotNull('special_start_date')->whereNotNull('special_end_date');
    }

    public function scopeCapacityAvailable($query)
    {
        return $query->where('capacity', '>', 0);
    }

    public function scopeWithTickets($query)
    {
        return $query->with('tickets');
    }

    public function scopeWithUser($query)
    {
        return $query->with('user');
    }
    public function scopeWithTicketsAndUser($query)
    {
        return $query->with(['tickets', 'user']);
    }

    /**
     * Check if event is in VIP access period (first 24 hours)
     */
    public function isVipAccessPeriod(): bool
    {
        return $this->created_at->addHours(24)->isFuture();
    }

    /**
     * Check if user can book tickets for this event
     */
    public function canUserBook(?User $user = null): bool
    {
        // If no user provided, assume non-VIP
        if (!$user) {
            return !$this->isVipAccessPeriod();
        }

        // VIP users can always book
        if ($user->isVip()) {
            return true;
        }

        // Regular users can only book after VIP period
        return !$this->isVipAccessPeriod();
    }

    /**
     * Get available tickets count
     */
    public function getAvailableTicketsAttribute(): int
    {
        $confirmedTickets = $this->tickets()->where('status', 'confirmed')->sum('quantity');
        return $this->capacity - $confirmedTickets;
    }

    /**
     * Check if tickets are available
     */
    public function hasAvailableTickets(): bool
    {
        return $this->available_tickets > 0;
    }

    /**
     * Check if event has passed
     */
    public function hasPassed(): bool
    {
        return $this->start_date->isPast();
    }
}
