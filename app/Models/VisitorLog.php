<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VisitorLog extends Model
{
    protected $fillable = ['user_id', 'path', 'method', 'ip_address', 'user_agent', 'referer'];

    public function user() { return $this->belongsTo(User::class); }
}
