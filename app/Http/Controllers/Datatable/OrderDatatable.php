<?php

namespace App\Http\Controllers\Datatable;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Order;
use DataTables;


class OrderDatatable extends Controller
{


    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Order::latest()->get();
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('name', function ($row) {
                    $name = $row->Name->name;
                    return $name;
                })
                ->addColumn('status', function ($row) {
                    $status = $row->status ? 'Active' : 'Inactive';
                    return $status;
                })
                ->addColumn('action', function ($row) {
                    $url = route('orders.edit', $row->id);
                    $actionBtn = '<a href="' . $url . '"  class="edit btn btn-success btn-sm">Edit</a> <a href="javascript:void(0)" name="' . $row->Name->name . '" value="' . $row->id . '" class="delete btn btn-danger btn-sm">Delete</a>';
                    return $actionBtn;
                })
                ->rawColumns(['action', 'name', 'status'])
                ->make(true);
        }
    }
}
