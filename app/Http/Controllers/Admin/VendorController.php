<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin\Vendor;
use Illuminate\Support\Facades\Hash;

class VendorController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $vendors = Vendor::orderBy('id', 'DESC')->get();
        if(request()->ajax()) {
            return datatables()->of($vendors)
            ->addColumn('status', function($row){
                if($row->status == "Active")
                {
                    return '<span class="badge badge-success">'.$row->status.'</span>';
                }  
                else{
                    return '<span class="badge badge-danger">'.$row->status.'</span>';
                }                                                                                                                                                                                                                                                                                    
            })
            ->addColumn('action', 'admin.vendor.action')
            ->rawColumns(['action', 'status'])
            ->addIndexColumn()
            ->make(true);
        }
        return view('admin.vendor.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.vendor.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $vendor = new Vendor();
        $vendor->business_owner_name = $request->owner_name;
        $vendor->business_name = $request->busi_name;
        $vendor->business_type = $request->busi_type;
        $vendor->business_start_date = $request->busi_start_date;
        $vendor->location = $request->busi_location;
        $vendor->address = $request->busi_address;
        $vendor->gst_no = $request->gst_no;
        $image = $request->file('aadhar_img');
        // dd($request->file('photo'));
        if($image != '')
        {
            $image_name = rand() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('AadharImg'), $image_name);
            $vendor->aadhar_img =$image_name;
        }
        $image1 = $request->file('pan_img');
        // dd($request->file('photo'));
        if($image1 != '')
        {
            $image_name1 = rand() . '.' . $image1->getClientOriginalExtension();
            $image1->move(public_path('PanImg'), $image_name1);
            $vendor->pan_img =$image_name1;
        }
        $image2 = $request->file('shop_img');
        // dd($request->file('photo'));
        if($image2 != '')
        {
            $image_name2 = rand() . '.' . $image2->getClientOriginalExtension();
            $image2->move(public_path('ShopImg'), $image_name2);
            $vendor->shop_img =$image_name2;
        }
        $vendor->password = Hash::make($request->password);
        $vendor->show_pwd = $request->password;
        $id = mt_rand(10000,99999);
        $vendor->username = "BFT".$id;
        $vendor->mobile_no = $request->mobile_no;
        $vendor->save();

        $message = "Hello+".urlencode($request->owner_name)."%0aWelcome+to+Bookfatafat+"."%0aYour+Vendor+Login+credentials+are+as+follows:%0aUsername:-+".$vendor->username."%0aPassword:-+".$request->password."%0aYou+can+login+to+your+vendor+account+here%0ahttps://admin.bookfatafat.com/vendors/login"."%0aThanks+Bookfatafat+Team";
        // dd($message);
                    
        $number = $request->mobile_no;
    
        $this->sendSms($message,$number); 
        // dd($this->sendSms($message,$number));   
        return redirect('/admin/vendorUser')->with('success', 'Vendor Added Successfully!');
    }

    public function sendSms($message,$number)
    {
        $url = 'http://sms.bulksmsind.in/sendSMS?username=bookfatafat&message='.$message.'&sendername=BOOKFT&smstype=TRANS&numbers='.$number.'&apikey=22139f55-b446-462b-b035-bf7f4e3e4d33&peid=1201162071979493351&templateid=1207162869874494100';

        $ch = curl_init();  
        
       
        curl_setopt($ch,CURLOPT_URL,$url);
        curl_setopt($ch, CURLOPT_POST, true);
    	// curl_setopt($ch, CURLOPT_POSTFIELDS, $url);
    	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    	
    	curl_setopt($ch,CURLOPT_HEADER, false);
     
        $output=curl_exec($ch);
     
        curl_close($ch);
       
        return $output;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $vendor = Vendor::findorfail($id);
        return view('admin.vendor.show', compact('vendor'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $vendor = Vendor::findorfail($id);
        return view('admin.vendor.edit', compact('vendor'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $vendor = Vendor::findorfail($id);
        $image_name = $request->hidden_image;
        $image = $request->file('aadhar_img');
        if($image != '')
        {
            if(!empty($vendor->aadhar_img)){
                unlink(public_path('AadharImg/'.$vendor->aadhar_img));
            }
            $image_name = rand() . '.' . $image->getClientOriginalExtension();
            // $image->storeAs('public/tempcourseimg',$image_name);
            $image->move(public_path('AadharImg'), $image_name);
        }
        $image_name1 = $request->hidden_image1;
        $image1 = $request->file('pan_img');
        if($image1 != '')
        {
            if(!empty($vendor->pan_img)){
                unlink(public_path('PanImg/'.$vendor->pan_img));
            }
            $image_name1 = rand() . '.' . $image1->getClientOriginalExtension();
            // $image->storeAs('public/tempcourseimg',$image_name);
            $image1->move(public_path('PanImg'), $image_name1);
        }
        $image_name2 = $request->hidden_image2;
        $image2 = $request->file('shop_img');
        if($image2 != '')
        {
            if(!empty($vendor->shop_img)){
                unlink(public_path('ShopImg/'.$vendor->shop_img));
            }
            $image_name2 = rand() . '.' . $image2->getClientOriginalExtension();
            // $image->storeAs('public/tempcourseimg',$image_name);
            $image2->move(public_path('ShopImg'), $image_name2);
        }
        $input_data = array (
            'business_owner_name' => $request->owner_name,
            'business_name' => $request->busi_name,
            'business_type' => $request->busi_type,
            'business_start_date' => $request->busi_start_date,
            'location' => $request->busi_location,
            'address' => $request->busi_address,
            'gst_no' => $request->gst_no,
            'aadhar_img' => $image_name,
            'pan_img' => $image_name1,
            'shop_img' => $image_name2,
            'status' => $request->status,
            'mobile_no' => $request->mobile_no,
        );
        $vendor = Vendor::whereId($id)->update($input_data);
        return redirect('/admin/vendorUser')->with('success', 'Vendor Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $vendor = Vendor::findorfail($id);
        if($vendor->aadhar_img){
            unlink(public_path('AadharImg/'.$vendor->aadhar_img));
        }
        if($vendor->pan_img){
            unlink(public_path('PanImg/'.$vendor->pan_img));
        }
        if($vendor->shop_img){
            unlink(public_path('ShopImg/'.$vendor->shop_img));
        }
        $vendor->delete();
        return response()->json(['success' => 'Vendor Deleted Successfully']);
    }
}
