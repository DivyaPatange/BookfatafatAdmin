<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Vendor\Service;
use App\Models\Admin\Vendor;
use Illuminate\Support\Facades\Hash;

class VendorRegisterController extends Controller
{
    public function __construct()
    {
        $this->middleware('guest:vendor')->except('logout');
    }

    public function showRegisterForm()
    {
        $services = Service::all();
        return view('vendor.register', compact('services'));
    }

    public function register(Request $request)
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
        $vendor->username = "ABC".$id;
        $vendor->mobile_no = $request->mobile_no;
        $vendor->save();
        $message = "Hello+".urlencode($request->owner_name)."%0aWelcome+to+Bookfatafat+"."%0aYour+Vendor+Login+credentials+are+as+follows:%0aUsername:-+".$vendor->username."%0aPassword:-+".$request->password."%0aYou+can+login+to+your+vendor+account+here%0ahttps://admin.bookfatafat.com/vendors/login"."%0aThanks+Bookfatafat+Team";
        // dd($message);
                    
        $number = $request->mobile_no;
    
        $this->sendSms($message,$number); 
        return redirect('/vendors/login')->with('success', 'Vendor Registered Successfully!');
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
}
