<?php

namespace App\Providers;

use App\Models\Admin;
use App\Models\Category;
use App\Policies\CategoryPolicy;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    protected $policies = [
        // Category::class => CategoryPolicy::class,
    ];

    public function boot(): void
    {
        // Only an admin with the "Super Admin" role bypasses every
        // permission check. This used to be hardcoded to a specific
        // username, which meant that ONE account's credentials leaking
        // (e.g. being shown anywhere, including in a view) was enough to
        // grant total control of the system. Tying the bypass to a role
        // instead means:
        //   - it survives renaming/recreating the account,
        //   - you can see at a glance who has full access via the Roles
        //     screen instead of grepping code for a magic string,
        //   - revoking it is a normal "remove role" action, not a deploy.
        Gate::before(function ($user, string $ability) {
            if ($user instanceof Admin && $user->hasRole('Super Admin')) {
                return true;
            }

            return null;
        });
    }

    protected function registerCategoryGates(): void
    {
        // require app_path('Gates/categoryGate.php');
    }
}
