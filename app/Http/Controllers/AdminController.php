<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\UserInfo;
use App\Models\Role;
use App\Models\Permission;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index()
    {
        return view('admin.dashboard');
    }

    public function manageUsers()
    {
        $users = User::with('roles.permissions', 'userInfo')->get();
        $roles = Role::all();
        $permissions = Permission::all();

        foreach ($users as $user) {
            $userPermissions = collect();
            foreach ($user->roles as $role) {
                $userPermissions = $userPermissions->merge($role->permissions);
            }
            $user->permissions = $userPermissions->unique('id');
        }

        return view('admin.manageUsers', compact('users', 'roles', 'permissions'));
    }

    public function updateRoles(Request $request)
    {
        $users = User::all();

        foreach ($users as $user) {
            $userRoles = $request->input("roles.{$user->id}", []);
            $user->roles()->sync($userRoles);
        }

        return redirect()->route('usertool')->with('success', 'User roles updated successfully.');
    }

    public function deleteUser(User $user)
    {
        $user->delete();

        return redirect()->route('usertool')->with('success', 'User deleted successfully.');
    }



    public function indexRoles()
    {
        $roles = Role::with('permissions')->get();
        return view('admin.roles.index', compact('roles'));
    }
    

    public function createRole()
    {
        $permissions = Permission::all();
        return view('admin.roles.create', compact('permissions'));
    }

    public function storeRole(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:roles',
        ]);

        $role = Role::create([
            'name' => $request->name,
        ]);

        if ($request->has('permissions')) {
            $role->permissions()->sync($request->permissions);
        }

        return redirect()->route('roles.index')->with('success', 'Role created successfully.');
    }

    public function viewUsersByRole(Role $role)
    {
        $users = $role->users()->with('userInfo')->get();

        return view('admin.roles.viewUsers', compact('role', 'users'));
    }

    public function editRole(Role $role)
    {
        $permissions = Permission::all();
        return view('admin.roles.edit', compact('role', 'permissions'));
    }

    public function updateRole(Request $request, Role $role)
    {
        $request->validate([
            'name' => 'required|unique:roles,name,' . $role->id,
        ]);

        $role->update([
            'name' => $request->name,
        ]);

        $role->permissions()->sync($request->permissions);

        return redirect()->route('roles.index')->with('success', 'Role updated successfully.');
    }

    public function deleteRole(Role $role)
    {
        $role->delete();

        return redirect()->route('roles.index')->with('success', 'Role deleted successfully.');
    }
}
