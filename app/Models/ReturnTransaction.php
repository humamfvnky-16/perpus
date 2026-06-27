<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ReturnTransaction extends Model
{
    protected $fillable = [
        'borrow_transaction_id', 'staff_id', 'returned_at', 'condition',
        'days_late', 'fine_amount', 'damage_notes',
    ];

    protected $casts = ['returned_at' => 'date'];

    public function borrow() { return $this->belongsTo(BorrowTransaction::class, 'borrow_transaction_id'); }
    public function staff()  { return $this->belongsTo(User::class, 'staff_id'); }
}
