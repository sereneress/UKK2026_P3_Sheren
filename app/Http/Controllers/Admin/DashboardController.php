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

    public function storeSiswa(Request $request)
    {
        $request->validate([
            'nis'           => 'required|unique:siswa,nis',
            'nama'          => 'required',
            'kelas'         => 'required',
            'jurusan'       => 'required',
            'jenis_kelamin' => 'required',
            'tanggal_lahir' => 'required|date',
            'alamat'        => 'required',
            'no_hp'         => 'required',
            'email'         => 'required|email|unique:users,email',
            'password'      => 'required|min:6',
            'foto'          => 'nullable|image|max:2048',
        ]);

        $fotoPath = null;
        if ($request->hasFile('foto')) {
            $file     = $request->file('foto');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('assets/images/siswa'), $filename);
            $fotoPath = 'assets/images/siswa/' . $filename;
        }

        $user = User::create([
            'email'    => $request->email,
            'password' => Hash::make($request->password),
            'role'     => 'siswa',
        ]);

        Siswa::create([
            'user_id'       => $user->id,
            'nis'           => $request->nis,
            'nama'          => $request->nama,
            'kelas'         => $request->kelas,
            'jurusan'       => $request->jurusan,
            'jenis_kelamin' => $request->jenis_kelamin,
            'tanggal_lahir' => $request->tanggal_lahir,
            'alamat'        => $request->alamat,
            'no_hp'         => $request->no_hp,
            'foto'          => $fotoPath,
        ]);

        return back()->with('success', 'Siswa berhasil ditambahkan');
    }

    public function updateSiswa(Request $request, $id)
    {
        $siswa = Siswa::findOrFail($id);

        $request->validate([
            'nis'   => 'required|unique:siswa,nis,' . $id,
            'email' => 'required|email|unique:users,email,' . $siswa->user_id,
            'foto'  => 'nullable|image|max:2048',
        ]);

        $data = $request->except(['email', 'password', 'foto']);

        if ($request->hasFile('foto')) {
            // Hapus foto lama kalau ada
            if ($siswa->foto && file_exists(public_path($siswa->foto))) {
                unlink(public_path($siswa->foto));
            }
            $file     = $request->file('foto');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('assets/images/siswa'), $filename);
            $data['foto'] = 'assets/images/siswa/' . $filename;
        }

        $siswa->update($data);
        $siswa->user->update(['email' => $request->email]);

        if ($request->password) {
            $siswa->user->update(['password' => Hash::make($request->password)]);
        }

        return back()->with('success', 'Siswa berhasil diupdate');
    }

    public function destroySiswa($id)
    {
        $siswa = Siswa::findOrFail($id);

        if ($siswa->foto && file_exists(public_path($siswa->foto))) {
            unlink(public_path($siswa->foto));
        }

        $siswa->user->delete();
        $siswa->delete();

        return back()->with('success', 'Siswa berhasil dihapus');
    }

    // ================= GURU =================
    // Taruh di dalam class DashboardController

    public function guru()
    {
        $gurus = User::where('role', 'guru')->with('guru')->get();
        return view('admin.users.guru', compact('gurus'));
    }

    public function storeGuru(Request $request)
    {
        $request->validate([
            'nip'            => 'required|unique:guru,nip',
            'nama'           => 'required',
            'mata_pelajaran' => 'required',
            'jenis_kelamin'  => 'required',
            'tanggal_lahir'  => 'required|date',
            'alamat'         => 'required',
            'no_hp'          => 'required',
            'email'          => 'required|email|unique:users,email',
            'password'       => 'required|min:6',
            'foto'           => 'nullable|image|max:2048',
        ]);

        $fotoPath = null;
        if ($request->hasFile('foto')) {
            $file     = $request->file('foto');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('assets/images/guru'), $filename);
            $fotoPath = 'assets/images/guru/' . $filename;
        }

        $user = User::create([
            'email'    => $request->email,
            'password' => Hash::make($request->password),
            'role'     => 'guru',
        ]);

        Guru::create([
            'user_id'        => $user->id,
            'nip'            => $request->nip,
            'nama'           => $request->nama,
            'mata_pelajaran' => $request->mata_pelajaran,
            'jenis_kelamin'  => $request->jenis_kelamin,
            'tanggal_lahir'  => $request->tanggal_lahir,
            'alamat'         => $request->alamat,
            'no_hp'          => $request->no_hp,
            'foto'           => $fotoPath,
        ]);

        return back()->with('success', 'Guru berhasil ditambahkan');
    }

    public function updateGuru(Request $request, $id)
    {
        $guru = Guru::findOrFail($id);

        $request->validate([
            'nip'   => 'required|unique:guru,nip,' . $id,
            'email' => 'required|email|unique:users,email,' . $guru->user_id,
            'foto'  => 'nullable|image|max:2048',
        ]);

        $data = $request->except(['email', 'password', 'foto']);

        if ($request->hasFile('foto')) {
            if ($guru->foto && file_exists(public_path($guru->foto))) {
                unlink(public_path($guru->foto));
            }
            $file     = $request->file('foto');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('assets/images/guru'), $filename);
            $data['foto'] = 'assets/images/guru/' . $filename;
        }

        $guru->update($data);
        $guru->user->update(['email' => $request->email]);

        if ($request->password) {
            $guru->user->update(['password' => Hash::make($request->password)]);
        }

        return back()->with('success', 'Guru berhasil diupdate');
    }

    public function destroyGuru($id)
    {
        $guru = Guru::findOrFail($id);

        if ($guru->foto && file_exists(public_path($guru->foto))) {
            unlink(public_path($guru->foto));
        }

        $guru->user->delete();
        $guru->delete();

        return back()->with('success', 'Guru berhasil dihapus');
    }

    // ================= PETUGAS =================

    public function petugas()
    {
        $petugas = User::where('role', 'petugas')
            ->with('petugas')
            ->whereHas('petugas') 
            ->get();

        return view('admin.users.petugas', compact('petugas'));
    }

    public function storePetugas(Request $request)
    {
        $request->validate([
            'nip'           => 'required|unique:petugas,nip',
            'nama'          => 'required',
            'jenis_kelamin' => 'required',
            'email'         => 'required|email|unique:users,email',
            'password'      => 'required|min:6',
            'foto'          => 'nullable|image|max:2048',
        ]);

        $fotoPath = null;
        if ($request->hasFile('foto')) {
            $file     = $request->file('foto');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('assets/images/petugas'), $filename);
            $fotoPath = 'assets/images/petugas/' . $filename;
        }

        $user = User::create([
            'email'    => $request->email,
            'password' => Hash::make($request->password),
            'role'     => 'petugas',
        ]);

        Petugas::create([
            'user_id'       => $user->id,
            'nip'           => $request->nip,
            'nama'          => $request->nama,
            'jenis_kelamin' => $request->jenis_kelamin,
            'tanggal_lahir' => $request->tanggal_lahir,
            'no_hp'         => $request->no_hp,
            'alamat'        => $request->alamat,
            'status'        => $request->status ?? 'aktif',
            'foto'          => $fotoPath,
        ]);

        return back()->with('success', 'Petugas berhasil ditambahkan');
    }

    public function updatePetugas(Request $request, $id)
    {
        $petugas = Petugas::findOrFail($id);

        $request->validate([
            'nip'   => 'required|unique:petugas,nip,' . $id,
            'email' => 'required|email|unique:users,email,' . $petugas->user_id,
            'foto'  => 'nullable|image|max:2048',
        ]);

        $data = $request->except(['email', 'password', 'foto']);

        if ($request->hasFile('foto')) {
            if ($petugas->foto && file_exists(public_path($petugas->foto))) {
                unlink(public_path($petugas->foto));
            }
            $file     = $request->file('foto');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('assets/images/petugas'), $filename);
            $data['foto'] = 'assets/images/petugas/' . $filename;
        }

        $petugas->update($data);
        $petugas->user->update(['email' => $request->email]);

        if ($request->password) {
            $petugas->user->update(['password' => Hash::make($request->password)]);
        }

        return back()->with('success', 'Petugas berhasil diupdate');
    }

    public function destroyPetugas($id)
    {
        $petugas = Petugas::findOrFail($id);

        if ($petugas->foto && file_exists(public_path($petugas->foto))) {
            unlink(public_path($petugas->foto));
        }

        $petugas->user->delete();
        $petugas->delete();

        return back()->with('success', 'Petugas berhasil dihapus');
    }

    // ================= KELAS =================
    public function kelas()
    {
        $kelas = Kelas::with('jurusan')
            ->withCount('siswa')
            ->get();

        $jurusan = Jurusan::all();

        return view('admin.kelas.index', compact('kelas', 'jurusan'));
    }

    public function storeKelas(Request $request)
    {
        $request->validate([
            'nama_kelas' => 'required|unique:kelas,nama_kelas',
            'id_jurusan' => 'required|exists:jurusan,id_jurusan'
        ]);

        Kelas::create([
            'nama_kelas' => $request->nama_kelas,
            'deskripsi' => $request->deskripsi,
            'id_jurusan' => $request->id_jurusan
        ]);

        return back()->with('success', 'Kelas berhasil ditambahkan');
    }

    public function updateKelas(Request $request, $id)
    {
        $kelas = Kelas::findOrFail($id);

        $request->validate([
            'nama_kelas' => 'required|unique:kelas,nama_kelas,' . $id . ',id_kelas',
            'id_jurusan' => 'required|exists:jurusan,id_jurusan'
        ]);

        $kelas->update([
            'nama_kelas' => $request->nama_kelas,
            'deskripsi' => $request->deskripsi,
            'id_jurusan' => $request->id_jurusan
        ]);

        return back()->with('success', 'Kelas berhasil diupdate');
    }

    public function destroyKelas($id)
    {
        $kelas = Kelas::findOrFail($id);

        if ($kelas->siswa()->count() > 0) {
            return back()->with('error', 'Kelas tidak bisa dihapus karena masih ada siswa!');
        }

        $kelas->delete();

        return back()->with('success', 'Kelas berhasil dihapus');
    }

    // ================= JURUSAN =================
    public function jurusan()
    {
        $jurusan = Jurusan::withCount('kelas')->get();

        return view('admin.jurusan.index', compact('jurusan'));
    }

    public function storeJurusan(Request $request)
    {
        $request->validate([
            'kode_jurusan' => 'required|unique:jurusan,kode_jurusan',
            'nama_jurusan' => 'required|unique:jurusan,nama_jurusan',
        ]);

        Jurusan::create([
            'kode_jurusan' => strtoupper($request->kode_jurusan),
            'nama_jurusan' => $request->nama_jurusan,
            'deskripsi' => $request->deskripsi,
        ]);

        return back()->with('success', 'Jurusan berhasil ditambahkan');
    }

    public function updateJurusan(Request $request, $id)
    {
        $jurusan = Jurusan::findOrFail($id);

        $request->validate([
            'kode_jurusan' => 'required|unique:jurusan,kode_jurusan,' . $id . ',id_jurusan',
            'nama_jurusan' => 'required|unique:jurusan,nama_jurusan,' . $id . ',id_jurusan',
        ]);

        $jurusan->update([
            'kode_jurusan' => strtoupper($request->kode_jurusan),
            'nama_jurusan' => $request->nama_jurusan,
            'deskripsi' => $request->deskripsi,
        ]);

        return back()->with('success', 'Jurusan berhasil diupdate');
    }

    public function destroyJurusan($id)
    {
        $jurusan = Jurusan::findOrFail($id);

        if ($jurusan->kelas()->count() > 0) {
            return back()->with('error', 'Jurusan tidak bisa dihapus karena masih dipakai kelas!');
        }

        $jurusan->delete();

        return back()->with('success', 'Jurusan berhasil dihapus');
    }

    // ================= RUANGAN =================
    public function ruangan()
    {
        return view('admin.ruangan.index', [
            'ruangans' => Ruangan::latest()->get()
        ]);
    }

    public function storeRuangan(Request $request)
    {
        $request->validate([
            'kode_ruangan' => 'required|unique:ruangan,kode_ruangan',
            'nama_ruangan' => 'required',
            'jenis_ruangan' => 'required',
        ]);

        Ruangan::create([
            'kode_ruangan' => $request->kode_ruangan,
            'nama_ruangan' => $request->nama_ruangan,
            'jenis_ruangan' => $request->jenis_ruangan,
            'lokasi' => $request->lokasi,
            'kapasitas' => $request->kapasitas,
            'kondisi' => $request->kondisi,
            'deskripsi' => $request->deskripsi,
        ]);

        return back()->with('success', 'Ruangan berhasil ditambahkan');
    }

    public function updateRuangan(Request $request, $id)
    {
        $ruangan = \App\Models\Ruangan::findOrFail($id);

        $request->validate([
            'kode_ruangan' => 'required|unique:ruangan,kode_ruangan,' . $id . ',id_ruangan',
            'nama_ruangan' => 'required',
            'jenis_ruangan' => 'required',
            'lokasi' => 'nullable|string',
            'kapasitas' => 'nullable|integer|min:1',
            'kondisi' => 'required',
            'deskripsi' => 'nullable|string',
        ]);

        $ruangan->update([
            'kode_ruangan' => strtoupper($request->kode_ruangan),
            'nama_ruangan' => $request->nama_ruangan,
            'jenis_ruangan' => $request->jenis_ruangan,
            'lokasi' => $request->lokasi,
            'kapasitas' => $request->kapasitas,
            'kondisi' => $request->kondisi,
            'deskripsi' => $request->deskripsi,
        ]);

        return back()->with('success', 'Ruangan berhasil diupdate');
    }

    public function destroyRuangan($id)
    {
        $ruangan = \App\Models\Ruangan::findOrFail($id);

        // optional safety (kalau nanti ada relasi)
        // if ($ruangan->siswa()->count() > 0) {
        //     return back()->with('error', 'Tidak bisa dihapus karena masih dipakai!');
        // }

        $ruangan->delete();

        return back()->with('success', 'Ruangan berhasil dihapus');
    }

    // ================= KATEGORI =================
    public function kategori()
    {
        return view('admin.kategori.index', [
            'kategoris' => Kategori::all()
        ]);
    }

    public function storeKategori(Request $request)
    {
        $request->validate([
            'nama_kategori' => 'required|unique:kategori,nama_kategori',
        ]);

        Kategori::create($request->all());

        return back()->with('success', 'Kategori ditambahkan');
    }

    public function updateKategori(Request $request, $id)
    {
        $kategori = Kategori::findOrFail($id);

        $request->validate([
            'nama_kategori' => 'required|unique:kategori,nama_kategori,' . $id . ',id_kategori',
        ]);

        $kategori->update($request->all());

        return back()->with('success', 'Kategori diupdate');
    }

    public function destroyKategori($id)
    {
        Kategori::findOrFail($id)->delete();

        return back()->with('success', 'Kategori dihapus');
    }

    // ================= ASPIRASI =================
    public function pengaduan()
    {
        return view('admin.pengaduan.index', [
            'aspirasi' => Aspirasi::latest()->paginate(10),
            'kategoris' => Kategori::all()
        ]);
    }

    public function updateStatus(Request $request, $id)
    {
        $aspirasi = Aspirasi::findOrFail($id);

        HistoryStatus::create([
            'id_aspirasi' => $id,
            'status_lama' => $aspirasi->status,
            'status_baru' => $request->status,
            'diubah_oleh' => auth()->id(),
        ]);

        $aspirasi->update([
            'status' => $request->status
        ]);

        return back()->with('success', 'Status diupdate');
    }

    public function destroyAspirasi($id)
    {
        $aspirasi = Aspirasi::findOrFail($id);

        if ($aspirasi->foto && Storage::exists('public/' . $aspirasi->foto)) {
            Storage::delete('public/' . $aspirasi->foto);
        }

        Progres::where('id_aspirasi', $id)->delete();
        HistoryStatus::where('id_aspirasi', $id)->delete();

        $aspirasi->delete();

        return back()->with('success', 'Aspirasi dihapus');
    }
}
