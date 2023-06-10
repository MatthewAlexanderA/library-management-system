<?php

namespace App\Http\Controllers;

use App\Models\User;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SettingController extends Controller
{
    public function index()
    {
        $user = User::find(Auth::user()->id);

        return view('setting.index', compact('user'));
    }

    
    public function update(Request $request, $id)
    {
        $request->validate([
            'username' => 'required',
            'password',
        ]);

        $check = User::where('username', $request['username'])->count();
        if ($check) {
            return back()->with('error', 'Username already taken!');
        }

        if ($request['password'] == "") {
            $request['password'] = $request['oldPass'];
        }
        else{
            $request['password'] = bcrypt($request['password']);
        }

        $user = User::find($id);

        $user->update($request->all());

        return redirect()->route('setting.index')
            ->with('success', 'Update Success!');
    }
}
