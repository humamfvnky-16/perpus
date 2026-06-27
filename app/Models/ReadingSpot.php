<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ReadingSpot extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name', 'slug', 'type', 'npsn', 'address', 'city', 'province',
        'latitude', 'longitude', 'phone', 'email', 'logo', 'banner',
        'description', 'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'latitude'  => 'decimal:7',
        'longitude' => 'decimal:7',
    ];

    public function users()    { return $this->belongsToMany(User::class, 'reading_spot_user')
                                              ->withPivot(['role','is_active','joined_at']); }
    public function members()  { return $this->hasMany(Member::class); }
    public function books()    { return $this->hasMany(Book::class); }
    public function offlineBooks()      { return $this->hasMany(OfflineBook::class); }
    public function offlineBookCopies() { return $this->hasMany(OfflineBookCopy::class); }
    public function holds()    { return $this->hasMany(Hold::class); }
    public function checkouts(){ return $this->hasMany(Checkout::class); }
    public function profile()  { return $this->hasOne(AppProfile::class); }
    public function checkoutSetting() { return $this->hasOne(CheckoutSetting::class); }

    public function totalBooks(): int
    {
        return $this->books()->count() + $this->offlineBooks()->count();
    }

    public function totalCopies(): int
    {
        return $this->offlineBookCopies()->count();
    }

    public function availableCopies(): int
    {
        return $this->offlineBookCopies()
            ->whereDoesntHave('checkouts', fn($q) => $q->where('is_returned', false))
            ->count();
    }

    public function scopeActive($q)   { return $q->where('is_active', true); }
}
