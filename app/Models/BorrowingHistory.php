<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BorrowingHistory extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'offline_book_id', 'reading_spot_id',
        'borrowed_at', 'returned_at', 'days_borrowed', 'fine_amount',
    ];

    protected $casts = [
        'borrowed_at' => 'date',
        'returned_at' => 'date',
    ];

    public function user()        { return $this->belongsTo(User::class); }
    public function offlineBook() { return $this->belongsTo(OfflineBook::class); }
    public function readingSpot() { return $this->belongsTo(ReadingSpot::class); }
}
