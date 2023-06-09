<?php

namespace App\Http\Controllers;

use App\Models\Petugas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PetugasController extends Controller
{
    public function index()
    {
        $petugas = Petugas::where('level', 'petugas')->latest()->get();

        return view('admin.petugas.index', compact('petugas'));
    }

    public function create()
    {
        return view('petugas.create');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'nama_petugas' => 'required', 
            'username' => 'required', 
            'password' => 'required',
            'telp' => 'required',
        ]);

        $check = Petugas::where('username', $validatedData['username'])->count();
        if ($check) {
            return back()->with('loginError', 'Username already taken!');
        }

        $validatedData['password'] = bcrypt($validatedData['password']);

        $validatedData['level'] = 'petugas';

        Petugas::create($validatedData);

        return redirect(route('petugas.index'))
            ->with('success', 'Registration Success!');
    }

    // public function show($id)
    // {
    //     $petugas = Petugas::find($id);

    //     return view('admin.petugas.show', compact('petugas'));
    // }

    public function edit($id)
    {
        $petugas = Petugas::find($id);

        return view('admin.petugas.edit', compact('petugas'));
    }

    public function update(Request $request, $id)
    {
        {
            $request->validate([
                'nama_petugas' => 'required',
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
    
            $petugas = Petugas::find($id);
    
            $petugas->update($request->all());
    
            return redirect(route('petugas.index'))
                ->with('success', 'Update Success!');
        }
    }

    public function destroy($id)
    {
        $petugas = Petugas::find($id);

        $petugas->delete();

        return redirect()->route('petugas.index')
            ->with('success', 'Delete Success!');
    }
}
