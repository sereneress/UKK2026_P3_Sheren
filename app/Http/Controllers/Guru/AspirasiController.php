<?php

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use App\Models\Aspirasi;
use App\Models\Kategori;
use App\Models\Ruangan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class AspirasiController extends Controller
{
    private function getGuru()
    {
        return Auth::user()->guru;
    }

    public function dashboard()
    {
        $guru = $this->getGuru();

        $statistik = [
            'total' => Aspirasi::count(),
            'menunggu' => Aspirasi::where('status', 'Menunggu')->count(),
            'proses' => Aspirasi::where('status', 'Proses')->count(),
            'selesai' => Aspirasi::where('status', 'Selesai')->count(),
        ];

        if ($guru->canCreateAspirasi()) {
            $aspirasiTerbaru = Aspirasi::with(['kategori', 'ruangan'])
                ->where('user_id', Auth::id())
                ->latest()
                ->take(5)
                ->get();
        } else {
            $aspirasiTerbaru = Aspirasi::with(['user', 'kategori', 'ruangan'])
                ->latest()
                ->take(5)
                ->get();
        }

        return view('guru.dashboard', compact('guru', 'statistik', 'aspirasiTerbaru'));
    }

    public function create()
    {
        $kategoris = Kategori::all();
        $ruangans = Ruangan::orderBy('nama_ruangan')->get();

        return view('guru.aspirasi.create', compact('kategoris', 'ruangans'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_kategori' => 'required|exists:kategori,id_kategori',
            'id_ruangan' => 'required|exists:ruangan,id_ruangan',
            'keterangan' => 'required|string',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg|max:2048'
        ]);

        $ruangan = Ruangan::find($request->id_ruangan);
        $lokasi = $ruangan->nama_ruangan . ' (' . $ruangan->kode_ruangan . ')';

        $fotoPath = null;
        if ($request->hasFile('foto')) {
            $fotoPath = $request->file('foto')->store('aspirasi_foto', 'public');
        }

        Aspirasi::create([
            'user_id' => Auth::id(),
            'id_kategori' => $request->id_kategori,
            'id_ruangan' => $request->id_ruangan,
            'lokasi' => $lokasi,
            'keterangan' => $request->keterangan,
            'foto' => $fotoPath,
            'status' => 'Menunggu'
        ]);

        return redirect()->route('siswa.aspirasi.index')
            ->with('success', 'Aspirasi berhasil dikirim');
    }

    public function index(Request $request)
    {
        $guru = $this->getGuru();

        if ($guru->canCreateAspirasi()) {
            $query = Aspirasi::with(['kategori', 'ruangan'])
                ->where('user_id', Auth::id())
                ->where('status', '!=', 'Selesai');
        } else {
            $query = Aspirasi::with(['user', 'kategori', 'ruangan'])
                ->where('status', '!=', 'Selesai');
        }

        // FILTER
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('kategori')) {
            $query->where('id_kategori', $request->kategori);
        }

        if ($request->filled('ruangan')) {
            $query->where('id_ruangan', $request->ruangan);
        }

        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('keterangan', 'like', '%' . $request->search . '%')
                    ->orWhere('lokasi', 'like', '%' . $request->search . '%');
            });
        }

        $aspirasi = $query->latest()->paginate(10);

        $kategoris = Kategori::all();
        $ruangans  = Ruangan::all();

        return view('guru.aspirasi.index', compact('guru', 'aspirasi', 'kategoris', 'ruangans'));
    }

    public function detail($id)
    {
        $aspirasi = Aspirasi::with(['kategori', 'ruangan'])
            ->findOrFail($id);

        return view('guru.aspirasi.detail', compact('aspirasi'));
    }

    public function destroy($id)
    {
        $aspirasi = Aspirasi::findOrFail($id);

        if ($aspirasi->foto) {
            Storage::disk('public')->delete($aspirasi->foto);
        }

        $aspirasi->delete();

        return redirect()->back()->with('success', 'Aspirasi berhasil dihapus');
    }

    public function history()
    {
        $histories = Aspirasi::with(['kategori', 'user', 'ruangan', 'historyStatus'])
            ->whereIn('status', ['selesai', 'ditolak']) // filter riwayat
            ->latest()
            ->paginate(10);

        return view('guru.aspirasi.history', compact('histories'));
    }
}
