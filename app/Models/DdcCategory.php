<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DdcCategory extends Model
{
    use HasFactory;

    protected $fillable = ['code', 'name', 'description', 'order', 'parent_id'];

    public function parent()   { return $this->belongsTo(self::class, 'parent_id'); }
    public function children() { return $this->hasMany(self::class, 'parent_id'); }
    public function books()    { return $this->hasMany(Book::class); }
    public function offlineBooks() { return $this->hasMany(OfflineBook::class); }
}
