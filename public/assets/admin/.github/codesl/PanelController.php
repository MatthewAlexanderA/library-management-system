<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PanelController extends Controller
{
    public function index()
    {
        return view('login.index');
    }

    public function auth(Request $request)
    {
        $credentials = $request->validate([
            'username' => 'required',
            'password' => 'required',
        ]);

        if (Auth::guard('masyarakat')->attempt($credentials)) {

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
