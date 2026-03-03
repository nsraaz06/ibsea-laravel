<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\AdminRole;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class AdminUserController extends Controller
{
    public function index()
    {
        $admins = Admin::with('role')->get();
        return view('admin.admin_users.index', compact('admins'));
    }

    public function create()
    {
        $roles = AdminRole::all();
        return view('admin.admin_users.form', compact('roles'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'username' => 'required|string|max:255|unique:admins,username',
            'email' => 'required|email|max:255|unique:admins,email',
            'password' => 'required|string|min:8|confirmed',
            'admin_role_id' => 'required|exists:admin_roles,id',
        ]);

        Admin::create([
            'username' => $request->username,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'admin_role_id' => $request->admin_role_id,
            'is_superadmin' => false,
        ]);

        return redirect()->route('admin.admin-users.index')->with('success', 'Staff account created successfully.');
    }

    public function edit(Admin $adminUser)
    {
        if ($adminUser->is_superadmin && !auth('admin')->user()->is_superadmin) {
            return redirect()->route('admin.admin-users.index')->with('error', 'Cannot edit superadmin profile.');
        }

        $roles = AdminRole::all();
        return view('admin.admin_users.form', compact('adminUser', 'roles'));
    }

    public function update(Request $request, Admin $adminUser)
    {
        if ($adminUser->is_superadmin && !auth('admin')->user()->is_superadmin) {
            return redirect()->route('admin.admin-users.index')->with('error', 'Cannot edit superadmin profile.');
        }

        $rules = [
            'username' => ['required', 'string', 'max:255', Rule::unique('admins')->ignore($adminUser->id)],
            'email' => ['required', 'email', 'max:255', Rule::unique('admins')->ignore($adminUser->id)],
            'admin_role_id' => 'required|exists:admin_roles,id',
        ];

        if ($request->filled('password')) {
            $rules['password'] = 'required|string|min:8|confirmed';
        }

        $request->validate($rules);

        $data = [
            'username' => $request->username,
            'email' => $request->email,
            'admin_role_id' => $request->admin_role_id,
        ];

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $adminUser->update($data);

        return redirect()->route('admin.admin-users.index')->with('success', 'Staff account updated successfully.');
    }

    public function destroy(Admin $adminUser)
    {
        if ($adminUser->is_superadmin) {
            return redirect()->route('admin.admin-users.index')->with('error', 'Cannot delete superadmin profile.');
        }
        
        if ($adminUser->id === auth('admin')->id()) {
            return redirect()->route('admin.admin-users.index')->with('error', 'Cannot delete your own profile.');
        }

        $adminUser->delete();
        return redirect()->route('admin.admin-users.index')->with('success', 'Staff account deleted successfully.');
    }
}
