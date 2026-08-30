<?php
namespace App\Http\Controllers\Admin;

use App\Models\Admin;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\AdminUserStoreRequest;
use App\Http\Requests\Admin\AdminUserUpdateRequest;
use App\Services\Admin\AdminUserService;
use Spatie\Permission\Models\Role;
use Illuminate\Http\Request;

class AdminUserController extends Controller
{
    protected $adminService;

    public function __construct(AdminUserService $adminService)
    {
        $this->adminService = $adminService;
    }

    public function show()
    {
        $adminusers = Admin::whereDoesntHave('roles', function ($query) {
            $query->where('name', 'Super Admin');
        })->latest()->get();

        return view('backend.adminuser.show', compact('adminusers'));
    }

    public function add()
    {
        $roles = $this->assignableRoles();
        return view('backend.adminuser.add', compact('roles'));
    }

    public function store(AdminUserStoreRequest $request)
    {
        $this->guardAgainstSuperAdminRole($request->input('role'));

        $this->adminService->storeUser($request->validated());
        toastr()->success('Admin User registered Successfully');
        return redirect()->route('admin.user.show');
    }

    public function edit($id)
    {
        $admin_data = $this->findEditableAdminOrFail($id);
        $roles = $this->assignableRoles();
        return view('backend.adminuser.edit', compact('admin_data', 'roles'));
    }

    public function update(AdminUserUpdateRequest $request, $id)
    {
        $this->findEditableAdminOrFail($id);
        $this->guardAgainstSuperAdminRole($request->input('role'));

        $this->adminService->updateUser($id, $request->validated());
        toastr()->success('Admin User updated Successfully');
        return redirect()->route('admin.user.show');
    }

    public function delete($id)
    {
        $this->findEditableAdminOrFail($id);

        Admin::findOrFail($id)->delete();
        toastr()->success('Admin User Deleted Successfully');
        return redirect()->route('admin.user.show');
    }

    public function profile()
    {
        $user = auth()->guard('admin')->user();
        return view('backend.adminuser.profile', compact('user'));
    }

    public function profile_update(AdminUserUpdateRequest $request, $id)
    {
        $this->adminService->updateProfile(
            $id,
            $request->validated(),
            $request->file('image')
        );

        toastr()->success('Profile updated successfully.');
        return redirect()->back();
    }

    /**
     * The Super Admin account is hidden from this whole screen. Even if
     * someone guesses/bookmarks its edit or delete URL directly, block it
     * here rather than relying only on the list being filtered.
     */
    private function findEditableAdminOrFail($id): Admin
    {
        $admin = Admin::findOrFail($id);

        if ($admin->hasRole('Super Admin')) {
            toastr()->error('This account cannot be modified from here.');
            throw new \Illuminate\Http\Exceptions\HttpResponseException(
                redirect()->route('admin.user.show')
            );
        }

        return $admin;
    }

    /**
     * Roles selectable from the Admin User form. "Super Admin" is
     * intentionally excluded - it can only be granted by editing the
     * database/seeder directly, never through the UI.
     */
    private function assignableRoles()
    {
        return Role::where('name', '!=', 'Super Admin')->get();
    }

    private function guardAgainstSuperAdminRole($roleId): void
    {
        if (!$roleId) {
            return;
        }

        $role = Role::find($roleId);

        if ($role && $role->name === 'Super Admin') {
            toastr()->error('The Super Admin role cannot be assigned from this screen.');
            throw new \Illuminate\Http\Exceptions\HttpResponseException(
                redirect()->route('admin.user.show')
            );
        }
    }
}
