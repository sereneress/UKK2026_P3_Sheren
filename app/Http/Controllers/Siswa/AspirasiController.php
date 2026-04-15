<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use App\Models\Aspirasi;
use App\Models\Kategori;
use App\Models\Ruangan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class AspirasiController extends Controller
{
    private function getsiswa()
    {
        return Auth::user()->siswa;
    }

    // ================= DASHBOARD =================
    public function dashboard()
    {
        $siswa = $this->getsiswa();

        $statistik = [
            'total' => Aspirasi::count(),
            'menunggu' => Aspirasi::where('status', 'Menunggu')->count(),
            'proses' => Aspirasi::where('status', 'Proses')->count(),
            'selesai' => Aspirasi::where('status', 'Selesai')->count(),
        ];

        if ($siswa->canCreateAspirasi()) {
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

        return view('siswa.dashboard', compact('siswa', 'statistik', 'aspirasiTerbaru'));
    }

    // ================= FORM CREATE =================
    public function create()
    {
        $kategoris = Kategori::all();
        $ruangans = Ruangan::orderBy('nama_ruangan')->get();

        return view('siswa.aspirasi.create', compact('kategoris', 'ruangans'));
    }

    // ================= STORE =================
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

    // ================= LIST ASPIRASI =================
    public function index(Request $request)
    {
        $siswa = $this->getsiswa();

        if ($siswa->canCreateAspirasi()) {
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

        return view('siswa.aspirasi.index', compact('siswa', 'aspirasi', 'kategoris', 'ruangans'));
    }

    // ================= DETAIL =================
    public function detail($id)
    {
        $aspirasi = Aspirasi::with([
            'kategori',
            'ruangan',
            'progres.user',
            'historyStatus.user'
        ])->where('id_aspirasi', $id)->firstOrFail();

        return view('siswa.aspirasi.detail', compact('aspirasi'));
    }

    // ================= DELETE =================
    public function destroy($id)
    {
        $aspirasi = Aspirasi::findOrFail($id);

        if ($aspirasi->foto) {
            Storage::disk('public')->delete($aspirasi->foto);
        }

        $aspirasi->delete();

        return redirect()->back()->with('success', 'Aspirasi berhasil dihapus');
    }

    // ================= STATUS (BELUM SELESAI) =================
    public function status()
    {
        $aspirasi = Aspirasi::with('kategori')
            ->where('user_id', Auth::id())
            ->where('status', '!=', 'Selesai')
            ->latest()
            ->paginate(10);

        return view('siswa.aspirasi.status', compact('aspirasi'));
    }

    // ================= HISTORY (SELESAI / DITOLAK) =================
    public function history()
    {
        $aspirasi = Aspirasi::with(['kategori', 'user', 'ruangan', 'historyStatus'])
            ->where('user_id', Auth::id())
            ->whereIn('status', ['Selesai', 'Ditolak'])
            ->latest()
            ->paginate(10);

        return view('siswa.aspirasi.history', compact('aspirasi'));
    }

    // ================= FEEDBACK =================
    public function feedback()
    {
        $aspirasi = Aspirasi::with(['kategori', 'progres' => function ($q) {
            $q->where('keterangan_progres', 'like', 'Feedback:%');
        }])
            ->where('user_id', Auth::id())
            ->whereHas('progres', function ($q) {
                $q->where('keterangan_progres', 'like', 'Feedback:%');
            })
            ->latest()
            ->paginate(10);

        return view('siswa.aspirasi.feedback', compact('aspirasi'));
    }
}
