<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BookActivityLog extends Model
{
    protected $fillable = ['type', 'book_id', 'ebook_id', 'reading_spot_id'];

    public function book()        { return $this->belongsTo(Book::class); }
    public function ebook()       { return $this->belongsTo(Ebook::class); }
    public function readingSpot() { return $this->belongsTo(ReadingSpot::class); }

    public static function logView(Book $book): void
    {
        static::create([
            'type' => 'view',
            'book_id' => $book->id,
            'reading_spot_id' => $book->reading_spot_id,
        ]);
    }

    public static function logRead(Ebook $ebook): void
    {
        static::create([
            'type' => 'read',
            'book_id' => $ebook->book_id,
            'ebook_id' => $ebook->id,
            'reading_spot_id' => $ebook->book?->reading_spot_id,
        ]);
    }
}
