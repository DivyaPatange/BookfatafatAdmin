<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\User;
use DB;
use Auth;

class OrderPlacedController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:vendor');
    }

    public function index()
    {
        $orders = DB::table('orders')->get();
        $items = array();
        foreach($orders as $o)
        {
            $orderItems = DB::table('order_items')->where('order_id', $o->id)->where('vendor_id', Auth::guard('vendor')->user()->id)->get();
            foreach($orderItems as $orderItem)
            {
                $items[] = $orderItem->order_id;
            }
        }
        $countOrder = array_unique($items);
        if(request()->ajax()) {
            return datatables()->of($countOrder)
            ->addColumn('payment_status', function($row){
                $order = Order::where('id', $row)->first();    
                if($order->status == "completed")
                {
                    return '<span class="badge badge-success">Completed</span>';
                }  
                else{
                    return '<span class="badge badge-danger">Pending</span>';
                }                                                                                                                                                                                                                                                                                       
            })
            ->addColumn('action', function($row){
                $route = route('admin.view-placed-order', $row);
                return '<a href="'.$route.'" class="btn btn-primary btn-sm">
                <i class="fas fa-eye"></i>
                </a>';
            })
            ->addColumn('user_name', function($row){
                $order = Order::where('id', $row)->first(); 
                $user = User::where('id', $order->user_id)->first();
                return $user->name;
            })
            ->addColumn('mobile_no', function($row){
                $order = Order::where('id', $row)->first(); 
                return $order->mobile_no;
            })
            ->addColumn('order_number', function($row){
                $order = Order::where('id', $row)->first(); 
                return $order->order_number;
            })
            ->addColumn('item_count', function($row){
                $order = Order::where('id', $row)->first(); 
                return $order->item_count;
            })
            ->addColumn('grand_total', function($row){ 
                $order = Order::where('id', $row)->first(); 
                return '<i class="fas fa-rupee">&nbsp;</i>'.$order->grand_total;
            })
            ->rawColumns(['action', 'payment_status', 'grand_total'])
            ->addIndexColumn()
            ->make(true);
        }
        return view('vendor.placed-order.index');
    }

    public function show($id)
    {
        $order = Order::findorfail($id);
        return view('vendor.placed-order.show', compact('order'));
    }
}
