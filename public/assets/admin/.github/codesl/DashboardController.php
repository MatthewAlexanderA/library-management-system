<?php

namespace App\Http\Controllers;

use App\Models\Pengaduan;
use Illuminate\Support\Facades\Auth;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        if (Auth::guard('petugas')->check()) {
            $pengaduan = Pengaduan::count();
            $selesai = Pengaduan::where('status', 'selesai')->count();
            $proses = Pengaduan::where('status', 'proses')->count();
            $verifikasi = Pengaduan::where('status', '0')->count();
            $ditolak = Pengaduan::where('status', 'ditolak')->count();
        } elseif (Auth::guard('masyarakat')->check()) {
            $pengaduan = Pengaduan::where('nik', Auth::guard('masyarakat')->user()->nik)->count();
            $selesai = Pengaduan::where('nik', Auth::guard('masyarakat')->user()->nik)->where('status', 'selesai')->count();
            $proses = Pengaduan::where('nik', Auth::guard('masyarakat')->user()->nik)->where('status', 'proses')->count();
            $verifikasi = Pengaduan::where('nik', Auth::guard('masyarakat')->user()->nik)->where('status', '0')->count();
            $ditolak = Pengaduan::where('nik', Auth::guard('masyarakat')->user()->nik)->where('status', 'ditolak')->count();
        }

        return view('admin.dashboard', compact('pengaduan', 'selesai', 'proses', 'verifikasi', 'ditolak'));
    }
}
