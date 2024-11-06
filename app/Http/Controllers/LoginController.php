<?php

namespace App\Http\Controllers;
use App\Models\User;
use Auth;
use Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    public function index()
    {
        return view('login');
    }
    public function authenticate(Request $request)
    {
        $validator = validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required'
        ]);
        if ($validator->passes()) {

            if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
                return redirect()->intended(route('Account.dashboard'));
            } else {
                return redirect()->route('Account.login')
                    ->with('error','Enter email or password is incorrect');
            }


        } else {
            return redirect()->route('Account.login')
                ->withInput()
                ->withErrors($validator);
        }
    }

    public function register()
    {
        return view('register');
    }

    public function processregister(Request $request)
    {
        $validator = validator::make($request->all(), [
            'email' => 'required|email|unique:users',
            'password' => 'required|confirmed'
        ]);
        if ($validator->passes()) {

            $user = new User();
            $user->name = $request->name;
            $user->email = $request->email;
            $user->Password = Hash::make($request->password);
            $user->role = 'customer';
            $user->save();
            return redirect()->route('Account.login')
                ->with('success','you have registed successfully');
        } else {
            return redirect()->route('Account.register')
                ->withInput()
                ->withErrors($validator);
        }

    }

    public function logout(){
        Auth::logout();
        return redirect()->route('Account.login');
    }

}
