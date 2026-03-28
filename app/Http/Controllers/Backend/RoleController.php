<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
    public function index()
    {
        $search = request('search');
        $roles = Role::query()
            ->withCount('permissions')
            ->orderBy('name')
            ->when($search, function ($query, $search) {
                $s = addcslashes($search, '%_\\');
                $query->where('name', 'like', '%'.$s.'%');
            })
            ->paginate(10)
            ->withQueryString();

        return view('backend.roles.index', compact('roles', 'search'));
    }

    public function create()
    {
        $permissions = Permission::orderBy('name')->get();

        return view('backend.roles.create_edit', [
            'permissions' => $permissions,
            'role' => null,
            'rolePermissionNames' => [],
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:roles,name',
            'permissions' => 'required|array',
            'permissions.*' => 'string|exists:permissions,name',
        ]);

        $role = Role::create(['name' => $request->name]);
        $role->syncPermissions($request->permissions);

        return redirect()->route('backend.roles.index')->with('success', 'Role created successfully.');
    }

    public function edit(string $id)
    {
        $role = Role::findById((int) $id);
        $permissions = Permission::orderBy('name')->get();
        $rolePermissionNames = $role->permissions->pluck('name')->all();

        return view('backend.roles.create_edit', compact('role', 'permissions', 'rolePermissionNames'));
    }

    public function update(Request $request, string $id)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:roles,name,'.$id,
            'permissions' => 'required|array',
            'permissions.*' => 'string|exists:permissions,name',
        ]);

        $role = Role::findById((int) $id);
        $role->update(['name' => $request->name]);
        $role->syncPermissions($request->permissions);

        return redirect()->route('backend.roles.index')->with('success', 'Role updated successfully.');
    }

    public function destroy(string $id)
    {
        $role = Role::findById((int) $id);
        $role->delete();

        return redirect()->route('backend.roles.index')->with('success', 'Role deleted successfully.');
    }
}
