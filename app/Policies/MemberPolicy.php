<?php

namespace App\Policies;

use App\Models\Member;
use App\Models\User;

class MemberPolicy
{
    public function viewAny(User $u): bool { return $u->can('member.view'); }
    public function view(User $u, Member $m): bool
    {
        return $u->can('member.view') || $u->id === $m->user_id;
    }
    public function create(User $u): bool    { return $u->can('member.create'); }
    public function update(User $u, Member $m): bool { return $u->can('member.update'); }
    public function delete(User $u, Member $m): bool { return $u->can('member.delete'); }
}
