<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Fine extends Model
{
    protected $fillable = [
        'user_id', 'checkout_id', 'type', 'amount', 'paid_amount',
        'status', 'due_date', 'description',
    ];

    protected $casts = ['due_date' => 'date'];

    public function user()     { return $this->belongsTo(User::class); }
    public function checkout() { return $this->belongsTo(Checkout::class); }
    public function payments() { return $this->hasMany(Payment::class); }

    public function getRemainingAttribute(): int
    {
        return max(0, $this->amount - $this->paid_amount);
    }

    public function recomputeStatus(): void
    {
        if ($this->paid_amount >= $this->amount)      $this->status = 'paid';
        elseif ($this->paid_amount > 0)               $this->status = 'partial';
        else                                          $this->status = 'unpaid';
        $this->save();
    }
}
