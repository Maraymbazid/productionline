<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use App\Http\Requests\Permission\StorePermission;
class PermissionController extends Controller
{

    public function create()
    {
        return view('admin.permissions.create');
    }

    public function store(StorePermission $request)
    {
        $permission=Permission::create([
            'name'=>$request->name,
        ]);
        if($permission)
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
            $allpermissions=Permission::paginate(8);
            return view('admin.permissions.index',compact('allpermissions'));
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
            $permission = Permission::find($request->id);
            if (!$permission)
            {
                alert()->error('Oops....','this element does not exist .. try again');
                return redirect() -> route('dashboard');
            }
            $permission->delete();
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
        try
        {
            $permission = Permission::find($id);  // search in given table id only
        if (!$permission)
            {
                alert()->error('Oops....','this element does not exist .. try again');
                return redirect() -> route('dashboard');
            }
            $permission = Permission::select('id', 'name')->find($id);
           return view('admin.permissions.edit', compact('permission'));
        }
        catch(Exception $ex)
        {
            alert()->error('Oops....','Something went wrong .. try again');
            return redirect() -> route('adminHome');
        }

    }
    public function update(StorePermission $request)
    {
        $permission = Permission::find($request ->id);
        if (!$permission)
            return response()->json([
                'status' => false,
                'msg' =>'this element does not exist',
            ]);
            $permission->update(
            [
                'name' => $request->name,
            ]
        );
        return response()->json([
            'status' => true,
            'msg' =>'تم تعديل بنجاح'
        ]);
    }
}
