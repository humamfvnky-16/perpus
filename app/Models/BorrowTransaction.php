<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BorrowTransaction extends Model
{
    protected $fillable = [
        'code', 'member_id', 'book_id', 'staff_id', 'borrowed_at', 'due_at',
        'returned_at', 'status', 'renew_count', 'notes',
    ];

    protected $casts = [
        'borrowed_at' => 'date',
        'due_at'      => 'date',
        'returned_at' => 'date',
    ];

    public function member()  { return $this->belongsTo(Member::class); }
    public function book()    { return $this->belongsTo(Book::class); }
    public function staff()   { return $this->belongsTo(User::class, 'staff_id'); }
    public function return_() { return $this->hasOne(ReturnTransaction::class); }
    public function fine()    { return $this->hasOne(Fine::class); }

    public function scopeOverdue($q)
    {
        return $q->where('status', 'active')->whereDate('due_at', '<', now());
    }

    public function isOverdue(): bool
    {
        return $this->status === 'active' && $this->due_at?->isPast();
    }

    public function daysLate(): int
    {
        if (!$this->isOverdue()) return 0;
        return (int) $this->due_at->diffInDays(now());
    }
}
