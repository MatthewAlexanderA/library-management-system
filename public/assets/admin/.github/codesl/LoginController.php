<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function index()
    {
        if (Auth::guard('petugas')->check()) {
            return redirect(route('dashboard.index'));
        }

        return view('login.user');
    }

    public function authentication(Request $request)
    {
        $credentials = $request->validate([
            'username' => 'required',
            'password' => 'required',
        ]);

        if (Auth::guard('petugas')->attempt($credentials)) {

            $request->session()->regenerate();
            return redirect()->intended('/dashboard')->with('success', 'Login Success!');
        
        } 
        // if (Auth::attempt($credentials)) {

        //     $request->session()->regenerate();
        //     return redirect()->intended('/dashboard')->with('success', 'Login Success!');
        
        // }
        
        return back()->with('loginError', 'Login Failed!');
    }

    public function logout()
    {
        if (Auth::guard('petugas')->check()) {

            Auth::guard('petugas')->logout();

        } elseif (Auth::guard('masyarakat')->check()) {

            Auth::guard('masyarakat')->logout();

        } elseif (Auth::check()) {

            Auth::logout();
        }

        request()->session()->invalidate();

        request()->session()->regenerateToken();

        return redirect('/');
        
    }
}
