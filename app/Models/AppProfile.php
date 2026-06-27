<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AppProfile extends Model
{
    use HasFactory;

    protected $fillable = [
        'reading_spot_id', 'app_name', 'logo', 'favicon',
        'primary_color', 'secondary_color',
        'about', 'terms', 'privacy_policy',
        'contact_email', 'contact_phone',
        'facebook', 'instagram', 'twitter', 'youtube',
    ];

    public function readingSpot() { return $this->belongsTo(ReadingSpot::class); }
}
