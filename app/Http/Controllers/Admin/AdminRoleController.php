<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AdminRole;
use Illuminate\Http\Request;

class AdminRoleController extends Controller
{
    // Map of permission keys to readable names
    public static $availablePermissions = [
        'manage_members' => 'Manage Directory',
        'manage_roles' => 'Manage Institutional Roles',
        'manage_plans' => 'Manage Plans Hub',
        'manage_communication' => 'Manage Communication',
        'manage_posts' => 'Manage News & Blog',
        'manage_chapters' => 'Manage Chapters',
        'manage_events' => 'Manage Events',
        'manage_initiatives' => 'Manage Initiatives',
        'manage_design_templates' => 'Manage Design Templates',
        'manage_forms' => 'Manage Form Builder',
        'manage_email_campaigns' => 'Manage Email Campaigns',
        'manage_bulk_import' => 'Manage Bulk Import',
        'manage_resources' => 'Manage Resource Hub',
        'manage_gallery' => 'Manage Asset Gallery',
        'manage_analytics' => 'Manage Sales Analytics',
        'manage_referrals' => 'Manage Referral Network',
        'manage_settings' => 'Manage Portal Settings',
        'manage_system' => 'System Admin (Staff & Roles)'
    ];

    public function index()
    {
        $adminRoles = AdminRole::withCount('admins')->get();
        return view('admin.admin_roles.index', compact('adminRoles'));
    }

    public function create()
    {
        $permissions = self::$availablePermissions;
        return view('admin.admin_roles.form', compact('permissions'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:admin_roles,name',
            'permissions' => 'nullable|array'
        ]);

        AdminRole::create([
            'name' => $request->name,
            'permissions' => $request->permissions ?? []
        ]);

        return redirect()->route('admin.admin-roles.index')->with('success', 'Admin Role created successfully.');
    }

    public function edit(AdminRole $adminRole)
    {
        $permissions = self::$availablePermissions;
        return view('admin.admin_roles.form', compact('adminRole', 'permissions'));
    }

    public function update(Request $request, AdminRole $adminRole)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:admin_roles,name,' . $adminRole->id,
            'permissions' => 'nullable|array'
        ]);

        $adminRole->update([
            'name' => $request->name,
            'permissions' => $request->permissions ?? []
        ]);

        return redirect()->route('admin.admin-roles.index')->with('success', 'Admin Role updated successfully.');
    }

    public function destroy(AdminRole $adminRole)
    {
        if ($adminRole->admins()->count() > 0) {
            return redirect()->route('admin.admin-roles.index')->with('error', 'Cannot delete role assigned to active admin users.');
        }

        $adminRole->delete();
        return redirect()->route('admin.admin-roles.index')->with('success', 'Admin Role deleted successfully.');
    }
}
