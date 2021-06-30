<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use App\Models\Admin\Vendor;

class ProfileController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:vendor');
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $vendor = Vendor::where('id', Auth::guard('vendor')->user()->id)->first();
        return view('vendor.profile', compact('vendor'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
        return view('vendor.editProfile', compact('vendor'));
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
        );
        $vendor = Vendor::whereId($id)->update($input_data);
        return redirect('/vendors/profile')->with('success', 'Profile Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
