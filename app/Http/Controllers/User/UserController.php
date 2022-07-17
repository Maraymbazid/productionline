<?php

namespace App\Http\Controllers\User;

use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUserRequest;

class UserController extends Controller
{


    public function store(StoreUserRequest $request)
    {
        $user = User::create($request->all());
        $user->roles()->sync($request->input('roles', []));


        return redirect()->back();



        // return (new UserResource($user))
        //     ->response()
        //     ->setStatusCode(Response::HTTP_CREATED);
    }

    public function create()
    {
        $roles = Role::all();
        return view('users.create', compact('roles'));
    }
}
