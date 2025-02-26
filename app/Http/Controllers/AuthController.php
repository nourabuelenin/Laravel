<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

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
            'phone' => ['required', 'string', 'regex:/^(010|011|012)\d{8}$/'],
            'address' => 'required|string|min:10|max:200',
            'password' => 'required|min:8|confirmed'
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'address' => $request->address,
            'password' => bcrypt($request->password)
        ]);
        return redirect()->route('auth.login.form')->with('success', 'Registration successful!');
    }

    public function login(Request $request){
        //validate user inputs using request
        $credentials = $request -> validate([
            'email' => 'required|email',
            'password' => 'required|min:8' 
        ]);
    
        //check if user exists
        $user = User::where('email', $request->email)->first();
    
        if (Auth::attempt($credentials)){
            return redirect()->route('home')->with('success', 'Logged in successfully.');
        }   
        return back()->withErrors(['login-error'=>'invalid email or psssword']);
    }

    public function logout(){
        Auth::logout();
        return redirect()->route('home')->with('success', 'Logged out successfully.');
    }
}