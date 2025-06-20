<?php
namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\Permission;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    // List all roles
    public function index()
    {
        $roles = Role::with('permissions')->get();
        return view('roles.index', compact('roles'));
    }

    public function create()
{
    $permissions = Permission::all();
    return view('roles.create', compact('permissions'));
}


    public function store(Request $request)
{
    $request->validate([
        'name' => 'required|unique:roles,name',
        'permissions' => 'array',   // permissions selected
    ]);

    $role = Role::create(['name' => $request->name]);

    if ($request->has('permissions')) {
        $role->permissions()->sync($request->permissions);
    }

    return redirect()->route('roles.index')->with('success', 'Role created successfully.');
}

    // Show edit form
    public function edit(Role $role)
    {
        $permissions = Permission::all();
        $rolePermissions = $role->permissions()->pluck('id')->toArray();
        return view('roles.edit', compact('role', 'permissions', 'rolePermissions'));
    }

    // Update role
    public function update(Request $request, Role $role)
    {
        $data = $request->validate([
            'name' => 'required|unique:roles,name,' . $role->id,
            'permissions' => 'array',
            'permissions.*' => 'exists:permissions,id',
        ]);

        $role->update(['name' => $data['name']]);
        $role->permissions()->sync($data['permissions'] ?? []);

        return redirect()->route('roles.index')->with('success', 'Role updated successfully!');
    }

    // Delete role
    public function destroy(Role $role)
    {
        $role->delete();
        return redirect()->route('roles.index')->with('success', 'Role deleted successfully!');
    }
    public function storeWithPermission(Request $request)
{
    // Validate
    $request->validate([
        'name' => 'required|string|unique:roles,name',
        'permissions' => 'array|exists:permissions,id',
        'new_permission' => 'nullable|string|unique:permissions,name',
    ]);

    \DB::beginTransaction();

    try {
        // 1. If new permission provided, create it
        $newPermissionId = null;
        if ($request->filled('new_permission')) {
            $newPermission = Permission::create([
                'name' => $request->new_permission,
            ]);
            $newPermissionId = $newPermission->id;
        }

        // 2. Create Role
        $role = Role::create(['name' => $request->name]);

        // 3. Collect all permission IDs (existing + new one if added)
        $permissionIds = $request->input('permissions', []);
        if ($newPermissionId) {
            $permissionIds[] = $newPermissionId;
        }

        // 4. Attach permissions to role
        $role->permissions()->sync($permissionIds);

        \DB::commit();

        return redirect()->back()->with('success', 'Role and permission created successfully!');
    } catch (\Exception $e) {
        \DB::rollback();
        return redirect()->back()->withErrors('Error: ' . $e->getMessage())->withInput();
    }
}

}
