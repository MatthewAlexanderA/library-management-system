<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function index()
    {
        return view('login.index');
    }

    public function user()
    {
        return view('login.user');
    }

    public function auth(Request $request)
    {
        $credentials = $request->validate([
            'username' => 'required',
            'password' => 'required',
        ]);

        if (!empty(User::where('username', $request->username)->first())) {
            $user = User::where('username', $request->username)->first();        

            if ($user->role == 'member') {

                if (Auth::attempt($credentials)) {

                    $request->session()->regenerate();
                    return redirect()->intended('/dashboard')->with('success', 'Login Success!');
                
                }

            }

        }

        return back()->with('loginError', 'Login Failed!');
    }

    public function authentication(Request $request)
    {
        $credentials = $request->validate([
            'username' => 'required',
            'password' => 'required',
        ]);

        if (User::where('username', $request->username)->first()) {
            $user = User::where('username', $request->username)->first();

            if ($user->role == 'staff') {

                if (Auth::attempt($credentials)) {

                    $request->session()->regenerate();
                    return redirect()->intended('/dashboard')->with('success', 'Login Success!');
                
                }

            }
        
        }

        return back()->with('loginError', 'Login Failed!');
    }

    public function logout()
    {
        Auth::logout();

        request()->session()->invalidate();

        request()->session()->regenerateToken();

        return redirect('/');
    }
}
