<?php

namespace App\Http\Controllers;

use App\Models\Role;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    // List all roles
    public function index()
    {
        $roles = Role::all();
        return view('roles.index', compact('roles'));
    }

    // Show create role form
    public function create()
    {
        // Collect all unique permissions from existing roles
        $permissions = Role::pluck('permissions')
            ->filter()
            ->flatMap(fn ($p) => explode(',', $p))
            ->map(fn ($p) => trim($p))
            ->unique()
            ->values()
            ->toArray();

        return view('roles.create', compact('permissions'));
    }

    public function storeWithPermission(Request $request)
    {
        $request->validate([
            'name' => 'required|string|unique:roles,name',
            'permissions' => 'array',
            'new_permission' => 'nullable|string|max:255',
        ]);
    
        // 1. Collect all permissions (selected + new)
        $permissions = $request->permissions ?? [];
    
        if ($request->filled('new_permission')) {
            $permissions[] = trim($request->new_permission);
        }
    
        // 2. Clean and unique
        $permissions = array_unique(array_map('trim', $permissions));
    
        // 3. Save role with comma-separated permissions
        Role::create([
            'name' => $request->name,
            'permissions' => implode(',', $permissions),
        ]);
    
        return redirect()->route('roles.index')->with('success', 'Role created with permissions!');
    }
    
    public function edit(Role $role)
    {
        // All permissions from all roles
        $allPermissions = Role::pluck('permissions')
            ->filter()
            ->flatMap(fn ($p) => explode(',', $p))
            ->map(fn ($p) => trim($p))
            ->filter()
            ->toArray();
    
        // Current role's permissions
        $rolePermissions = explode(',', $role->permissions ?? '');
    
        // Merge both and remove duplicates
        $permissions = collect(array_merge($allPermissions, $rolePermissions))
            ->map(fn ($p) => trim($p))
            ->unique()
            ->values()
            ->toArray();
    
        return view('roles.edit', compact('role', 'permissions', 'rolePermissions'));
    }
    

    // Update role
    public function update(Request $request, Role $role)
    {
        $request->validate([
            'name' => 'required|string|unique:roles,name,' . $role->id,
            'permissions' => 'array',
            'new_permission' => 'nullable|string|max:255',
        ]);

        $permissions = $request->permissions ?? [];

        if ($request->filled('new_permission')) {
            $permissions[] = trim($request->new_permission);
        }

        $permissions = array_unique(array_map('trim', $permissions));

        $role->update([
            'name' => $request->name,
            'permissions' => implode(',', $permissions),
        ]);

        return redirect()->route('roles.index')->with('success', 'Role updated successfully!');
    }

    // Delete role
    public function destroy(Role $role)
    {
        $role->delete();
        return redirect()->route('roles.index')->with('success', 'Role deleted successfully!');
    }
}
