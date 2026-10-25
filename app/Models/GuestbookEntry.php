<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class GuestbookEntry extends Model
{
    use HasFactory;

    protected $fillable = [
        'wedding_event_id',
        'guest_name',
        'guest_email',
        'relationship',
        'attendance_status',
        'pax_count',
        'wishes_message',
        'is_confirmed',
    ];

    protected function casts(): array
    {
        return [
            'pax_count' => 'integer',
            'is_confirmed' => 'boolean',
        ];
    }

    public function weddingEvent(): BelongsTo
    {
        return $this->belongsTo(WeddingEvent::class);
    }
}
