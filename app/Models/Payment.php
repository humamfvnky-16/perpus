<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $fillable = [
        'fine_id', 'received_by', 'amount', 'method', 'reference', 'proof_path', 'paid_at',
    ];

    protected $casts = ['paid_at' => 'datetime'];

    public function fine()       { return $this->belongsTo(Fine::class); }
    public function receivedBy() { return $this->belongsTo(User::class, 'received_by'); }
}
