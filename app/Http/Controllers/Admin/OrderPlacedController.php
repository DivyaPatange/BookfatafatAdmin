<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\User;
use DB;

class OrderPlacedController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }
    
    public function index()
    {
        $orders = DB::table('orders')
        ->orWhere(function($query) {
            $query->where('confirmed_at', null)
                  ->where('rejected_at', null);
        })
        ->get();
        // dd($orders);
        if(request()->ajax()) {
            return datatables()->of($orders)
            ->addColumn('payment_status', function($row){    
                if($row->payment_status == "Completed")
                {
                    return '<span class="badge badge-success">Completed</span>';
                }  
                else{
                    return '<span class="badge badge-danger">Pending</span>';
                }                                                                                                                                                                                                                                                                                      
            })
            ->addColumn('action', function($row){
                $route = route('admin.view-placed-order', $row->id);
                return '<a href="'.$route.'" class="btn btn-primary btn-sm" style="padding: 0.1rem 0.25rem;">
                <i class="fas fa-eye"></i>
                </a>';
            })
            ->addColumn('user_name', function($row){
                return $row->name;
            })
            ->addColumn('grand_total', function($row){ 
                return '<i class="fas fa-rupee">&nbsp;</i>'.$row->grand_total;
            })
            ->addColumn('invoice_file', function($row){ 
                $payment = DB::table('payments')->where('order_id', $row->id)->whereNotNull('invoice_file')->first();
                if(!empty($payment)){
                $filePath = 'https://bookfatafat.com/Invoice/'.$payment->invoice_file;
                return '<a class="btn btn-warning btn-sm text-white" target="_blank" href="'.$filePath.'" style="padding: 0.1rem 0.25rem;"><i class="fas fa-file"></i></a>';
                } else {
                    return '-';
                }
            })
            ->rawColumns(['action', 'payment_status', 'grand_total', 'invoice_file'])
            ->addIndexColumn()
            ->make(true);
        }
        return view('admin.placed-order.index');
    }

    public function confirmedOrder()
    {
        $orders = DB::table('orders')
        ->whereNotNull('confirmed_at')->where('is_ship', 'No')
        ->get();
        // dd($orders);
        if(request()->ajax()) {
            return datatables()->of($orders)
            ->addColumn('payment_status', function($row){    
                if($row->payment_status == "Completed")
                {
                    return '<span class="badge badge-success">Completed</span>';
                }  
                else{
                    return '<span class="badge badge-danger">Pending</span>';
                }                                                                                                                                                                                                                                                                                      
            })
            ->addColumn('action', function($row){
                $route = route('admin.view-placed-order', $row->id);
                return '<a href="'.$route.'" class="btn btn-primary btn-sm" style="padding: 0.1rem 0.25rem;">
                <i class="fas fa-eye"></i>
                </a>';
            })
            ->addColumn('user_name', function($row){
                return $row->name;
            })
            ->addColumn('grand_total', function($row){ 
                return '<i class="fas fa-rupee">&nbsp;</i>'.$row->grand_total;
            })
            ->addColumn('invoice_file', function($row){ 
                $payment = DB::table('payments')->where('order_id', $row->id)->whereNotNull('invoice_file')->first();
                if(!empty($payment)){
                $filePath = 'https://bookfatafat.com/Invoice/'.$payment->invoice_file;
                return '<a class="btn btn-warning btn-sm text-white" target="_blank" href="'.$filePath.'" style="padding: 0.1rem 0.25rem;"><i class="fas fa-file"></i></a>';
                } else {
                    return '-';
                }
            })
            ->rawColumns(['action', 'payment_status', 'grand_total', 'invoice_file'])
            ->addIndexColumn()
            ->make(true);
        }
        return view('admin.placed-order.confirmed-order');
    }

    public function shippedOrder()
    {
        $orders = DB::table('orders')
        ->whereNotNull('confirmed_at')->where('is_ship', 'Yes')->where('is_deliver', 'No')
        ->get();
        // dd($orders);
        if(request()->ajax()) {
            return datatables()->of($orders)
            ->addColumn('payment_status', function($row){    
                if($row->payment_status == "Completed")
                {
                    return '<span class="badge badge-success">Completed</span>';
                }  
                else{
                    return '<span class="badge badge-danger">Pending</span>';
                }                                                                                                                                                                                                                                                                                      
            })
            ->addColumn('action', function($row){
                $route = route('admin.view-placed-order', $row->id);
                return '<a href="'.$route.'" class="btn btn-primary btn-sm" style="padding: 0.1rem 0.25rem;">
                <i class="fas fa-eye"></i>
                </a>';
            })
            ->addColumn('user_name', function($row){
                return $row->name;
            })
            ->addColumn('grand_total', function($row){ 
                return '<i class="fas fa-rupee">&nbsp;</i>'.$row->grand_total;
            })
            ->addColumn('invoice_file', function($row){ 
                $payment = DB::table('payments')->where('order_id', $row->id)->whereNotNull('invoice_file')->first();
                if(!empty($payment)){
                $filePath = 'https://bookfatafat.com/Invoice/'.$payment->invoice_file;
                return '<a class="btn btn-warning btn-sm text-white" target="_blank" href="'.$filePath.'" style="padding: 0.1rem 0.25rem;"><i class="fas fa-file"></i></a>';
                } else {
                    return '-';
                }
            })
            ->rawColumns(['action', 'payment_status', 'grand_total', 'invoice_file'])
            ->addIndexColumn()
            ->make(true);
        }
        return view('admin.placed-order.shipped-order');
    }

    public function deliveredOrder()
    {
        $orders = DB::table('orders')
        ->whereNotNull('confirmed_at')->where('is_ship', 'Yes')->where('is_deliver', 'Yes')
        ->get();
        // dd($orders);
        if(request()->ajax()) {
            return datatables()->of($orders)
            ->addColumn('payment_status', function($row){    
                if($row->payment_status == "Completed")
                {
                    return '<span class="badge badge-success">Completed</span>';
                }  
                else{
                    return '<span class="badge badge-danger">Pending</span>';
                }                                                                                                                                                                                                                                                                                      
            })
            ->addColumn('action', function($row){
                $route = route('admin.view-placed-order', $row->id);
                return '<a href="'.$route.'" class="btn btn-primary btn-sm" style="padding: 0.1rem 0.25rem;">
                <i class="fas fa-eye"></i>
                </a>';
            })
            ->addColumn('user_name', function($row){
                return $row->name;
            })
            ->addColumn('grand_total', function($row){ 
                return '<i class="fas fa-rupee">&nbsp;</i>'.$row->grand_total;
            })
            ->addColumn('invoice_file', function($row){ 
                $payment = DB::table('payments')->where('order_id', $row->id)->whereNotNull('invoice_file')->first();
                if(!empty($payment)){
                $filePath = 'https://bookfatafat.com/Invoice/'.$payment->invoice_file;
                return '<a class="btn btn-warning btn-sm text-white" target="_blank" href="'.$filePath.'" style="padding: 0.1rem 0.25rem;"><i class="fas fa-file"></i></a>';
                } else {
                    return '-';
                }
            })
            ->rawColumns(['action', 'payment_status', 'grand_total', 'invoice_file'])
            ->addIndexColumn()
            ->make(true);
        }
        return view('admin.placed-order.delivered-order');
    }

    public function rejectedOrder()
    {
        $orders = DB::table('orders')
        ->whereNotNull('rejected_at')
        ->get();
        // dd($orders);
        if(request()->ajax()) {
            return datatables()->of($orders)
            ->addColumn('payment_status', function($row){    
                if($row->payment_status == "Completed")
                {
                    return '<span class="badge badge-success">Completed</span>';
                }  
                else{
                    return '<span class="badge badge-danger">Pending</span>';
                }                                                                                                                                                                                                                                                                                      
            })
            ->addColumn('action', function($row){
                $route = route('admin.view-placed-order', $row->id);
                return '<a href="'.$route.'" class="btn btn-primary btn-sm" style="padding: 0.1rem 0.25rem;">
                <i class="fas fa-eye"></i>
                </a>';
            })
            ->addColumn('user_name', function($row){
                return $row->name;
            })
            ->addColumn('grand_total', function($row){ 
                return '<i class="fas fa-rupee">&nbsp;</i>'.$row->grand_total;
            })
            ->addColumn('invoice_file', function($row){ 
                $payment = DB::table('payments')->where('order_id', $row->id)->whereNotNull('invoice_file')->first();
                if(!empty($payment)){
                $filePath = 'https://bookfatafat.com/Invoice/'.$payment->invoice_file;
                return '<a class="btn btn-warning btn-sm text-white" target="_blank" href="'.$filePath.'" style="padding: 0.1rem 0.25rem;"><i class="fas fa-file"></i></a>';
                } else {
                    return '-';
                }
            })
            ->rawColumns(['action', 'payment_status', 'grand_total', 'invoice_file'])
            ->addIndexColumn()
            ->make(true);
        }
        return view('admin.placed-order.rejected-order');
    }

    public function show($id)
    {
        $order = Order::findorfail($id);
        return view('admin.placed-order.show', compact('order'));
    }
}
