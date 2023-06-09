<?php

namespace App\Http\Controllers;

use App\Models\Pengaduan;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class LaporanController extends Controller
{
    public function index()
    {
        return view('admin.laporan.index');
    }

    public function generatePDF(Request $request)
    {
        $pengaduan = Pengaduan::where('tgl_pengaduan', '>=', $request->start)->where('tgl_pengaduan', '<=', $request->end)->latest()->get();

        $data = [
            'pengaduan' => $pengaduan,
            'start' => $request->start,
            'end' => $request->end
        ];

        $pdf = PDF::loadView('admin.laporan.pdf', $data);

        return $pdf->download(date('Ymd').'.pdf');
    }
}
