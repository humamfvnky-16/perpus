<?php

namespace App\Policies;

use App\Models\Book;
use App\Models\User;

class BookPolicy
{
    public function viewAny(User $u): bool   { return $u->can('book.view'); }
    public function view(User $u, Book $b): bool { return $u->can('book.view'); }
    public function create(User $u): bool    { return $u->can('book.create'); }
    public function update(User $u, Book $b): bool { return $u->can('book.update'); }
    public function delete(User $u, Book $b): bool { return $u->can('book.delete'); }
}
