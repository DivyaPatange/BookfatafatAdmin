<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Auth;

class VendorStatus
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if (auth()->guard('vendor')->user()->status == "Inactive") {
            Auth::logout();
            return redirect('/vendors/login')->with('danger', 'Your Account is Deactivated');
        }
        return $next($request);
    }
}
