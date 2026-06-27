<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Ebook extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'book_id', 'title', 'format', 'file_path', 'file_size', 'duration_seconds',
        'downloadable', 'watermark', 'access', 'view_count', 'download_count',
    ];

    protected $casts = ['downloadable' => 'boolean', 'watermark' => 'boolean'];

    public function book()      { return $this->belongsTo(Book::class); }
    public function bookmarks() { return $this->hasMany(EbookBookmark::class); }
}
