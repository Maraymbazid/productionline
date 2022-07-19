<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Http\Requests\Roles\StoreRole;
use Illuminate\Support\Facades\DB;
class RoleController extends Controller
{


    public function create()
    {
        $permission = Permission::get();
        return view('admin.roles.create',compact('permission'));
    }

    public function store(StoreRole $request)
    {
        $role = Role::create(['name' => $request->input('name')]);
        $role->syncPermissions($request->input('permissions'));
        if($role)
        {
         $status = 200;
         $msg  = 'تم حفظ الداتا بنجاح ';
         }
        else 
        {
            $status = 500;
            $msg  = ' تعذر الحفظ هناك خطأ ما';
        }
        return response()->json([
            'status' => $status,
            'msg' => $msg
        ]);
    }
    public function index()
    {
        try
        {
            $roles=Role::paginate(8);
            return view('admin.roles.index',compact('roles'));
        }
        catch(Exception $ex)
        {
                alert()->error('Oops....','Something went wrong .. try again');
                return redirect() -> route('dashboard');
        }
    }
    public function delete(Request $request)
    {
        try
        {
            $role = Role::find($request->id);
            if (!$role)
            {
                alert()->error('Oops....','this element does not exist .. try again');
                return redirect() -> route('dashboard');
            }
            $role->delete();
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
        $role = Role::find($id);
        $permission = Permission::get();
        $rolePermissions = DB::table("role_has_permissions")->where("role_has_permissions.role_id",$id)
            ->pluck('role_has_permissions.permission_id','role_has_permissions.permission_id')
            ->all();
        return view('admin.roles.edit',compact('role','permission','rolePermissions'));
    }
    public function update(Request $request)
    {
        $role = Role::find($request ->id);
        if (!$role)
            return response()->json([
                'status' => false,
                'msg' =>'this element does not exist',
            ]);
        $role->name = $request->name;
        $role->save();
        $role->syncPermissions($request->input('permissions'));
        return response()->json([
            'status' => true,
            'msg' =>'تم تعديل بنجاح'
        ]);
    }
}
