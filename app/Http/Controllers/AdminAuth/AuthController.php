<?php

namespace App\Http\Controllers\AdminAuth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
class AuthController extends Controller
{

    // public function showRegisterForm(){
    // 	return view('admin.register');
    // }
    public function showLoginForm(){
    	return view('admin.login');
    }
    public function logout(){
        Auth::guard('admin')->logout();
        return redirect()->back();
    }
    public function authenticate(Request $request){
    	 $credentials = $request->only('email', 'password');
    	 if (Auth::guard('admin')->attempt($credentials)) {
    	 	return redirect()->route('admin.dashboard');
           }else{
            return redirect()->back();
           }
    }
    public function register(){

    }
}
