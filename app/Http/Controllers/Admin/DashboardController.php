<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Siswa;
use App\Models\Guru;
use App\Models\Petugas;
use App\Models\Aspirasi;
use App\Models\Kategori;
use App\Models\Kelas;
use App\Models\Jurusan;
use App\Models\Progres;
use App\Models\HistoryStatus;
use App\Models\Ruangan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class DashboardController extends Controller
{
    // ================= DASHBOARD =================
    public function index()
    {
        return view('admin.dashboard', [
            'totalSiswa' => Siswa::count(),
            'totalGuru' => Guru::count(),
            'totalAspirasi' => Aspirasi::count(),
            'totalAdmin' => User::where('role', 'admin')->count(),
            'aspirasiMenunggu' => Aspirasi::where('status', 'Menunggu')->count(),
            'aspirasiProses' => Aspirasi::where('status', 'Proses')->count(),
            'aspirasiSelesai' => Aspirasi::where('status', 'Selesai')->count(),
        ]);
    }

    // ================= USERS VIEW =================
    public function users()
    {
        return view('admin.users.index', [
            'admins' => User::where('role', 'admin')->get(),
            'gurus' => User::where('role', 'guru')->with('guru')->get(),
            'siswas' => User::where('role', 'siswa')->with('siswa')->get(),
            'petugas' => User::where('role', 'petugas')->with('petugas')->get(),
        ]);
    }

    // ================= SISWA =================
    public function siswa()
    {
        $siswas = User::where('role', 'siswa')->with('siswa')->get();
        return view('admin.users.siswa', compact('siswas'));
    }

    public function storeSiswa(Request $request) { /* tetap punyamu */ }
    public function updateSiswa(Request $request, $id) { /* tetap punyamu */ }
    public function destroySiswa($id) { /* tetap punyamu */ }

    // ================= GURU (FIX ERROR KAMU ADA DI SINI) =================
    public function guru()
    {
        $gurus = User::where('role', 'guru')->with('guru')->get();
        return view('admin.users.guru', compact('gurus'));
    }

    public function storeGuru(Request $request) { /* tetap punyamu */ }
    public function updateGuru(Request $request, $id) { /* tetap punyamu */ }
    public function destroyGuru($id) { /* tetap punyamu */ }

    // ================= PETUGAS =================
    public function petugas()
    {
        $petugas = User::where('role', 'petugas')
            ->with('petugas')
            ->whereHas('petugas')
            ->get();

        return view('admin.users.petugas', compact('petugas'));
    }

    public function storePetugas(Request $request) { /* tetap punyamu */ }
    public function updatePetugas(Request $request, $id) { /* tetap punyamu */ }
    public function destroyPetugas($id) { /* tetap punyamu */ }

    // ================= KELAS =================
    public function kelas()
    {
        $kelas = Kelas::with('jurusan')->withCount('siswa')->get();
        $jurusan = Jurusan::all();

        return view('admin.kelas.index', compact('kelas', 'jurusan'));
    }

    public function storeKelas(Request $request) { /* tetap punyamu */ }
    public function updateKelas(Request $request, $id) { /* tetap punyamu */ }
    public function destroyKelas($id) { /* tetap punyamu */ }

    // ================= JURUSAN =================
    public function jurusan()
    {
        $jurusan = Jurusan::withCount('kelas')->get();
        return view('admin.jurusan.index', compact('jurusan'));
    }

    public function storeJurusan(Request $request) { /* tetap punyamu */ }
    public function updateJurusan(Request $request, $id) { /* tetap punyamu */ }
    public function destroyJurusan($id) { /* tetap punyamu */ }

    // ================= RUANGAN =================
    public function ruangan()
    {
        return view('admin.ruangan.index', [
            'ruangans' => Ruangan::latest()->get()
        ]);
    }

    public function storeRuangan(Request $request) { /* tetap punyamu */ }
    public function updateRuangan(Request $request, $id) { /* tetap punyamu */ }
    public function destroyRuangan($id) { /* tetap punyamu */ }

    // ================= KATEGORI =================
    public function kategori()
    {
        return view('admin.kategori.index', [
            'kategoris' => Kategori::all()
        ]);
    }

    public function storeKategori(Request $request) { /* tetap punyamu */ }
    public function updateKategori(Request $request, $id) { /* tetap punyamu */ }
    public function destroyKategori($id) { /* tetap punyamu */ }

    // ================= PENGADUAN =================
    public function pengaduan()
    {
        return view('admin.pengaduan.index', [
            'aspirasi' => Aspirasi::latest()->paginate(10),
            'kategoris' => Kategori::all()
        ]);
    }

    public function updateStatus(Request $request, $id) { /* tetap punyamu */ }
    public function destroyAspirasi($id) { /* tetap punyamu */ }
}