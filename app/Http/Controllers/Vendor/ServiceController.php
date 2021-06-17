<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin\Category;
use App\Models\Vendor\Service;
use Auth;
use App\Models\Admin\SubCategory;
use App\Models\Vendor\ServiceTimeSlot;
use App\Models\Vendor\AvailableDate;
use DateTime;

class ServiceController extends Controller
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
        $services = Service::where('vendor_id', Auth::guard('vendor')->user()->id)->get();
        if(request()->ajax()) {
            return datatables()->of($services)
            ->addColumn('service_img', function($row){    
                if(!empty($row->service_img)){
                    $imageUrl = asset('ServiceImg/' . $row->service_img);
                    return '<img src="'.$imageUrl.'" width="50px">';
                }                                                                                                                                                                                                                                                                                      
            })
            ->addColumn('category_id', function($row){    
                $category = Category::where('id', $row->category_id)->first();
                if(!empty($category))
                {
                    return $category->cat_name;
                }                                                                                                                                                                                                                                                                                      
            })
            ->addColumn('sub_category_id', function($row){    
                $subCategory = SubCategory::where('id', $row->sub_category_id)->first();
                if(!empty($subCategory))
                {
                    return $subCategory->sub_category;
                }                                                                                                                                                                                                                                                                                      
            })
            ->addColumn('description', function($row){   
                if($row->description != Null)
                {
                    return $row->description;
                }
                else{
                    return "";
                }
            })
            ->addColumn('action', 'vendor.service.action')
            ->rawColumns(['action', 'service_img', 'category_id', 'sub_category_id'])
            ->addIndexColumn()
            ->make(true);
        }
        return view('vendor.service.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::where('status', 'Active')->get();
        return view('vendor.service.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $service = new Service();
        $service->vendor_id = Auth::guard('vendor')->user()->id;
        $service->category_id = $request->category;
        $service->sub_category_id = $request->sub_category;
        $service->service_name = $request->service_name;
        $image = $request->file('service_img');
        // dd($request->file('photo'));
        if($image != '')
        {
            $image_name = rand() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('ServiceImg'), $image_name);
            $service->service_img =$image_name;
        }
        $service->service_cost = $request->service_price;
        $service->quantity = $request->quantity;
        $service->description = $request->description;
        $service->save();
        return redirect('/vendors/service')->with('success', 'Service Added Successfully!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $service = Service::findorfail($id);
        $availableDate = AvailableDate::where('vendor_id', Auth::guard('vendor')->user()->id)->where('service_id', $id)->get();
        if(request()->ajax()) {
            return datatables()->of($availableDate)
            ->addColumn('total_quantity', function($row){    
                if($row->total_quantity != Null)
                {
                    return $row->total_quantity;
                }                               
                else{
                    return "";
                }                                                                                                                                                                                                                         
            })
            ->addColumn('remain_quantity', function($row){    
                if($row->remain_quantity != Null)
                {
                    return $row->remain_quantity;
                }                               
                else{
                    return "";
                }                                                                                                                                                                                                                                                                                       
            })
            ->addColumn('time_slot', function($row){  
                return '<a href="javascript:void(0)" class="btn btn-primary btn-sm" onclick="ServiceModel(this, '.$row->id.')">
                    <i class="fas fa-eye"></i>
                </a>';
            })
            ->addColumn('status', function($row){    
                if($row->status == "Available")
                {
                    return '<span class="badge badge-success">'.$row->status.'</span>';
                } 
                elseif($row->status == "Booked"){
                    return '<span class="badge badge-danger">'.$row->status.'</span>';
                } 
                else{
                    return '<span class="badge badge-warning">'.$row->status.'</span>';
                }                                                                                                                                                                                                                                                                                       
            })
            ->addColumn('action', function($row){
                return '<a href="javascript:void(0)" class="btn btn-warning btn-sm" onclick="EditModel(this, '.$row->id.')">
                    <i class="fas fa-pencil-alt"></i>
                </a>
                <a href="javascript:void(0)" class="btn btn-danger btn-sm" id="delete" data-id="'.$row->id.'">
                            <i class="fas fa-trash"></i>
                        </a>';
            })
            ->rawColumns(['action', 'total_quantity', 'remain_quantity', 'status', 'time_slot'])
            ->addIndexColumn()
            ->make(true);
        }
        return view('vendor.service.show', compact('service', 'availableDate'));
    }

    public function getDate($id)
    {
        $availableDate = AvailableDate::where('vendor_id', Auth::guard('vendor')->user()->id)->where('service_id', $id)->pluck("available_date");
        return response()->json($availableDate);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $service = Service::findorfail($id);
        $categories = Category::where('status', 'Active')->get();
        $subCategory = SubCategory::where('category_id', $service->category_id)->where('status', 'Active')->get();
        return view('vendor.service.edit', compact('categories', 'service', 'subCategory'));
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
        $service = Service::findorfail($id);
        $image_name = $request->hidden_image;
        $image = $request->file('service_img');
        if($image != '')
        {
            unlink(public_path('ServiceImg/'.$service->service_img));
            $image_name = rand() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('ServiceImg'), $image_name);
        }

        $input_data = array (
            'sub_category_id' => $request->sub_category,
            'category_id' => $request->category,
            'service_name' => $request->service_name,
            'service_img' => $image_name,
            'service_cost' => $request->service_price,
            'quantity' => $request->quantity,
            'description' => $request->description,
        );
        Service::whereId($id)->update($input_data);
        return redirect('/vendors/service')->with('success', 'Service Updated Successfully!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $service = Service::findorfail($id);
        if($service->service_img){
            unlink(public_path('ServiceImg/'.$service->service_img));
        }
        $service->delete();
        return response()->json(['success' => 'Service Deleted Successfully!']);
    }

    public function storeAvailableDate(Request $request)
    {
        $availableDate = $request->date;
        $explodeDate = explode(",", $availableDate);
        $obj = json_decode($request->Data, true);
            
        for($i=0; $i < count($explodeDate); $i++)
        {
            $markDate = AvailableDate::create([
                'vendor_id' => Auth::guard('vendor')->user()->id,
                'service_id' => $request->service,
                'available_date' => date("Y-m-d", strtotime($explodeDate[$i])),
                'total_quantity' => $request->quantity,
                'remain_quanity' => $request->quantity,
                'status' => "Available",
            ]);
            for($j=0; $j < count($obj); $j++)
            {
                if(($obj[$j]["from"] != '') && ($obj[$j]["to"] != ''))
                {
                    $timeSlot = new ServiceTimeSlot();
                    $timeSlot->vendor_id = Auth::guard('vendor')->user()->id;
                    $timeSlot->service_id = $request->service;
                    $timeSlot->available_date_id = $markDate->id;
                    $timeSlot->from_time = date("H:i", strtotime($obj[$j]["from"]));
                    $timeSlot->to_time = date("H:i", strtotime($obj[$j]["to"]));
                    $timeSlot->save();
                }
            }
        }
        return response()->json(['success' => 'Dates Marked Successfully!']);
        // return count($explodeDate);
    }

    public function editServiceDate(Request $request)
    {
        $availableDate = AvailableDate::where('id', $request->bid)->first();
        if (!empty($availableDate)) 
        {
            $data = array('id' =>$availableDate->id,'service_date' =>$availableDate->available_date, 'status' => $availableDate->status
            );
        }else{
            $data =0;
        }
        echo json_encode($data);
    }

    public function deleteAvailableDate($id)
    {
        $availableDate = AvailableDate::findorfail($id);
        $availableDate->delete();
        return response()->json(['success' => 'Date Deleted Successfully!']);
    }

    public function updateDate(Request $request)
    {
        $availableDate = AvailableDate::where('id', $request->id)->first();
        $checkDate = AvailableDate::where('available_date', date('Y-m-d', strtotime($request->service_date)))->where('vendor_id', $availableDate->vendor_id)->where('service_id', $availableDate->service_id)->where('status', 'Available')->first();
        if(!empty($checkDate))
        {
            return response()->json(['error' => 'Date is already used.']);
        }
        else{
            $input_data = array (
                'available_date' => date('Y-m-d', strtotime($request->service_date)),
                'status' => $request->status,
            );
            AvailableDate::whereId($availableDate->id)->update($input_data);
            return response()->json(['success' => 'Date Updated Successfully']);
        }
    }

    public function getTimeSlot(Request $request)
    {
        $availableDate = AvailableDate::where('id', $request->bid)->first();
        $timeSlot = ServiceTimeSlot::where('available_date_id', $request->bid)->get();
        $service = '';
        foreach($timeSlot as $t)
        {
            $service .= '<tr>'.
            '<td><input type="time" name="start_time" class="form-control" value="'.$t->from_time.'"></td>'.
            '<td><input type="time" name="end_time" class="form-control" value="'.$t->to_time.'"></td>'.
            '<td><button type="button" id="editTime" data-id="'.$t->id.'" class="btn btn-warning btn-sm"><i class="fas fa-pencil-alt"></i></button>
                <button id="deleteTime" data-id="'.$t->id.'" class="btn btn-danger btn-sm"><i class="fas fa-trash"></i></button>
            </td>'.
            '</tr>';
        }
        $data = array('service' => $service, 'service_id' => $availableDate->service_id, 'vendor_id' => $availableDate->vendor_id, 'available_date_id' => $availableDate->id);
        echo json_encode($data);
    }

    public function addServiceTime(Request $request)
    {
        $timeSlot = new ServiceTimeSlot();
        $timeSlot->service_id = $request->service_id;
        $timeSlot->vendor_id = $request->vendor_id;
        $timeSlot->available_date_id = $request->available_date_id;
        $timeSlot->from_time = $request->start_time;
        $timeSlot->to_time = $request->end_time;
        $timeSlot->save();
        return response()->json(['success' => 'Time Slot Added Successfully!']);
    }

    public function updateServiceTime(Request $request)
    {
        $serviceTime = ServiceTimeSlot::where('id', $request->id)->first();
        $input_data = array(
            'from_time' => $request->start_time,
            'to_time' => $request->end_time,
        );
        ServiceTimeSlot::whereId($serviceTime->id)->update($input_data);
        return response()->json(['success' => 'Time Slot Updated Successfully!']);
    }

    public function deleteServiceTime($id)
    {
        $serviceTime = ServiceTimeSlot::findorfail($id);
        $delete = $serviceTime->delete();
        if($delete == 1)
        {
            return response()->json(['success' => 'Time Slot Deleted Successfully!']);
        }
        else{
            return response()->json(['error' => 'Error! Something Went Wrong.']);
        }
    }

}
