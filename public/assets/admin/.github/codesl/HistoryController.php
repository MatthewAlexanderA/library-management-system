<?php

namespace App\Http\Controllers;

use App\Models\Pengaduan;
use App\Models\Tanggapan;
use Illuminate\Http\Request;

class HistoryController extends Controller
{
    public function index()
    {
        $pengaduan = Pengaduan::where('status', 'selesai')->latest()->get();
        $ditolak = Pengaduan::where('status', 'ditolak')->latest()->get();

        return view('admin.history.index', compact('pengaduan', 'ditolak'));
    }

    public function show($id_pengaduan)
    {
        $pengaduan = Pengaduan::where('id_pengaduan', $id_pengaduan)->first();
        $tanggapan = Tanggapan::where('id_pengaduan', $id_pengaduan)->first();

        return view('admin.history.show', compact('pengaduan', 'tanggapan'));
    }
}
