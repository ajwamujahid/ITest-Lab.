<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleController extends Controller
{
    // ✅ Show all roles
    public function index()
    {
        $roles = Role::with('permissions')->get(); // eager load permissions
        return view('roles.index', compact('roles'));
    }

    // ✅ Show create form
    public function create()
    {
        $permissions = Permission::pluck('name')->toArray();
        return view('roles.create', compact('permissions'));
    }

    // ✅ Store role with permissions (UI form)
    public function storeWithPermission(Request $request)
    {
        $request->validate([
            'name' => 'required|string|unique:roles,name',
            'permissions' => 'array',
            'new_permission' => 'nullable|string|max:255',
        ]);

        // Add new permission if user typed one
        if ($request->filled('new_permission')) {
            Permission::firstOrCreate(['name' => trim($request->new_permission)]);
        }

        // All selected + newly added permission names
        $permissions = $request->permissions ?? [];

        if ($request->filled('new_permission')) {
            $permissions[] = trim($request->new_permission);
        }

        // ✅ Create role & assign permissions
        $role = Role::create(['name' => $request->name]);
        $role->syncPermissions($permissions);

        return redirect()->route('roles.index')->with('success', 'Role created with permissions!');
    }

    // ✅ Show edit form
    public function edit($id)
    {
        $role = Role::findOrFail($id);
        $permissions = Permission::pluck('name')->toArray();
        $rolePermissions = $role->permissions->pluck('name')->toArray();

        return view('roles.edit', compact('role', 'permissions', 'rolePermissions'));
    }

    // ✅ Update role & permissions
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|unique:roles,name,' . $id,
            'permissions' => 'array',
            'new_permission' => 'nullable|string|max:255',
        ]);

        $role = Role::findOrFail($id);

        // Add new permission if needed
        if ($request->filled('new_permission')) {
            Permission::firstOrCreate(['name' => trim($request->new_permission)]);
        }

        $permissions = $request->permissions ?? [];
        if ($request->filled('new_permission')) {
            $permissions[] = trim($request->new_permission);
        }

        // ✅ Update role + permissions
        $role->update(['name' => $request->name]);
        $role->syncPermissions($permissions);

        return redirect()->route('roles.index')->with('success', 'Role updated successfully!');
    }

    // ✅ Delete role
    public function destroy($id)
    {
        $role = Role::findOrFail($id);
        $role->delete();
        return redirect()->route('roles.index')->with('success', 'Role deleted successfully!');
    }
}
