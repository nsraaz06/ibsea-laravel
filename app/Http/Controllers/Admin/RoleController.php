<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\MemberRole;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    /**
     * Display a listing of institutional roles.
     */
    public function index()
    {
        $roles = MemberRole::orderBy('hierarchy_level', 'asc')->get();
        return view('admin.roles.index', [
            'roles' => $roles,
            'title' => 'Role Management | IBSEA Admin'
        ]);
    }

    /**
     * Show the form for creating a new role.
     */
    public function create()
    {
        return view('admin.roles.create', [
            'title' => 'Definiting New Role | IBSEA Admin'
        ]);
    }

    /**
     * Store a newly created role in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'role_name' => 'required|string|max:255|unique:member_roles',
            'hierarchy_level' => 'required|integer',
            'show_in_leadership' => 'boolean',
            'card_display_pattern' => 'required|string|in:automatic,alliance,chapter,council,designation',
        ]);

        MemberRole::create($request->all());

        return redirect()->route('admin.roles.index')->with('success', 'Institutional role defined successfully.');
    }

    /**
     * Show the form for editing the specified role.
     */
    public function edit(MemberRole $role)
    {
        return view('admin.roles.edit', [
            'role' => $role,
            'title' => 'Edit Role | ' . $role->role_name
        ]);
    }

    /**
     * Update the specified role in storage.
     */
    public function update(Request $request, MemberRole $role)
    {
        $request->validate([
            'role_name' => 'required|string|max:255|unique:member_roles,role_name,' . $role->id,
            'hierarchy_level' => 'required|integer',
            'show_in_leadership' => 'boolean',
            'card_display_pattern' => 'required|string|in:automatic,alliance,chapter,council,designation',
        ]);

        $role->update($request->all());

        return redirect()->route('admin.roles.index')->with('success', 'Institutional role updated successfully.');
    }

    /**
     * Remove the specified role from storage.
     */
    public function destroy(MemberRole $role)
    {
        $role->delete();
        return redirect()->route('admin.roles.index')->with('success', 'Institutional role decommissioned.');
    }
}
