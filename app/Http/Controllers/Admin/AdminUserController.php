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
        $adminusers = Admin::latest()->get();
        return view('backend.adminuser.show', compact('adminusers'));
    }

    public function add()
    {
        $roles = Role::all();
        return view('backend.adminuser.add', compact('roles'));
    }

    public function store(AdminUserStoreRequest $request)
    {
        $this->adminService->storeUser($request->validated());
        toastr()->success('Admin User registered Successfully');
        return redirect()->route('admin.user.show');
    }

    public function edit($id)
    {
        $admin_data = Admin::findOrFail($id);
        $roles = Role::all();
        return view('backend.adminuser.edit', compact('admin_data', 'roles'));
    }

    public function update(AdminUserUpdateRequest $request, $id)
    {
        $this->adminService->updateUser($id, $request->validated());
        toastr()->success('Admin User updated Successfully');
        return redirect()->route('admin.user.show');
    }

    public function delete($id)
    {
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
}