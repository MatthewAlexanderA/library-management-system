<?php

namespace App\Http\Controllers;

use App\Models\Masyarakat;
use App\Models\Petugas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SettingController extends Controller
{
    public function index()
    {
        if (Auth::guard('petugas')->check()) {
            $user = Petugas::find(Auth::guard('petugas')->user()->id_petugas);
        } elseif (Auth::guard('masyarakat')->check()) {
            $user = Masyarakat::find(Auth::guard('masyarakat')->user()->nik);
        }

        return view('admin.setting.index', compact('user'));
    }

    
    public function update(Request $request, $id)
    {
        if (Auth::guard('petugas')->check()) {
            $request->validate([
                'nama_petugas' => 'required',
                'username' => 'required',
                'telp' => 'required',
                'password',
            ]);

            if ($request['username'] == $request['oldUsername']) {
                $request['username'] = $request['oldUsername'];
            }
            else{
                $check = Masyarakat::where('username', $request['username'])->count();
                if ($check) {
                    return back()->with('loginError', 'Username already taken!');
                    
                }
            }

            $user = Petugas::find($id);

        } elseif (Auth::guard('masyarakat')->check()) {
            $request->validate([
                'nik' => 'required',
                'nama' => 'required',
                'username' => 'required',
                'telp' => 'required',
                'password',
            ]);

            if ($request['username'] == $request['oldUsername']) {
                $request['username'] = $request['oldUsername'];
            }
            else{
                $check = Masyarakat::where('username', $request['username'])->count();
                if ($check) {
                    return back()->with('loginError', 'Username already taken!');
                    
                }
            }

            if ($request['nik'] == $request['oldNik']) {
                $request['nik'] = $request['oldNik'];
            }
            else{
                $check = Masyarakat::where('nik', $request['nik'])->count();
                if ($check) {
                    return back()->with('loginError', 'NIK already exist!');
                }
            }

            $user = Masyarakat::find($id);

        }

        if ($request['password'] == "") {
            $request['password'] = $request['oldPass'];
        }
        else{
            $request['password'] = bcrypt($request['password']);
        }

        $user->update($request->all());

        return redirect()->route('setting.index')
            ->with('success', 'Update Success!');
    }
}
