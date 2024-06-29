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

    public function manageUsers(){
        $users = User::select('id','name','email')->get();
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
}
