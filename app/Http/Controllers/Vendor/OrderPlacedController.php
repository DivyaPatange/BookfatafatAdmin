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

    public function allOrders()
    {
        $orders = DB::table('orders')
        ->orWhere(function($query) {
            $query->where('confirmed_at', null)
                  ->where('rejected_at', null);
        })
        ->get();
        // dd($orders);
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
            ->addColumn('action', function($row){
                $route = route('vendor.view-placed-order', $row);
                $payment = DB::table('payments')->where('order_id', $row)->whereNotNull('invoice_file')->first();
                $output = ''; 
                $output .= '<a href="'.$route.'" class="btn btn-primary btn-sm" style="padding: 0.1rem 0.25rem; margin-right:5px;">
                <i class="fas fa-eye"></i>
                </a>';
                if(!empty($payment)){
                    $filePath = 'https://bookfatafat.com/Invoice/'.$payment->invoice_file;
                    $output .= '<a class="btn btn-warning btn-sm text-white" style="padding: 0.1rem 0.25rem;" target="_blank" href="'.$filePath.'"><i class="fas fa-file"></i></a>';
                }
                return $output;
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
            ->addColumn('grand_total', function($row){ 
                $order = Order::where('id', $row)->first(); 
                return '<i class="fas fa-rupee">&nbsp;</i>'.$order->grand_total;
            })
            ->addColumn('order_status', function($row){
                return '<button type="button" data-id="'.$row.'" class="btn btn-success btn-sm confirmed" style="padding: 0.1rem 0.25rem;">
                    <i class="fas fa-check"></i>
                </button>
                <button type="button" data-id="'.$row.'" class="btn btn-danger btn-sm rejected" style="padding: 0.1rem 0.25rem;">
                    <i class="fas fa-close"></i>
                </button>
                ';
            })
            ->rawColumns(['action', 'payment_status', 'grand_total', 'invoice_file', 'order_status'])
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

    public function shippingStatus(Request $request)
    {
        $order = Order::findorfail($request->id);
        if($order->is_ship == "Yes")
        {
            $order->is_ship = "No";
            $order->dispatch_at = date('Y-m-d H:i:s');
        }
        else{
            $order->is_ship = "Yes";
            $order->dispatch_at = date('Y-m-d H:i:s');
        }
        $order->update($request->all());
        return response()->json(['success' => 'Ready to shipped!']);
    }

    public function deliveryStatus(Request $request)
    {
        $order = Order::findorfail($request->id);
        if($order->is_deliver == "Yes")
        {
            $order->is_deliver = "No";
            $order->deliver_at = date('Y-m-d H:i:s');
        }
        else{
            $order->is_deliver = "Yes";
            $order->deliver_at = date('Y-m-d H:i:s');
        }
        $order->update($request->all());
        return response()->json(['success' => 'Order Delivered Successfully!']);
    }

    public function orderConfirmed(Request $request)
    {
        $order = Order::findorfail($request->id);
        $order->confirmed_at = date('Y-m-d H:i:s');
        $order->rejected_at = null;
        $order->update($request->all());
        return response()->json(['success' => 'Order Confirmed Successfully!']);
    }

    public function orderRejected(Request $request)
    {
        $order = Order::findorfail($request->id);
        $order->confirmed_at = null;
        $order->rejected_at = date('Y-m-d H:i:s');
        $order->update($request->all());
        return response()->json(['success' => 'Order Rejected Successfully!']);
    }

    public function confirmedOrderList()
    {
        $orders = DB::table('orders')->whereNotNull('confirmed_at')->where('is_ship', 'No')->get();
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
            ->addColumn('action', function($row){
                $route = route('vendor.view-placed-order', $row);
                $payment = DB::table('payments')->where('order_id', $row)->whereNotNull('invoice_file')->first();
                $output = ''; 
                $output .= '<a href="'.$route.'" class="btn btn-primary btn-sm" style="padding: 0.1rem 0.25rem; margin-right:5px;">
                <i class="fas fa-eye"></i>
                </a>';
                if(!empty($payment)){
                    $filePath = 'https://bookfatafat.com/Invoice/'.$payment->invoice_file;
                    $output .= '<a class="btn btn-warning btn-sm text-white" style="padding: 0.1rem 0.25rem;" target="_blank" href="'.$filePath.'"><i class="fas fa-file"></i></a>';
                }
                return $output;
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
            ->addColumn('grand_total', function($row){ 
                $order = Order::where('id', $row)->first(); 
                return '<i class="fas fa-rupee">&nbsp;</i>'.$order->grand_total;
            })
            ->addColumn('ship_status', function($row){
                return '<div class="custom-control custom-switch">
                <input type="checkbox" class="custom-control-input is-ship" id="customSwitch'.$row.'" data-id="'.$row.'">
                <label class="custom-control-label" for="customSwitch'.$row.'"></label>
              </div>';
            })
            ->rawColumns(['action', 'payment_status', 'grand_total', 'ship_status'])
            ->addIndexColumn()
            ->make(true);
        }
        return view('vendor.placed-order.confirmed');
    }

    public function rejectedOrderList()
    {
        $orders = DB::table('orders')->whereNotNull('rejected_at')->get();
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
            ->addColumn('action', function($row){
                $route = route('vendor.view-placed-order', $row);
                $payment = DB::table('payments')->where('order_id', $row)->whereNotNull('invoice_file')->first();
                $output = ''; 
                $output .= '<a href="'.$route.'" class="btn btn-primary btn-sm" style="padding: 0.1rem 0.25rem;">
                <i class="fas fa-eye"></i>
                </a>';
                if(!empty($payment)){
                    $filePath = 'https://bookfatafat.com/Invoice/'.$payment->invoice_file;
                    $output .= '<a class="btn btn-warning btn-sm text-white" style="padding: 0.1rem 0.25rem;" target="_blank" href="'.$filePath.'"><i class="fas fa-file"></i></a>';
                }
                return $output;
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
            ->addColumn('grand_total', function($row){ 
                $order = Order::where('id', $row)->first(); 
                return '<i class="fas fa-rupee">&nbsp;</i>'.$order->grand_total;
            })
            ->addColumn('ship_status', function($row){
                return '<button type="button" data-id="'.$row.'" class="btn btn-success btn-sm confirmed" style="padding: 0.1rem 0.25rem; margin-right:5px;">
                    <i class="fas fa-check"></i>
                </button>';
            })
            ->rawColumns(['action', 'payment_status', 'grand_total', 'invoice_file', 'ship_status'])
            ->addIndexColumn()
            ->make(true);
        }
        return view('vendor.placed-order.rejected');
    }

    public function shippedOrderList() 
    {
        $orders = DB::table('orders')->whereNotNull('confirmed_at')->where('is_ship', 'Yes')->where('is_deliver', 'No')->get();
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
            ->addColumn('action', function($row){
                $route = route('vendor.view-placed-order', $row);
                $payment = DB::table('payments')->where('order_id', $row)->whereNotNull('invoice_file')->first();
                $output = ''; 
                $output .= '<a href="'.$route.'" class="btn btn-primary btn-sm" style="padding: 0.1rem 0.25rem; margin-right:5px;">
                <i class="fas fa-eye"></i>
                </a>';
                if(!empty($payment)){
                    $filePath = 'https://bookfatafat.com/Invoice/'.$payment->invoice_file;
                    $output .= '<a class="btn btn-warning btn-sm text-white" style="padding: 0.1rem 0.25rem;" target="_blank" href="'.$filePath.'"><i class="fas fa-file"></i></a>';
                }
                return $output;
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
            ->addColumn('grand_total', function($row){ 
                $order = Order::where('id', $row)->first(); 
                return '<i class="fas fa-rupee">&nbsp;</i>'.$order->grand_total;
            })
            ->addColumn('deliver_status', function($row){
                return '<div class="custom-control custom-switch">
                <input type="checkbox" class="custom-control-input is-deliver" id="customSwitch'.$row.'" data-id="'.$row.'">
                <label class="custom-control-label" for="customSwitch'.$row.'"></label>
              </div>';
            })
            ->rawColumns(['action', 'payment_status', 'grand_total', 'deliver_status'])
            ->addIndexColumn()
            ->make(true);
        }
        return view('vendor.placed-order.shipped');
    }

    public function deliveredOrderList()
    {
        $orders = DB::table('orders')->whereNotNull('confirmed_at')->where('is_ship', 'Yes')->where('is_deliver', 'Yes')->get();
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
            ->addColumn('action', function($row){
                $route = route('vendor.view-placed-order', $row);
                $payment = DB::table('payments')->where('order_id', $row)->whereNotNull('invoice_file')->first();
                $output = ''; 
                $output .= '<a href="'.$route.'" class="btn btn-primary btn-sm" style="padding: 0.1rem 0.25rem; margin-right:5px;">
                <i class="fas fa-eye"></i>
                </a>';
                if(!empty($payment)){
                    $filePath = 'https://bookfatafat.com/Invoice/'.$payment->invoice_file;
                    $output .= '<a class="btn btn-warning btn-sm text-white" style="padding: 0.1rem 0.25rem;" target="_blank" href="'.$filePath.'"><i class="fas fa-file"></i></a>';
                }
                return $output;
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
            ->addColumn('grand_total', function($row){ 
                $order = Order::where('id', $row)->first(); 
                return '<i class="fas fa-rupee">&nbsp;</i>'.$order->grand_total;
            })
            ->rawColumns(['action', 'payment_status', 'grand_total'])
            ->addIndexColumn()
            ->make(true);
        }
        return view('vendor.placed-order.delivered');
    }
}
