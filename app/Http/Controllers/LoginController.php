<?php

namespace App\Http\Controllers;
use App\Mail\ResetPasswordEmail;
use to;
use Auth;
use Hash;
use App\Models\User;
use Illuminate\Support\str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

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
                    ->with('error', 'Enter email or password is incorrect');
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
                ->with('success', 'you have registed successfully');
        } else {
            return redirect()->route('Account.register')
                ->withInput()
                ->withErrors($validator);
        }

    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('Account.login');
    }



    public function forgotpassword()
    {
        return view('forgotpassword');
    }
    public function processForgotpassword(Request $request)
    {
        $Validator = Validator::make($request->all(), [
            'email' => 'required|email|exists:users,email',
        ]);
        if ($Validator->fails()) {
            return redirect()->route('forgotpassword')->withInput()->withErrors($Validator);
        }
        $token = str::random(60);
        \DB::table('password_reset_tokens')->where('email', $request->email)->delete();

        \DB::table('password_reset_tokens')->insert([
            'email' => $request->email,
            'token' => $token,
            'created_at' => now()
        ]);

        $user = User::where('email', $request->email)->first();
        $formData = [
            'token' => $token,
            'user' => $user,
            'mailsubject' => 'you have requsted to reset password',
        ];

        Mail::to($request->email)->send(new ResetPasswordEmail($formData));

        return redirect()->route('forgotpassword')->with('success', 'please chek your inbox to reset your password.');
    }

    public function reset_password($token)
    {
        $tokenexist = \DB::table('password_reset_tokens')->where('token', $token)->first();
        if ($tokenexist == null) {
            return redirect()->route('forgotpassword')->with('error', 'Invalid request');
        }
        return view('reset_form', [
            'token' => $token
        ]);
    }

    public function ProcessResetPassword(Request $request)
    {
        $token = $request->token;
        $tokenexist = \DB::table('password_reset_tokens')->where('token', $token)->first();
        if ($tokenexist == null) {
            return redirect()->route('forgotpassword')->with('error', 'Invalid request');
        }

        $user=User::where('email',$tokenexist->email)->first();
        $Validator = Validator::make($request->all(), [
            'password' => 'required|min:6',
            'confirm_password' => 'required|same:password',
        ]);
        if ($Validator->fails()) {
            return redirect()->route('reset_password',$token)->withErrors($Validator);
        }


        User::where('id',$user->id)->update([
            'password'=>Hash::make($request->password)

        ]);
        return redirect()->route('Account.login')->with('success', 'you have success fully updated your password.');
    
    }
}
