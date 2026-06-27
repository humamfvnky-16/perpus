<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Fine extends Model
{
    protected $fillable = [
        'member_id', 'borrow_transaction_id', 'type', 'amount', 'paid_amount',
        'status', 'due_date', 'description',
    ];

    protected $casts = ['due_date' => 'date'];

    public function member()   { return $this->belongsTo(Member::class); }
    public function borrow()   { return $this->belongsTo(BorrowTransaction::class, 'borrow_transaction_id'); }
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
