<?php

namespace App\Policies;

use App\Models\BorrowTransaction;
use App\Models\User;

class BorrowPolicy
{
    public function viewAny(User $u): bool { return $u->can('borrow.view'); }

    public function view(User $u, BorrowTransaction $t): bool
    {
        return $u->can('borrow.view') || $u->member?->id === $t->member_id;
    }

    public function create(User $u): bool { return $u->can('borrow.create'); }

    public function renew(User $u, BorrowTransaction $t): bool
    {
        return $u->can('borrow.renew') || $u->member?->id === $t->member_id;
    }

    public function return(User $u, BorrowTransaction $t): bool
    {
        return $u->can('borrow.return');
    }
}
