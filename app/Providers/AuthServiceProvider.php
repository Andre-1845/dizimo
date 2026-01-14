<?php

namespace App\Providers;

// use Illuminate\Support\ServiceProvider;

use App\Models\Donation;
use App\Models\Expense;
use App\Models\Member;
use App\Models\Role;
use App\Models\User;
use App\Policies\DonationPolicy;
use App\Policies\ExpensePolicy;
use App\Policies\MemberPolicy;
use App\Policies\RolePolicy;
use App\Policies\UserPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        Member::class => MemberPolicy::class,
        Role::class   => RolePolicy::class,
        User::class => UserPolicy::class,
        Donation::class => DonationPolicy::class,
        Expense::class => ExpensePolicy::class,
    ];



    /**
     * Register any authentication / authorization services.
     */


    public function boot(): void
    {
        $this->registerPolicies();

        Gate::before(function ($user, $ability) {
            return $user->hasRole('Super Admin') ? true : null;
        });
    }
}