<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;

class PermissionController extends Controller
{

    public function create()
    {
        return view('permissions.create');
    }

    public function store(Request $request)
    {
        $Permission = Permission::create(
            [
                'name' => $request->name
            ]
        );
        return redirect()->back();
    }
}
