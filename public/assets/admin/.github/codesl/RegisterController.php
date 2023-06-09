<?php

namespace App\Http\Controllers;

use App\Models\Masyarakat;
use Illuminate\Http\Request;

class RegisterController extends Controller
{
    public function index()
    {
        return view('login.register');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'nik' => 'required', 
            'nama' => 'required', 
            'username' => 'required', 
            'password' => 'required',
            'telp' => 'required',
        ]);

        $check = Masyarakat::where('username', $validatedData['username'])->count();
        if ($check) {
            return back()->with('loginError', 'Username already taken!');
        }

        $check = Masyarakat::where('nik', $validatedData['nik'])->count();
        if ($check) {
            return back()->with('loginError', 'NIK already exist!');
        }

        $validatedData['password'] = bcrypt($validatedData['password']);

        Masyarakat::create($validatedData);

        return redirect('/login')
            ->with('success', 'Registration Success!');
    }
}
