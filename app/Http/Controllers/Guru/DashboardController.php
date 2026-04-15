<?php

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use App\Models\Aspirasi;

class DashboardController extends Controller
{
    public function index()
    {
        $guru = auth()->user()->guru;

        // STATISTIK (biar sesuai blade)
        $statistik = [
            'total' => Aspirasi::count(),
            'menunggu' => Aspirasi::where('status', 'Menunggu')->count(),
            'proses' => Aspirasi::where('status', 'Proses')->count(),
            'selesai' => Aspirasi::where('status', 'Selesai')->count(),
        ];

        // DATA TERBARU
        $aspirasiTerbaru = Aspirasi::latest()->take(5)->get();

        // CHART BULANAN
        $bulanLabels = [];
        $bulanData = [];

        for ($i = 1; $i <= 12; $i++) {
            $bulanLabels[] = date('M', mktime(0, 0, 0, $i, 1));
            $bulanData[] = Aspirasi::whereMonth('created_at', $i)->count();
        }

        return view('guru.dashboard', compact(
            'guru',
            'statistik',
            'aspirasiTerbaru',
            'bulanLabels',
            'bulanData'
        ));
    }
}