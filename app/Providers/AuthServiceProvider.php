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
        // $this->registerCategoryGates();

        // The seeded "superadmin" account (already treated as a special,
        // non-deletable account in resources/views/backend/adminuser/show.blade.php)
        // always passes every permission check, even before any permissions
        // are assigned to it via the Roles & Permissions screen. This keeps
        // the existing Spatie permission system as the only authorization
        // mechanism, it just short-circuits it for that one account.
        Gate::before(function ($user, string $ability) {
            if ($user instanceof Admin && $user->username === 'superadmin') {
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