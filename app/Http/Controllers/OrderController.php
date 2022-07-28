<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{

    public function index()
    {

        return view('admin.orders.index');
    }



    public function create()
    {
        $invoiceStatusArr = Order::STATUS_ARR;
        unset($invoiceStatusArr[Order::STATUS_ALL]);
        $data['statusArr'] = $invoiceStatusArr;

        return view('admin.orders.create', $data);
    }

    public function edit($id)
    {
        return $id;
    }

    public function store(Request $request)
    {
        $request->validate([
            'code'     => 'required',
        ], [
            'code.required' => 'رقم الباتش مطلوب',
        ]);



        $order = new Order();
        $order->user_id = Auth::user()->id;
        $order->code = $request->code;
        $order->status = 0;
        $order->order_id =  Order::generateUniqueInvoiceId();
        $order->save();
        return response()->json(['msg' => 'تم إضافة طلب جديد '], 200);
    }

    public function delete(Request $request)
    {
        try {
            $order = Order::find($request->id);
            if (!$order) {
                alert()->error('Oops....', 'this element does not exist .. try again');
                return redirect()->route('dashboard');
            }
            $order->delete();
            return response()->json([
                'status' => true,
                'msg' => 'تم الحذف بنجاح',
                'id' => $request->id
            ]);
        } catch (Exception $ex) {
            alert()->error('Oops....', 'Something went wrong .. try again');
            return redirect()->route('dashboard');
        }
    }
}
