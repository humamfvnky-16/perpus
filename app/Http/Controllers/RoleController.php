<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
    public function index()
    {
        $roles = Role::with('permissions')->get();
        return view('roles.index', compact('roles'));
    }

    public function create() { return view('roles.create', ['permissions' => Permission::all()]); }

    public function store(Request $r)
    {
        $r->validate(['name' => 'required|string|unique:roles,name']);
        $role = Role::create(['name' => $r->name, 'guard_name' => 'web']);
        $role->syncPermissions($r->input('permissions', []));
        return redirect()->route('roles.index')->with('toast', 'Role dibuat.');
    }

    public function edit(Role $role)
    {
        return view('roles.edit', ['role' => $role, 'permissions' => Permission::all()]);
    }

    public function update(Request $r, Role $role)
    {
        $role->update(['name' => $r->name]);
        $role->syncPermissions($r->input('permissions', []));
        return back()->with('toast', 'Role diperbarui.');
    }

    public function destroy(Role $role)
    {
        $role->delete();
        return redirect()->route('roles.index')->with('toast', 'Role dihapus.');
    }
}
