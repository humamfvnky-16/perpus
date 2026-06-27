<?php

namespace App\Policies;

use App\Models\Review;
use App\Models\User;

class ReviewPolicy
{
    public function create(User $u): bool { return $u->can('review.create'); }
    public function update(User $u, Review $r): bool { return $u->id === $r->user_id; }
    public function delete(User $u, Review $r): bool
    {
        return $u->id === $r->user_id || $u->can('review.moderate');
    }
    public function moderate(User $u): bool { return $u->can('review.moderate'); }
}
