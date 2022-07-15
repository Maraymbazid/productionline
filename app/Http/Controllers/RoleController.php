<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{


    public function create()
    {
        return view('roles.create');
    }

    public function store(Request $request)
    {
        $role = Role::create(
            [
                'name' => $request->name
            ]
        );
        return redirect()->back();
    }
}
