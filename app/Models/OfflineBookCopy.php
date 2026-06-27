<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OfflineBookCopy extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'offline_book_id', 'reading_spot_id', 'shelf_id', 'catalog_code',
        'barcode', 'condition', 'acquired_at', 'price', 'notes',
    ];

    protected $casts = ['acquired_at' => 'date'];

    public function offlineBook() { return $this->belongsTo(OfflineBook::class); }
    public function readingSpot() { return $this->belongsTo(ReadingSpot::class); }
    public function shelf()       { return $this->belongsTo(Shelf::class); }
    public function checkouts()   { return $this->morphedByMany(Checkout::class, 'borrowable'); }
    public function holds()       { return $this->morphedByMany(Hold::class, 'borrowable'); }

    public function isAvailable(): bool
    {
        if (in_array($this->condition, ['lost', 'maintenance'])) return false;
        if ($this->checkouts()->where('is_returned', false)->exists()) return false;
        if ($this->holds()->where('status', 'active')->exists()) return false;
        return true;
    }
}
