<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class AuthController extends Controller
{
    public function ShowLoginForm()
    {
        return view('auth.login');
    }

    public function ShowRegisterForm()
    {
        return view('auth.register');
    }

    public function register(Request $request){
        //validate user inputs using request
        $request -> validate([
            // 'name' => ['required', 'string', 'min:5', 'max:200'],
            'name' => 'required|string|min:5|max:200',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:8|confirmed' 
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password)
        ]);
        return redirect()->route('auth.login.form');
    }

    public function login(Request $request){
        //validate user inputs using request
        $request -> validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);
    
        //check if user exists
        $user = User::where('email', $request->email)->first();
    
        if (Auth::attempt($credentials)){
            return redirect()->route('home')->with('success', 'Welcome back');
        }   
        return back()->withErrors(['login-error'=>'invalid email or psssword']);
    }

    public function logout(){
        Auth::logout();
        return redirect()->route('auth.login.form');
    }
}