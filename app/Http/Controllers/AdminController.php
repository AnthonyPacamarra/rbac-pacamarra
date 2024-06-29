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
        $users = User::select('users.id', 'userinfos.user_firstname', 'userinfos.user_lastname', 'users.email')
                     ->join('userinfos', 'users.id', '=', 'userinfos.user_id')
                     ->get();

        $roles = Role::all();
        $permissions = Permission::all();

        return view('admin.manageUsers')->with(compact('users', 'roles'));
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

    public function indexRoles()
    {
        $roles = Role::all();
        return view('admin.roles.index', compact('roles'));
    }

    public function createRole()
    {
        return view('admin.roles.create');
    }

    public function storeRole(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:roles|max:255',
        ]);

        Role::create([
            'name' => $request->name,
        ]);

        return redirect()->route('roles.index')->with('success', 'Role created successfully.');
    }

    public function editRole(Role $role)
    {
        return view('admin.roles.edit', compact('role'));
    }

    public function updateRole(Request $request, Role $role)
    {
        $request->validate([
            'name' => 'required|unique:roles,name,'.$role->id.'|max:255',
        ]);

        $role->update([
            'name' => $request->name,
        ]);

        return redirect()->route('roles.index')->with('success', 'Role updated successfully.');
    }

    public function deleteRole(Role $role)
    {
        $role->delete();

        return redirect()->route('roles.index')->with('success', 'Role deleted successfully.');
    }
}
