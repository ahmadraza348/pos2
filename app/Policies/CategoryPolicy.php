<?php

namespace App\Policies;

use App\Models\Admin;
use App\Models\Category;

class CategoryPolicy
{
    public function viewAny(Admin $admin): bool
    {
        return in_array($admin->role, ['admin', 'manager', 'viewer']);
    }

    public function create(Admin $admin): bool
    {
        return $admin->isAdmin();
    }

    public function update(Admin $admin, Category $category): bool
    {
        return $admin->isAdmin() || $admin->isManager();
    }

    public function delete(Admin $admin, Category $category): bool
    {
        return $admin->isAdmin();
    }
    public function deleteAny(Admin $admin): bool
    {
        return $admin->isAdmin();
    }
}
