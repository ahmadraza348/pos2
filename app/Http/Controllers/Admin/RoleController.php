<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\AssignPermissionRequest;
use App\Http\Requests\Admin\PermissionStoreRequest;
use App\Http\Requests\Admin\RoleStoreRequest;
use App\Models\Admin;
use App\Services\Admin\RoleService;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
    protected RoleService $roleService;

    public function __construct(RoleService $roleService)
    {
        $this->roleService = $roleService;
    }

    public function all_roles()
    {
        return view('backend.roles_permissions.roles', [
            'roles' => Role::latest()->get(),
        ]);
    }

    public function add_roles(RoleStoreRequest $request)
    {
        $this->roleService->createRole($request->validated());

        toastr()->success('Role created successfully');

        return redirect()->route('admin.roles.index');
    }

    public function edit_roles(Role $role)
    {
        return view('backend.roles_permissions.roles', [
            'roles' => Role::latest()->get(),
            'editingRole' => $role,
        ]);
    }

    public function update_roles(RoleStoreRequest $request, Role $role)
    {
        $this->roleService->updateRole($role, $request->validated());

        toastr()->success('Role updated successfully');

        return redirect()->route('admin.roles.index');
    }

    public function delete_roles(Role $role)
    {
        $this->roleService->deleteRole($role);

        toastr()->success('Role deleted successfully');

        return redirect()->route('admin.roles.index');
    }

    // Permissions methods
    public function all_permissions()
    {
        return view('backend.roles_permissions.permissions', [
            'permissions' => Permission::latest()->get()->groupBy('group_name'),
        ]);
    }

    public function add_permissions(PermissionStoreRequest $request)
    {
        $this->roleService->createPermission($request->validated());

        toastr()->success('Permission created successfully');

        return redirect()->route('admin.permissions.index');
    }

    public function edit_permissions(Permission $permission)
    {
        return view('backend.roles_permissions.permissions', [
            'permissions' => Permission::latest()->get(),
            'editingPermission' => $permission,
        ]);
    }

    public function update_permissions(PermissionStoreRequest $request, Permission $permission)
    {
        $this->roleService->updatePermission($permission, $request->validated());

        toastr()->success('Permission updated successfully');

        return redirect()->route('admin.permissions.index');
    }

    public function delete_permissions(Permission $permission)
    {
        $this->roleService->deletePermission($permission);

        toastr()->success('Permission deleted successfully');

        return redirect()->route('admin.permissions.index');
    }

    // Roles & Permissions methods
    public function all_roles_permissions()
    {
        return view('backend.roles_permissions.index', [
            'roles' => Role::latest()->get(),
        ]);
    }

    public function create_roles_permissions()
    {
        return view('backend.roles_permissions.create', [
            'roles' => Role::latest()->get(),
            'permission_groups' => Admin::getPermissionGroups(),
        ]);
    }

    public function store_roles_permissions(AssignPermissionRequest $request)
    {
        $this->roleService->storeRolePermissions($request->validated());
        toastr()->success('Role & permissions assigned successfully');

        return redirect()->route('admin.roles_permissions.index');
    }

    public function edit_roles_permissions(Role $role_permission)
    {
        return view('backend.roles_permissions.edit', [
            'role' => $role_permission, // Passing it as 'role' for the view
            'permission_groups' => Admin::getPermissionGroups(),
        ]);
    }
    public function update_roles_permissions(AssignPermissionRequest $request, Role $role_permission)
    {
        // If you are using a Service Layer like in your store method:
        $this->roleService->updateRolePermissions($role_permission, $request->validated());
        toastr()->success('Role & permissions updated successfully');
        return redirect()->route('admin.roles_permissions.index');
    }

    public function delete_roles_permissions(Role $role_permission)
    {
        $this->roleService->deleteRolePermissions($role_permission);
        toastr()->success('Permissions Unassigned');
        return redirect()->back();
    }
}
