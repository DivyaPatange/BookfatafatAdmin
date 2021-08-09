<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;
use DB;

class ListController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function todayRegisterUser()
    {
        $todayRegisterUser = DB::table('users')->where('created_at', '>=', Carbon::today())->get();
        if(request()->ajax()) {
            return datatables()->of($todayRegisterUser)
            ->addColumn('address', function($row){    
                $userInfo = DB::table('user_infos')->where('user_id', $row->id)->first();
                if(!empty($userInfo))     
                {
                    return $userInfo->address;
                }                                                                                                                                                                                                                                                                  
            })
            ->rawColumns(['address'])
            ->addIndexColumn()
            ->make(true);
        }
        return view('admin.todayRegisterUser');
    }

    public function todayOrderPlaced()
    {
        $todayOrderPlaced = DB::table('orders')->where('created_at', '>=', Carbon::today())->get();
        if(request()->ajax()) {
            return datatables()->of($todayOrderPlaced)
            ->addColumn('payment_status', function($row){    
                if($row->payment_status == "Completed")
                {
                    return '<span class="badge badge-success">Completed</span>';
                }  
                else{
                    return '<span class="badge badge-danger">Pending</span>';
                }                                                                                                                                                                                                                                                                                      
            })
            ->addColumn('address', function($row){    
                $userInfo = DB::table('user_infos')->where('user_id', $row->user_id)->first();
                if(!empty($userInfo))     
                {
                    return $userInfo->address;
                }                                                                                                                                                                                                                                                                  
            })
            ->addColumn('mobile_no', function($row){    
                $userInfo = DB::table('user_infos')->where('user_id', $row->user_id)->first();
                if(!empty($userInfo))     
                {
                    return $userInfo->mobile_no;
                }                                                                                                                                                                                                                                                                  
            })
            ->rawColumns(['address', 'payment_status'])
            ->addIndexColumn()
            ->make(true);
        }
        return view('admin.todayOrderPlaced');
    }

    public function todayPaymentCollection()
    {
        $todayPaymentCollection = DB::table('payments')->where('created_at', '>=', Carbon::today())->get();
        if(request()->ajax()) {
            return datatables()->of($todayPaymentCollection)
            ->addColumn('invoice_file', function($row){    
                $filePath = 'https://bookfatafat.com/Invoice/'.$row->invoice_file;
                return '<a class="btn btn-warning btn-sm text-white" target="_blank" href="'.$filePath.'"><i class="fas fa-file"></i></a>';                                                                                                                                                                                                                                                                                  
            })
            ->addColumn('mobile_no', function($row){    
                $order = DB::table('orders')->where('id', $row->order_id)->first();
                if(!empty($order))     
                {
                    $userInfo = DB::table('user_infos')->where('user_id', $order->user_id)->first();
                    if(!empty($userInfo))     
                    {
                        return $userInfo->mobile_no;
                    }
                }                                                                                                                                                                                                                                                                  
            })
            ->rawColumns(['address', 'invoice_file'])
            ->addIndexColumn()
            ->make(true);
        }
        return view('admin.todayPaymentCollection');
    }
}
