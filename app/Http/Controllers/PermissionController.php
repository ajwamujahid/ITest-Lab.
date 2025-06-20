<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Permission;

class PermissionController extends Controller
{
    // List all permissions
    public function index()
    {
        $permissions = Permission::all();
        return view('roles.permission', compact('permissions'));
    }

    // Store new permission
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:permissions,name',
        ]);

        Permission::create(['name' => $request->name]);

        return redirect()->route('roles.permission')->with('success', 'Permission created successfully.');
    }

    // Delete permission
    public function destroy(Permission $permission)
    {
        $permission->delete();
        return redirect()->route('roles.permission')->with('success', 'Permission deleted successfully.');
    }
}
