<?php

namespace App\Providers;

use App\Models\Book;
use App\Models\BorrowTransaction;
use App\Models\Member;
use App\Models\Review;
use App\Policies\BookPolicy;
use App\Policies\BorrowPolicy;
use App\Policies\MemberPolicy;
use App\Policies\ReviewPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    protected $policies = [
        Book::class              => BookPolicy::class,
        Member::class            => MemberPolicy::class,
        BorrowTransaction::class => BorrowPolicy::class,
        Review::class            => ReviewPolicy::class,
    ];

    public function boot(): void
    {
        $this->registerPolicies();
        Gate::before(fn ($user) => $user->hasRole('super_admin') ? true : null);
    }
}
