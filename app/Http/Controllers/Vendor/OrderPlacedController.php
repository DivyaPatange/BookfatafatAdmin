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
                if($order->payment_status == "Completed")
                {
                    return '<span class="badge badge-success">Completed</span>';
                }  
                else{
                    return '<span class="badge badge-danger">Pending</span>';
                }                                                                                                                                                                                                                                                                                       
            })
            ->addColumn('is_ship', function($row){
                $order = Order::where('id', $row)->first();    
                if($order->is_ship == "Yes")
                {
                    return '<div class="custom-control custom-switch">
                    <input type="checkbox" class="custom-control-input" id="customSwitch1" checked data-id="'.$order->id.'">
                    <label class="custom-control-label" for="customSwitch1"></label>
                  </div>';
                }  
                else{
                    return '<div class="custom-control custom-switch">
                    <input type="checkbox" class="custom-control-input" id="customSwitch1" data-id="'.$order->id.'">
                    <label class="custom-control-label" for="customSwitch1"></label>
                  </div>';
                }                                                                                                                                                                                                                                                                                       
            })
            ->addColumn('is_deliver', function($row){
                $order = Order::where('id', $row)->first();    
                if($order->is_deliver == "Yes")
                {
                    return '<div class="custom-control custom-switch">
                    <input type="checkbox" class="custom-control-input" id="customSwitch2" checked data-id="'.$order->id.'">
                    <label class="custom-control-label" for="customSwitch2"></label>
                  </div>';
                }  
                else{
                    return '<div class="custom-control custom-switch">
                    <input type="checkbox" class="custom-control-input" id="customSwitch2" data-id="'.$order->id.'">
                    <label class="custom-control-label" for="customSwitch2"></label>
                  </div>';
                }                                                                                                                                                                                                                                                                                       
            })
            ->addColumn('action', function($row){
                $route = route('vendor.view-placed-order', $row);
                return '<a href="'.$route.'" class="btn btn-primary btn-sm">
                <i class="fas fa-eye"></i>
                </a>';
            })
            ->addColumn('user_name', function($row){
                $order = Order::where('id', $row)->first(); 
                return $order->name;
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
            ->addColumn('invoice_file', function($row){ 
                $payment = DB::table('payments')->where('order_id', $row)->first(); 
                if(!empty($payment)){
                $filePath = 'https://bookfatafat.com/Invoice/'.$payment->invoice_file;
                return '<a class="btn btn-warning btn-sm text-white" target="_blank" href="'.$filePath.'"><i class="fas fa-file"></i></a>';
                }
            })
            ->rawColumns(['action', 'payment_status', 'grand_total', 'invoice_file', 'is_ship', 'is_deliver'])
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

    public function isShip(Request $request, $id)
    {
        $order = Order::findorfail($id);
        if($order->is_ship == "Yes")
        {
            $order->is_ship = "No";
        }
        else{
            $order->is_ship = "Yes";
        }
        $order->update($request->all());
        return response()->json(['success' => 'Shipping Status Changed Successfully!']);
    }

    public function isDeliver(Request $request, $id)
    {
        $order = Order::findorfail($id);
        if($order->is_deliver == "Yes")
        {
            $order->is_deliver = "No";
        }
        else{
            $order->is_deliver = "Yes";
        }
        $order->update($request->all());
        return response()->json(['success' => 'Order Deliver Status Changed Successfully!']);
    }
}
