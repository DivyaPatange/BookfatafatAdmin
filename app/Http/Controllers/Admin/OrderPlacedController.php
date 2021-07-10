<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\User;

class OrderPlacedController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }
    
    public function index()
    {
        $orders = Order::orderBy('id', 'DESC')->get();
        if(request()->ajax()) {
            return datatables()->of($orders)
            ->addColumn('payment_status', function($row){    
                if($row->status == "completed")
                {
                    return '<span class="badge badge-success">Completed</span>';
                }  
                else{
                    return '<span class="badge badge-danger">Pending</span>';
                }                                                                                                                                                                                                                                                                                      
            })
            ->addColumn('action', function($row){
                $route = route('admin.view-placed-order', $row->id);
                return '<a href="'.$route.'" class="btn btn-primary btn-sm">
                <i class="fas fa-eye"></i>
                </a>';
            })
            ->addColumn('user_name', function($row){
                $user = User::where('id', $row->user_id)->first();
                return $user->name;
            })
            ->addColumn('grand_total', function($row){ 
                return '<i class="fas fa-rupee">&nbsp;</i>'.$row->grand_total;
            })
            ->rawColumns(['action', 'payment_status', 'grand_total'])
            ->addIndexColumn()
            ->make(true);
        }
        return view('admin.placed-order.index');
    }

    public function show($id)
    {
        $order = Order::findorfail($id);
        return view('admin.placed-order.show', compact('order'));
    }
}
