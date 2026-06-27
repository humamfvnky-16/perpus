<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Checkout extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'code', 'user_id', 'reading_spot_id', 'staff_id',
        'start_time', 'end_time', 'return_time',
        'is_returned', 'fine_amount', 'notes',
    ];

    protected $casts = [
        'start_time'  => 'datetime',
        'end_time'    => 'datetime',
        'return_time' => 'datetime',
        'is_returned' => 'boolean',
    ];

    public function user()        { return $this->belongsTo(User::class); }
    public function staff()       { return $this->belongsTo(User::class, 'staff_id'); }
    public function readingSpot() { return $this->belongsTo(ReadingSpot::class); }
    public function offlineBookCopies() { return $this->morphToMany(OfflineBookCopy::class, 'borrowable'); }

    public function isOverdue(): bool
    {
        return !$this->is_returned && $this->end_time?->isPast();
    }

    public function daysLate(): int
    {
        return $this->isOverdue() ? (int) $this->end_time->diffInDays(now()) : 0;
    }

    public function scopeActive($q)   { return $q->where('is_returned', false); }
    public function scopeOverdue($q)
    {
        return $q->where('is_returned', false)->whereDate('end_time', '<', now());
    }
}
