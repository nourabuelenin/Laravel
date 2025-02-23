<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Auth;


class AdminAuthController extends Controller
{
    public function ShowAdminLoginForm()
    {
        return view('auth.admin-login');
    }

    public function login(Request $request){
        //validate user inputs using request
        $request -> validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);
    
        //check if user exists
        $user = User::where('email', $request->email)->first();
    
        if (Auth::guard('admin')->attempt($credentials)){
            return redirect()->route('admin.dashboard')->with('success', 'Welcome back');
        }   
        return back()->withErrors(['admin-login-error'=>'invalid email or psssword']);
    }

    public function logout(){
        Auth::logout();
        return redirect()->route('auth.login.form');
    }
}
