@extends('layouts.admin')

@section('title', 'Data Guru')

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

    .avatar {
        width: 45px;
        height: 45px;
        border-radius: 50%;
        object-fit: cover;
        border: 2px solid #ddd;
    }
</style>

{{-- HEADER --}}
<div class="page-header">
    <div>
        <h5>Manajemen Guru</h5>
        <p>Kelola data guru yang tersedia</p>
    </div>
    <button class="btn btn-light btn-sm" data-toggle="modal" data-target="#createGuruModal">
        + Tambah Guru
    </button>
</div>

<div class="card card-custom">
    <div class="card-body">

        {{-- ALERT --}}
        @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        {{-- TABLE --}}
        <div class="table-responsive">
            <table class="table align-middle">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Foto</th>
                        <th>NIP</th>
                        <th>Nama</th>
                        <th>Mapel</th>
                        <th>Gender</th>
                        <th>Email</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($gurus as $index => $guru)
                    <tr>
                        <td>{{ $index + 1 }}</td>

                        <td>
                            <img src="{{ $guru->guru->foto ? asset($guru->guru->foto) : asset('assets/images/avatar-1.jpg') }}" class="avatar">
                        </td>

                        <td>{{ $guru->guru->nip }}</td>
                        <td class="fw-semibold text-primary">{{ $guru->guru->nama }}</td>
                        <td>{{ $guru->guru->mata_pelajaran }}</td>
                        <td>
                            {{ $guru->guru->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan' }}
                        </td>
                        <td>{{ $guru->email }}</td>

                        <td>
                            <div class="aksi-group">
                                <button class="btn-soft btn-view"
                                    data-toggle="modal"
                                    data-target="#viewGuruModal{{ $guru->guru->id }}">
                                    View
                                </button>

                                <button class="btn-soft btn-edit"
                                    data-toggle="modal"
                                    data-target="#editGuruModal{{ $guru->guru->id }}">
                                    Edit
                                </button>

                                <button class="btn-soft btn-delete"
                                    data-toggle="modal"
                                    data-target="#deleteGuruModal{{ $guru->guru->id }}">
                                    Hapus
                                </button>
                            </div>
                        </td>
                    </tr>

                    {{-- ===== MODAL VIEW ===== --}}
                    <div class="modal fade" id="viewGuruModal{{ $guru->guru->id }}" tabindex="-1">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Detail Guru</h5>
                                    <button type="button" class="btn-close" data-dismiss="modal"></button>
                                </div>
                                <div class="modal-body">
                                    <div class="row">
                                        <div class="col-md-4 text-center">
                                            <img src="{{ $guru->guru->foto ? asset($guru->guru->foto) : asset('assets/images/avatar-1.jpg') }}"
                                                width="130" height="130"
                                                style="border-radius:50%; object-fit:cover; border:3px solid #ddd;"
                                                class="mb-3">
                                            <h6 class="mb-0">{{ $guru->guru->nama }}</h6>
                                            <small class="text-muted">{{ $guru->guru->mata_pelajaran ?? '-' }}</small>
                                        </div>
                                        <div class="col-md-8">
                                            <div class="row">
                                                <div class="col-md-6 mb-3">
                                                    <label class="text-muted small">NIP</label>
                                                    <div class="fw-bold">{{ $guru->guru->nip }}</div>
                                                </div>
                                                <div class="col-md-6 mb-3">
                                                    <label class="text-muted small">Email</label>
                                                    <div class="fw-bold">{{ $guru->email }}</div>
                                                </div>
                                                <div class="col-md-6 mb-3">
                                                    <label class="text-muted small">Mata Pelajaran</label>
                                                    <div class="fw-bold">{{ $guru->guru->mata_pelajaran ?? '-' }}</div>
                                                </div>
                                                <div class="col-md-6 mb-3">
                                                    <label class="text-muted small">Jenis Kelamin</label>
                                                    <div class="fw-bold">
                                                        {{ $guru->guru->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan' }}
                                                    </div>
                                                </div>
                                                <div class="col-md-6 mb-3">
                                                    <label class="text-muted small">No HP</label>
                                                    <div class="fw-bold">{{ $guru->guru->no_hp ?? '-' }}</div>
                                                </div>
                                                <div class="col-md-6 mb-3">
                                                    <label class="text-muted small">Tanggal Lahir</label>
                                                    <div class="fw-bold">
                                                        {{ $guru->guru->tanggal_lahir ? $guru->guru->tanggal_lahir->format('d M Y') : '-' }}
                                                    </div>
                                                </div>
                                                <div class="col-12 mb-3">
                                                    <label class="text-muted small">Alamat</label>
                                                    <div class="fw-bold">{{ $guru->guru->alamat ?? '-' }}</div>
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
                    <div class="modal fade" id="editGuruModal{{ $guru->guru->id }}" tabindex="-1">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Edit Data Guru</h5>
                                    <button type="button" class="btn-close" data-dismiss="modal"></button>
                                </div>
                                <form action="{{ route('admin.guru.update', $guru->guru->id) }}"
                                    method="POST" enctype="multipart/form-data">
                                    @csrf
                                    @method('PUT')
                                    <div class="modal-body">
                                        <div class="row">

                                            {{-- KOLOM KIRI --}}
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label class="form-label">NIP</label>
                                                    <input type="text" name="nip"
                                                        value="{{ $guru->guru->nip }}"
                                                        class="form-control" required>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label">Nama</label>
                                                    <input type="text" name="nama"
                                                        value="{{ $guru->guru->nama }}"
                                                        class="form-control" required>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label">Mata Pelajaran</label>
                                                    <input type="text" name="mata_pelajaran"
                                                        value="{{ $guru->guru->mata_pelajaran }}"
                                                        class="form-control" required>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label">Jenis Kelamin</label>
                                                    <select name="jenis_kelamin" class="form-control" required>
                                                        <option value="L" {{ $guru->guru->jenis_kelamin == 'L' ? 'selected' : '' }}>Laki-laki</option>
                                                        <option value="P" {{ $guru->guru->jenis_kelamin == 'P' ? 'selected' : '' }}>Perempuan</option>
                                                    </select>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label">Tanggal Lahir</label>
                                                    <input type="date" name="tanggal_lahir"
                                                        value="{{ $guru->guru->tanggal_lahir ? $guru->guru->tanggal_lahir->format('Y-m-d') : '' }}"
                                                        class="form-control" required>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label">No HP</label>
                                                    <input type="text" name="no_hp"
                                                        value="{{ $guru->guru->no_hp }}"
                                                        class="form-control" required>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label">Alamat</label>
                                                    <textarea name="alamat" class="form-control" required>{{ $guru->guru->alamat }}</textarea>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label">Email</label>
                                                    <input type="email" name="email"
                                                        value="{{ $guru->email }}"
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
                                                    <img src="{{ $guru->guru->foto ? asset($guru->guru->foto) : asset('assets/images/avatar-1.jpg') }}"
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
                    <div class="modal fade" id="deleteGuruModal{{ $guru->guru->id }}" tabindex="-1">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header bg-danger text-white">
                                    <h5 class="modal-title">Hapus Guru</h5>
                                    <button type="button" class="btn-close btn-close-white" data-dismiss="modal"></button>
                                </div>
                                <div class="modal-body text-center">
                                    <i class="ph ph-warning-circle" style="font-size:48px; color:#dc2626;"></i>
                                    <p class="mt-3">Yakin ingin menghapus guru
                                        <strong>"{{ $guru->guru->nama }}"</strong>?
                                    </p>
                                    <small class="text-muted">NIP: {{ $guru->guru->nip }}</small>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                                    <form action="{{ route('admin.guru.destroy', $guru->guru->id) }}" method="POST" class="d-inline">
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
                        <td colspan="8" class="text-center text-muted py-4">
                            Belum ada data guru
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

    </div>
</div>

{{-- ===== MODAL CREATE ===== --}}
<div class="modal fade" id="createGuruModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tambah Guru Baru</h5>
                <button type="button" class="btn-close" data-dismiss="modal"></button>
            </div>
            <form action="{{ route('admin.guru.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="row">

                        <div class="col-md-6 mb-3">
                            <label class="form-label">NIP</label>
                            <input type="text" name="nip" class="form-control" required>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">Nama</label>
                            <input type="text" name="nama" class="form-control" required>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">Mata Pelajaran</label>
                            <input type="text" name="mata_pelajaran" class="form-control" required>
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
                    <button type="submit" class="btn btn-success">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection