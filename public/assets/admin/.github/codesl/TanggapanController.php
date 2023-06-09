<?php

namespace App\Http\Controllers;

use App\Models\Pengaduan;
use App\Models\Tanggapan;
use Illuminate\Http\Request;

class TanggapanController extends Controller
{
    public function index()
    {
        $pengaduan = Pengaduan::where('status', 'proses')->get();

        return view('admin.tanggapan.index', compact('pengaduan'));
    }

    public function create($id_pengaduan)
    {
        return view('admin.tanggapan.create', compact('id_pengaduan'));
    }

    public function store(Request $request)
    {
        {
            $validatedData = $request->validate([
                'id_pengaduan' => 'required', 
                'id_petugas' => 'required', 
                'tanggapan' => 'required',
                'tgl_tanggapan' => 'required',
            ]);
    
            Tanggapan::create($validatedData);

            $data['status'] = 'selesai';
    
            $pengaduan = Pengaduan::where('id_pengaduan', $validatedData['id_pengaduan'])->first();
    
            $pengaduan->where('id_pengaduan', $validatedData['id_pengaduan'])->update($data);
    
            return redirect()->route('proses_pengaduan')
                ->with('success', 'Selesai & Berhasil Memberi Tanggapan!');
        }
    }

    public function show($id_pengaduan)
    {
        $pengaduan = Pengaduan::where('id_pengaduan', $id_pengaduan)->first();

        return view('admin.tanggapan.show', compact('pengaduan'));
    }

}
