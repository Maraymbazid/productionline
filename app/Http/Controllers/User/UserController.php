<?php

namespace App\Http\Controllers\User;

use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserReequest;
use DB;
use Hash;
use Illuminate\Support\Arr;
class UserController extends Controller
{
    public function store(StoreUserRequest $request)
    {
        $input = $request->all();
        $input['password'] = Hash::make($input['password']);
    
        $user = User::create($input);
        $user->assignRole($request->input('roles'));

        return redirect()->route('users.index')
                        ->with('success','User created successfully');
    }

    public function create()
    {
        $roles = Role::pluck('name','name')->all();
        return view('admin.users.create', compact('roles'));
    }
    public function index()
    {
        $users = User::paginate(5);
        return view('admin.users.index',compact('users'));
           
    }
    public function delete(Request $request)
    {
        try
        {
            $user = User::find($request->id);
            if (!$user)
            {
                alert()->error('Oops....','this element does not exist .. try again');
                return redirect() -> route('dashboard');
            }
            $user->delete();
                return response()->json([
                    'status' => true,
                    'msg' => 'تم الحذف بنجاح',
                    'id' => $request->id
                ]);

        }
        catch(Exception $ex)
        {
            alert()->error('Oops....','Something went wrong .. try again');
            return redirect() -> route('dashboard');
        }
       
    }
    public function edit($id)
    {
        $user = User::find($id);
        $roles = Role::pluck('name','name')->all();
        $userRole = $user->roles->pluck('name','name')->all();
        return view('admin.users.edit',compact('user','roles','userRole'));
    }
    public function update(UpdateUserReequest $request, $id)
    {

        $input = $request->all();
        if(!empty($input['password'])){ 
            $input['password'] = Hash::make($input['password']);
        }else{
            $input = Arr::except($input,array('password'));    
        }
    
        $user = User::find($id);
        $user->update($input);
        DB::table('role_user')->where('user_id',$id)->delete();
    
        $user->assignRole($request->input('roles'));
    
        return redirect()->route('users.index')
                        ->with('success','User updated successfully');
    }
    public function show($id)
    {
        $user = User::find($id);
        return view('admin.users.show',compact('user'));
    }
}
