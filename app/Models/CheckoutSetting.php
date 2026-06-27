<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CheckoutSetting extends Model
{
    use HasFactory;

    protected $fillable = [
        'reading_spot_id', 'loan_days', 'max_books', 'daily_fine',
        'damage_fine', 'lost_fine', 'renew_limit', 'hold_expires_hours',
    ];

    public function readingSpot() { return $this->belongsTo(ReadingSpot::class); }
}
