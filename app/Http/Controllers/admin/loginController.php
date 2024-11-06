<?php

namespace App\Http\Controllers\admin;
use Illuminate\Support\Facades\Validator;

use App\Http\Controllers\Controller;
use Auth;
use Illuminate\Http\Request;

class loginController extends Controller
{
    public function index()
    {
        return view('admin.login');
    }

    public function admin_authenticate(Request $request)
    {
        $validator = validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required'
        ]);
        if ($validator->passes()) {

            if (Auth::guard('admin')->attempt(['email' => $request->email, 'password' => $request->password])) {
                if (Auth::guard('admin')->user()->role != "admin") {
                    Auth::guard('admin')->logout();
                    return redirect()->route('admin.login')
                        ->with('error', 'you are not access the page');

                }
                return redirect()->intended(route('admin.dashboard'));

            } else {
                return redirect()->route('admin.login')
                    ->with('error', 'Enter email or password is incorrect');
            }


        } else {
            return redirect()->route('admin.login')
                ->withInput()
                ->withErrors($validator);
                
        }
    }

    public function logout(){
        Auth::guard('admin')->logout();
        return redirect()->route('admin.login');

    }
}
