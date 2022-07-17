<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleController extends Controller
{


    public function create()
    {
        return view('roles.create');
    }

    public function store(Request $request)
    {
        // $permission = Permission::all();
        // $role = Role::find(5);
        // $role->syncPermissions($permission);

        // $user = User::find(1);
        // $user->assignRole('admin');

        $role = Role::create(
            [
                'name' => $request->name
            ]
        );
        return redirect()->back();
    }
}
