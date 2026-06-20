<?php

namespace App\Services\Admin;

use App\Models\Admin;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class AdminUserService
{
    /**
     * Store a new Admin User
     */
    public function storeUser(array $data)
    {
        $admin = new Admin();
        $admin->fill($data);
        $admin->password = Hash::make($data['password']);
        $admin->save();

        if (isset($data['role'])) {
            $role = Role::findOrFail($data['role']);
            $admin->assignRole($role->name);
        }
        
        return $admin;
    }

    /**
     * Update an existing Admin User
     */
    public function updateUser(int $id, array $data)
    {
        $admin = Admin::findOrFail($id);
        
        // Remove password from array if empty to avoid overwriting with null
        if (empty($data['password'])) {
            unset($data['password']);
        } else {
            $data['password'] = Hash::make($data['password']);
        }

        $admin->update($data);

        if (isset($data['role'])) {
            $role = Role::findOrFail($data['role']);
            $admin->syncRoles([$role->name]);
        }

        return $admin;
    }

    /**
     * Update Admin Profile (handles image)
     */
    public function updateProfile(int $id, array $data, $image = null)
    {
        $user = Admin::findOrFail($id);

        if (!empty($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        } else {
            unset($data['password']);
        }

        if ($image) {
            if ($user->image) {
                Storage::disk('public')->delete($user->image);
            }
            $data['image'] = $image->store('profile', 'public');
        }

        $user->update($data);
        return $user;
    }
}