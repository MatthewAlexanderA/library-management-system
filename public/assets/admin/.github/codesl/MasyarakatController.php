<?php

namespace App\Http\Controllers;

use App\Models\Masyarakat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MasyarakatController extends Controller
{
    public function index()
    {
        return view('login.register');
    }

    public function create()
    {
        return view('masyarakat.create');
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

        $validatedData['password'] = bcrypt($validatedData['password']);

        Masyarakat::create($validatedData);

        return redirect('/login')
            ->with('success', 'Registration Success!');
    }

    public function show($id)
    {
        $masyarakat = Masyarakat::find($id);

        return view('masyarakat.show', compact('masyarakat'));
    }

    public function edit(Masyarakat $masyarakat)
    {
        $masyarakat = Masyarakat::find(Auth::user()->id);

        return view('masyarakat.edit', compact('masyarakat'));
    }

    public function update(Request $request, $id)
    {
        {
            $request->validate([
                'nik' => 'required',
                'nama' => 'required',
                'username' => 'required',
                'telp' => 'required',
                'password',
            ]);
    
            if ($request['password'] == "") {
                $request['password'] = $request['oldPass'];
            }
            else{
                $request['password'] = bcrypt($request['password']);
            }
    
            $user = Masyarakat::find($id);
    
            $user->update($request->all());
    
            return back()
                ->with('success', 'Update Success!');
        }
    }

    public function destroy($id)
    {
        $masyarakat = Masyarakat::where('id', $id)->first();

        $masyarakat->delete($masyarakat->id);

        return redirect()->route('masyarakat.index')
            ->with('success', 'Delete Success!');
    }
}
