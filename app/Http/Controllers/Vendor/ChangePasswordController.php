<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use Illuminate\Support\Facades\Hash;

class ChangePasswordController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:vendor');
    }
    
    public function index()
    {
        return view('vendor.change-password');
    }

    public function store(Request $request)
    {
        $user = Auth::guard('vendor')->user();
    
        $userPassword = $user->password;
        
        $request->validate([
            'current_password' => 'required',
            'password' => 'required|same:confirm_password|min:6',
            'confirm_password' => 'required',
        ]);

        if (!Hash::check($request->current_password, $userPassword)) {
            return back()->withErrors(['current_password'=>'Password not match']);
        }

        $user->password = Hash::make($request->password);
        $user->show_pwd = $request->password;

        $user->save();

        return redirect()->back()->with('success','Password Successfully Updated');

    }
}
