<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OfflineBook extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'reading_spot_id', 'isbn', 'title', 'subtitle', 'publisher_id',
        'ddc_category_id', 'year_published', 'language', 'pages', 'cover',
        'synopsis', 'keywords', 'source', 'view_count', 'borrow_count',
    ];

    public function readingSpot() { return $this->belongsTo(ReadingSpot::class); }
    public function publisher()   { return $this->belongsTo(Publisher::class); }
    public function ddcCategory() { return $this->belongsTo(DdcCategory::class); }
    public function categories()  { return $this->belongsToMany(BookCategory::class, 'offline_book_category'); }
    public function authors()     { return $this->belongsToMany(Author::class, 'author_offline_book'); }
    public function copies()      { return $this->hasMany(OfflineBookCopy::class); }
    public function borrowingHistories() { return $this->hasMany(BorrowingHistory::class); }

    public function availableCopiesCount(): int
    {
        return $this->copies()
            ->where('condition', '!=', 'lost')
            ->whereDoesntHave('checkouts', fn($q) => $q->where('is_returned', false))
            ->whereDoesntHave('holds', fn($q) => $q->where('status', 'active'))
            ->count();
    }
}
