<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class Member extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id', 'reading_spot_id', 'member_no', 'nis_nip', 'type', 'class', 'major',
        'address', 'city', 'birth_date', 'gender', 'joined_at', 'expires_at',
        'is_active', 'qr_code',
    ];

    protected $casts = [
        'birth_date' => 'date',
        'joined_at'  => 'date',
        'expires_at' => 'date',
        'is_active'  => 'boolean',
    ];

    public function user()          { return $this->belongsTo(User::class); }
    public function readingSpot()   { return $this->belongsTo(ReadingSpot::class); }
    public function borrows()       { return $this->hasMany(BorrowTransaction::class); }
    public function activeBorrows() { return $this->borrows()->where('status', 'active'); }
    public function fines()         { return $this->hasMany(Fine::class); }
    public function reservations()  { return $this->hasMany(Reservation::class); }

    public function getActiveBorrowCountAttribute(): int
    {
        return $this->activeBorrows()->count();
    }

    public function getUnpaidFineTotalAttribute(): int
    {
        return (int) $this->fines()
            ->whereIn('status', ['unpaid', 'partial'])
            ->sum(DB::raw('amount - paid_amount'));
    }

    public function canBorrow(): bool
    {
        return $this->is_active
            && (!$this->expires_at || $this->expires_at->isFuture())
            && $this->active_borrow_count < config('library.max_per_member', 3);
    }
}
