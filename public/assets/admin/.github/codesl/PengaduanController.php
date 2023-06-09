<?php

namespace App\Http\Controllers;

use App\Models\Pengaduan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class PengaduanController extends Controller
{
    public function index()
    {
        $pengaduan = Pengaduan::where('status', '0')->get();

        return view('admin.pengaduan.index', compact('pengaduan'));
    }

    public function store(Request $request)
    {
        {
            $validatedData = $request->validate([
                'foto' => 'image|file|required', 
                'isi_laporan' => 'required',
                'tgl_pengaduan' => 'required',
                'nik' => 'required',
                'status' => 'required',
            ]);
            
            $validatedData['foto'] = $request->file('foto')->store('post-images/pengaduan');
    
            Pengaduan::create($validatedData);
    
            return redirect()->route('dashboard.index')
                ->with('success', 'Add Success!');
        }
    }

    public function show($id_pengaduan)
    {
        $pengaduan = Pengaduan::where('id_pengaduan', $id_pengaduan)->first();

        return view('admin.pengaduan.show', compact('pengaduan'));
    }

    // public function edit($id)
    // {
    //     $pengaduan = Pengaduan::find($id);

    //     return view('admin.pengaduan.edit', compact('pengaduan'));
    // }

    public function verifikasi(Request $request, $id_pengaduan)
    {
        $request->validate([
            'status',
        ]);

        $request['status'] = 'proses';

        $pengaduan = Pengaduan::where('id_pengaduan', $id_pengaduan)->first();

        $pengaduan->where('id_pengaduan', $id_pengaduan)->update($request->all());

        return redirect()->route('verifikasi_pengaduan')
            ->with('success', 'Pengaduan di Verifikasi!');
    }

    public function tolak(Request $request, $id_pengaduan)
    {
        $request->validate([
            'status',
        ]);

        $request['status'] = 'ditolak';

        $pengaduan = Pengaduan::where('id_pengaduan', $id_pengaduan)->first();

        $pengaduan->where('id_pengaduan', $id_pengaduan)->update($request->all());

        return redirect()->route('verifikasi_pengaduan')
            ->with('success', 'Pengaduan di Tolak!');
    }

    // public function destroy($id)
    // {
    //     $pengaduan = Pengaduan::where('id', $id)->first();

    //     $pengaduan->delete($pengaduan->id);

    //     return redirect()->route('pengaduan.index')
    //         ->with('success', 'Delete Success!');
    // }
}
