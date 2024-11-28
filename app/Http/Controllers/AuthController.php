<?php

namespace App\Http\Controllers;

use Auth;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Session;
class AuthController extends Controller
{
    public function index(){
        return view('auth.login');
    }
    // login functionality
    public function login(Request $request){
        // Validate the user
        $request->validate([
            'email'=> 'required|email',
            'password' => 'required'
        ]);
        if(Auth::attempt($request->only('email','password'))){
            return redirect('home');
        }
        return redirect('login')->withError('Error');
    }
    // Register functinality
    public function register(Request $request){
        // dd($request->all());
        // Validate the user
        $request->validate([
            'name' => 'required',
            'email' => 'required|unique:users|email',
            'password' => 'required|confirmed'
        ]);
        User::create([
            'name' => $request->name,
            'email' => $request-> email,
            'password' => \Hash::make($request->password)
        ]);
        // Login the user after successfully register
        if(Auth::attempt($request->only('email','password'))){
            return redirect('home');
        }
        return redirect('register')->withError('Error');
    }
    public function register_view(){
        return view('auth.register');
    }

    public function home(){
        return view('home');
    }
    // Logout functionality
    public function logout(){
        Session::flush();
        Auth::logout();
        return redirect('login');
    }
}
