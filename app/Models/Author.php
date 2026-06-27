<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Author extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'slug', 'bio', 'photo', 'birth_date', 'nationality'];
    protected $casts    = ['birth_date' => 'date'];

    public function books() { return $this->belongsToMany(Book::class, 'book_author'); }
}
