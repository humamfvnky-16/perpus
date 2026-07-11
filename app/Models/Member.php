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

    public function user()        { return $this->belongsTo(User::class); }
    public function readingSpot() { return $this->belongsTo(ReadingSpot::class); }

    // Checkout & Fine tersimpan lewat User (bukan Member) karena peminjaman fisik
    // tidak mensyaratkan keanggotaan; relasi di bawah hanya menyamakan user_id.
    public function checkouts()       { return $this->hasMany(Checkout::class, 'user_id', 'user_id'); }
    public function activeCheckouts() { return $this->checkouts()->where('is_returned', false); }
    public function fines()           { return $this->hasMany(Fine::class, 'user_id', 'user_id'); }

    public function getActiveCheckoutCountAttribute(): int
    {
        return $this->activeCheckouts()->count();
    }

    public function getUnpaidFineTotalAttribute(): int
    {
        return (int) $this->fines()
            ->whereIn('status', ['unpaid', 'partial'])
            ->sum(DB::raw('amount - paid_amount'));
    }
}
