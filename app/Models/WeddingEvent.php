<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class WeddingEvent extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'bride_name',
        'groom_name',
        'slug',
        'event_date',
        'event_time',
        'venue_name',
        'venue_address',
        'story',
    ];

    protected function casts(): array
    {
        return [
            'event_date' => 'date',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function guestbookEntries(): HasMany
    {
        return $this->hasMany(GuestbookEntry::class);
    }

    public function getCoupleTitleAttribute(): string
    {
        return "{$this->bride_name} & {$this->groom_name}";
    }

    public function getAttendingCountAttribute(): int
    {
        return $this->guestbookEntries()->where('attendance_status', 'attending')->count();
    }

    public function getTotalPaxAttribute(): int
    {
        return (int) $this->guestbookEntries()->where('attendance_status', 'attending')->sum('pax_count');
    }

    public function getConfirmedPaxAttribute(): int
    {
        return (int) $this->guestbookEntries()->where('is_confirmed', true)->sum('pax_count');
    }
}
