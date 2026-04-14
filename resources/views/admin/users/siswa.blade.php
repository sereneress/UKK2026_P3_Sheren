@extends('layouts.admin')

@section('title', 'Data Siswa')

@section('content')

<style>
    .page-header {
        background: linear-gradient(135deg, #1e3a5f 0%, #2d6a9f 100%);
        border-radius: 12px;
        padding: 20px 24px;
        margin-bottom: 20px;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .page-header h5 {
        color: #fff;
        margin: 0;
    }

    .page-header p {
        color: rgba(255, 255, 255, 0.7);
        margin: 0;
        font-size: 13px;
    }

    .card-custom {
        border: none;
        border-radius: 12px;
        box-shadow: 0 2px 12px rgba(0, 0, 0, 0.06);
    }

    .table thead th {
        background: #f8fafc;
        font-size: 0.75rem;
        text-transform: uppercase;
    }

    .avatar {
        width: 45px;
        height: 45px;
        border-radius: 50%;
        object-fit: cover;
        border: 2px solid #ddd;
    }

    .btn-soft {
        padding: 6px 12px;
        font-size: 0.75rem;
        font-weight: 600;
        border-radius: 7px;
        border: none;
    }

    .btn-view {
        background: #e0f2fe;
        color: #0284c7;
    }

    .btn-edit {
        background: #fffbeb;
        color: #d97706;
    }

    .btn-delete {
        background: #fef2f2;
        color: #dc2626;
    }

    .aksi-group {
        display: flex;
        gap: 6px;
    }
</style>

{{-- HEADER --}}
<div class="page-header">
    <div>
        <h5>Manajemen Siswa</h5>
        <p>Kelola data siswa yang tersedia</p>
    </div>
    <button class="btn btn-light btn-sm" data-toggle="modal" data-target="#createSiswaModal">
        + Tambah Siswa
    </button>
</div>

<div class="card card-custom">
    <div class="card-body">

        {{-- ALERT --}}
        @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        @if($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        {{-- TABLE --}}
        <div class="table-responsive">
            <table class="table align-middle">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Foto</th>
                        <th>NIS</th>
                        <th>Nama</th>
                        <th>Kelas</th>
                        <th>Jurusan</th>
                        <th>Gender</th>
                        <th>Email</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($siswas as $index => $siswa)
                    <tr>
                        <td>{{ $index + 1 }}</td>

                        <td>
                            <img src="{{ $siswa->siswa->foto ? asset($siswa->siswa->foto) : asset('assets/images/avatar-1.jpg') }}"
                                class="avatar">
                        </td>

                        <td>{{ $siswa->siswa->nis }}</td>

                        <td class="fw-semibold text-primary">
                            {{ $siswa->siswa->nama }}
                        </td>

                        <td>{{ $siswa->siswa->kelas }}</td>
                        <td>{{ $siswa->siswa->jurusan }}</td>

                        <td>
                            {{ $siswa->siswa->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan' }}
                        </td>

                        <td>{{ $siswa->email }}</td>

                        <td>
                            <div class="aksi-group">
                                <button class="btn-soft btn-view"
                                    data-toggle="modal"
                                    data-target="#viewSiswaModal{{ $siswa->siswa->id }}">
                                    View
                                </button>

                                <button class="btn-soft btn-edit"
                                    data-toggle="modal"
                                    data-target="#editSiswaModal{{ $siswa->siswa->id }}">
                                    Edit
                                </button>

                                <button class="btn-soft btn-delete"
                                    data-toggle="modal"
                                    data-target="#deleteSiswaModal{{ $siswa->siswa->id }}">
                                    Hapus
                                </button>
                            </div>
                        </td>
                    </tr>

                    {{-- ===== MODAL VIEW ===== --}}
                    <div class="modal fade" id="viewSiswaModal{{ $siswa->siswa->id }}" tabindex="-1">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Detail Siswa</h5>
                                    <button type="button" class="btn-close" data-dismiss="modal"></button>
                                </div>
                                <div class="modal-body">
                                    <div class="row">
                                        <div class="col-md-4 text-center">
                                            <img src="{{ $siswa->siswa->foto ? asset($siswa->siswa->foto) : asset('assets/images/avatar-1.jpg') }}"
                                                width="130" height="130"
                                                style="border-radius:50%; object-fit:cover; border:3px solid #ddd;"
                                                class="mb-3">
                                            <h6 class="mb-0">{{ $siswa->siswa->nama }}</h6>
                                            <small class="text-muted">{{ $siswa->siswa->kelas ?? '-' }}</small>
                                        </div>
                                        <div class="col-md-8">
                                            <div class="row">
                                                <div class="col-md-6 mb-3">
                                                    <label class="text-muted small">NIS</label>
                                                    <div class="fw-bold">{{ $siswa->siswa->nis }}</div>
                                                </div>
                                                <div class="col-md-6 mb-3">
                                                    <label class="text-muted small">Email</label>
                                                    <div class="fw-bold">{{ $siswa->email }}</div>
                                                </div>
                                                <div class="col-md-6 mb-3">
                                                    <label class="text-muted small">Kelas</label>
                                                    <div class="fw-bold">{{ $siswa->siswa->kelas ?? '-' }}</div>
                                                </div>
                                                <div class="col-md-6 mb-3">
                                                    <label class="text-muted small">Jurusan</label>
                                                    <div class="fw-bold">{{ $siswa->siswa->jurusan ?? '-' }}</div>
                                                </div>
                                                <div class="col-md-6 mb-3">
                                                    <label class="text-muted small">Jenis Kelamin</label>
                                                    <div class="fw-bold">
                                                        {{ $siswa->siswa->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan' }}
                                                    </div>
                                                </div>
                                                <div class="col-md-6 mb-3">
                                                    <label class="text-muted small">No HP</label>
                                                    <div class="fw-bold">{{ $siswa->siswa->no_hp ?? '-' }}</div>
                                                </div>
                                                <div class="col-md-6 mb-3">
                                                    <label class="text-muted small">Tanggal Lahir</label>
                                                    <div class="fw-bold">
                                                        {{ $siswa->siswa->tanggal_lahir ? $siswa->siswa->tanggal_lahir->format('d M Y') : '-' }}
                                                    </div>
                                                </div>
                                                <div class="col-12 mb-3">
                                                    <label class="text-muted small">Alamat</label>
                                                    <div class="fw-bold">{{ $siswa->siswa->alamat ?? '-' }}</div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- ===== MODAL EDIT ===== --}}
                    <div class="modal fade" id="editSiswaModal{{ $siswa->siswa->id }}" tabindex="-1">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Edit Data Siswa</h5>
                                    <button type="button" class="btn-close" data-dismiss="modal"></button>
                                </div>
                                <form action="{{ route('admin.siswa.update', $siswa->siswa->id) }}"
                                    method="POST" enctype="multipart/form-data">
                                    @csrf
                                    @method('PUT')
                                    <div class="modal-body">
                                        <div class="row">

                                            {{-- KOLOM KIRI --}}
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label class="form-label">NIS</label>
                                                    <input type="text" name="nis"
                                                        value="{{ $siswa->siswa->nis }}"
                                                        class="form-control" required>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label">Nama</label>
                                                    <input type="text" name="nama"
                                                        value="{{ $siswa->siswa->nama }}"
                                                        class="form-control" required>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label">Kelas</label>
                                                    <input type="text" name="kelas"
                                                        value="{{ $siswa->siswa->kelas }}"
                                                        class="form-control" required>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label">Jurusan</label>
                                                    <input type="text" name="jurusan"
                                                        value="{{ $siswa->siswa->jurusan }}"
                                                        class="form-control" required>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label">Jenis Kelamin</label>
                                                    <select name="jenis_kelamin" class="form-control" required>
                                                        <option value="L" {{ $siswa->siswa->jenis_kelamin == 'L' ? 'selected' : '' }}>Laki-laki</option>
                                                        <option value="P" {{ $siswa->siswa->jenis_kelamin == 'P' ? 'selected' : '' }}>Perempuan</option>
                                                    </select>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label">Tanggal Lahir</label>
                                                    <input type="date" name="tanggal_lahir"
                                                        value="{{ $siswa->siswa->tanggal_lahir ? $siswa->siswa->tanggal_lahir->format('Y-m-d') : '' }}"
                                                        class="form-control" required>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label">No HP</label>
                                                    <input type="text" name="no_hp"
                                                        value="{{ $siswa->siswa->no_hp }}"
                                                        class="form-control" required>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label">Alamat</label>
                                                    <textarea name="alamat" class="form-control" required>{{ $siswa->siswa->alamat }}</textarea>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label">Email</label>
                                                    <input type="email" name="email"
                                                        value="{{ $siswa->email }}"
                                                        class="form-control" required>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label">Password</label>
                                                    <input type="password" name="password"
                                                        class="form-control"
                                                        placeholder="Kosongkan jika tidak diubah">
                                                </div>
                                            </div>

                                            {{-- KOLOM KANAN - FOTO --}}
                                            <div class="col-md-6">
                                                <label class="form-label">Foto Saat Ini</label>
                                                <div class="mb-3 text-center">
                                                    <img src="{{ $siswa->siswa->foto ? asset($siswa->siswa->foto) : asset('assets/images/avatar-1.jpg') }}"
                                                        width="120" height="120"
                                                        style="border-radius:50%; object-fit:cover; border:3px solid #ddd;">
                                                </div>
                                                <div class="mb-2">
                                                    <label class="form-label">Ganti Foto</label>
                                                    <input type="file" name="foto" class="form-control" accept="image/*">
                                                    <small class="text-muted">Kosongkan jika tidak ingin mengganti. Maks 2MB.</small>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                                        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    {{-- ===== MODAL DELETE ===== --}}
                    <div class="modal fade" id="deleteSiswaModal{{ $siswa->siswa->id }}" tabindex="-1">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header bg-danger text-white">
                                    <h5 class="modal-title">Hapus Siswa</h5>
                                    <button type="button" class="btn-close btn-close-white" data-dismiss="modal"></button>
                                </div>
                                <div class="modal-body text-center">
                                    <i class="ph ph-warning-circle" style="font-size:48px; color:#dc2626;"></i>
                                    <p class="mt-3">Yakin ingin menghapus siswa
                                        <strong>"{{ $siswa->siswa->nama }}"</strong>?
                                    </p>
                                    <small class="text-muted">NIS: {{ $siswa->siswa->nis }}</small>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                                    <form action="{{ route('admin.siswa.destroy', $siswa->siswa->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger">Ya, Hapus</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                    @empty
                    <tr>
                        <td colspan="9" class="text-center text-muted py-4">
                            Belum ada data siswa
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

    </div>
</div>

{{-- ===== MODAL CREATE ===== --}}
<div class="modal fade" id="createSiswaModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tambah Siswa Baru</h5>
                <button type="button" class="btn-close" data-dismiss="modal"></button>
            </div>
            <form action="{{ route('admin.siswa.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="row">

                        <div class="col-md-6 mb-3">
                            <label class="form-label">NIS</label>
                            <input type="text" name="nis" class="form-control" required>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">Nama</label>
                            <input type="text" name="nama" class="form-control" required>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">Kelas</label>
                            <input type="text" name="kelas" class="form-control" required>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">Jurusan</label>
                            <input type="text" name="jurusan" class="form-control" required>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">Jenis Kelamin</label>
                            <select name="jenis_kelamin" class="form-control" required>
                                <option value="">Pilih</option>
                                <option value="L">Laki-laki</option>
                                <option value="P">Perempuan</option>
                            </select>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">Tanggal Lahir</label>
                            <input type="date" name="tanggal_lahir" class="form-control" required>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">No HP</label>
                            <input type="text" name="no_hp" class="form-control" required>
                        </div>

                        <div class="col-12 mb-3">
                            <label class="form-label">Alamat</label>
                            <textarea name="alamat" class="form-control" rows="2" required></textarea>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">Email</label>
                            <input type="email" name="email" class="form-control" required>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">Password</label>
                            <input type="password" name="password" class="form-control" required>
                            <small class="text-muted">Minimal 6 karakter</small>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">Foto</label>
                            <input type="file" name="foto" class="form-control" accept="image/*">
                            <small class="text-muted">Opsional, maks 2MB</small>
                        </div>

                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-info">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection