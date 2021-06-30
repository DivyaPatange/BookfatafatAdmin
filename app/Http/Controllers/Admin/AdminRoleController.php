<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin;
use Illuminate\Support\Facades\Hash;

class AdminRoleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = Admin::where('acc_type', 'user')->orderBy('id', 'DESC')->get();
        if(request()->ajax()) {
            return datatables()->of($users)
            ->addColumn('action', 'admin.users.action')
            ->rawColumns(['action'])
            ->addIndexColumn()
            ->make(true);
        }
        return view('admin.users.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.users.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $admin = new Admin();
        $admin->name = $request->name;
        $admin->email = $request->email;
        $admin->password = Hash::make($request->password);
        $admin->role_access = implode(",", $request->role_access);
        $admin->acc_type = "user";
        $admin->save();
        return redirect('/admin/users')->with('success', 'User Created Successfully!');
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
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $admin = Admin::findorfail($id);
        $admin->delete();
        return response()->json(['success' => 'User Deleted Successfully!']);
    }

    public function getUser(Request $request)
    {
        $admin = Admin::where('id', $request->bid)->first();
        if (!empty($admin)) 
        {
            $explodeRole = explode(",", $admin->role_access);
            $output = '';
            $output .='<div class="form-check-inline">
            <label class="form-check-label">
                <input type="checkbox" name="role_access[]" class="form-check-input" value="User"';
                if(in_array("User", $explodeRole)){
                    $output .='checked';
                }
                $output .='>User
            </label>
        </div>
        <div class="form-check-inline">
            <label class="form-check-label">
                <input type="checkbox" name="role_access[]" class="form-check-input" value="Vendor"';
                if(in_array("Vendor", $explodeRole)){
                    $output .='checked';
                }
                $output .='>Vendor
            </label>
        </div>
        <div class="form-check-inline">
            <label class="form-check-label">
                <input type="checkbox" name="role_access[]" class="form-check-input" value="Category"';
                if(in_array("Category", $explodeRole)){
                    $output .='checked';
                }
                $output .='>Category
            </label>
        </div>
        <div class="form-check-inline">
            <label class="form-check-label">
                <input type="checkbox" name="role_access[]" class="form-check-input" value="Sub-Category"';
                if(in_array("Sub-Category", $explodeRole)){
                    $output .='checked';
                }
                $output .='>Sub-Category
            </label>
        </div>
        <div class="form-check-inline">
            <label class="form-check-label">
                <input type="checkbox" name="role_access[]" class="form-check-input" value="Product"';
                if(in_array("Product", $explodeRole)){
                    $output .='checked';
                }
                $output .='>Product
            </label>
        </div>
        <div class="form-check-inline">
            <label class="form-check-label">
                <input type="checkbox" name="role_access[]" class="form-check-input" value="Services"';
                if(in_array("Services", $explodeRole)){
                    $output .='checked';
                }
                $output .='>Services
            </label>
        </div>';
            $data = array('id' =>$admin->id, 'name' =>$admin->name,'email' =>$admin->email, 'role_access' => $output
            );
        }else{
            $data =0;
        }
        echo json_encode($data);
    }

    public function updateUser(Request $request)
    {
        $admin = Admin::where('id', $request->id)->first();
        $input_data = array (
            'name' => $request->name,
            'email' => $request->email,
            'role_access' => implode(",", $request->role_access),
        );

        Admin::whereId($admin->id)->update($input_data);
        return response()->json(['success' => 'User Updated Successfully']);
    }
}
