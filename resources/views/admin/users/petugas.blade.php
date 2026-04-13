@extends('layouts.admin')

@section('title', 'Data Petugas')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card shadow-sm">

            {{-- HEADER --}}
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Data Petugas</h5>
                <button class="btn btn-success btn-sm" data-toggle="modal" data-target="#createPetugasModal">
                    + Tambah Petugas
                </button>
            </div>

            {{-- BODY --}}
            <div class="card-body">

                @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show">
                    {{ session('success') }}
                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                </div>
                @endif

                @if($errors->any())
                <div class="alert alert-danger alert-dismissible fade show">
                    <ul class="mb-0">
                        @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                </div>
                @endif

                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead class="table-light">
                            <tr>
                                <th width="5%">No</th>
                                <th>Foto</th>
                                <th>NIP</th>
                                <th>Nama</th>
                                <th>Jenis Kelamin</th>
                                <th>Email</th>
                                <th>Status</th>
                                <th width="15%">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($petugas as $index => $p)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>
                                    <img src="{{ $p->petugas?->foto ? asset($p->petugas?->foto) : asset('assets/images/avatar-1.jpg') }}"
                                        width="45" height="45"
                                        style="border-radius:50%; object-fit:cover; border:2px solid #ddd;">
                                </td>
                                <td>{{ $p->petugas->nip ?? '-' }}</td>
                                <td>{{ $p->petugas?->nama ?? '-' }}</td>
                                <td>{{ ($p->petugas->jenis_kelamin ?? '') == 'L' ? 'Laki-laki' : 'Perempuan' }}</td>
                                <td>{{ $p->email }}</td>
                                <td>
                                    <span class="badge {{ ($p->petugas->status ?? 'aktif') == 'aktif' ? 'bg-success' : 'bg-secondary' }}">
                                        {{ ucfirst($p->petugas->status ?? 'Aktif') }}
                                    </span>
                                </td>
                                <td>
                                    <button type="button" class="btn btn-info btn-sm"
                                        data-toggle="modal"
                                        data-target="#viewPetugasModal{{ $p->petugas?->id ?? $p->id }}">
                                        View
                                    </button>
                                    <button type="button" class="btn btn-warning btn-sm"
                                        data-toggle="modal"
                                        data-target="#editPetugasModal{{ $p->petugas?->id ?? $p->id }}">
                                        Edit
                                    </button>
                                    <button type="button" class="btn btn-danger btn-sm"
                                        data-toggle="modal"
                                        data-target="#deletePetugasModal{{ $p->petugas?->id ?? $p->id }}">
                                        Hapus
                                    </button>
                                </td>
                            </tr>

                            {{-- ===== MODAL VIEW ===== --}}
                            <div class="modal fade" id="viewPetugasModal{{ $p->petugas?->id ?? $p->id }}" tabindex="-1">
                                <div class="modal-dialog modal-lg">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Detail Petugas</h5>
                                            <button type="button" class="btn-close" data-dismiss="modal"></button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="row">
                                                <div class="col-md-4 text-center">
                                                    <img src="{{ $p->petugas?->foto ? asset($p->petugas?->foto) : asset('assets/images/avatar-1.jpg') }}"
                                                        width="130" height="130"
                                                        style="border-radius:50%; object-fit:cover; border:3px solid #ddd;"
                                                        class="mb-3">
                                                    <h6 class="mb-0">{{ $p->petugas->nama }}</h6>
                                                    <small class="text-muted">
                                                        <span class="badge {{ ($p->petugas->status ?? 'aktif') == 'aktif' ? 'bg-success' : 'bg-secondary' }}">
                                                            {{ ucfirst($p->petugas->status ?? 'Aktif') }}
                                                        </span>
                                                    </small>
                                                </div>
                                                <div class="col-md-8">
                                                    <div class="row">
                                                        <div class="col-md-6 mb-3">
                                                            <label class="text-muted small">NIP</label>
                                                            <div class="fw-bold">{{ $p->petugas->nip }}</div>
                                                        </div>
                                                        <div class="col-md-6 mb-3">
                                                            <label class="text-muted small">Email</label>
                                                            <div class="fw-bold">{{ $p->email }}</div>
                                                        </div>
                                                        <div class="col-md-6 mb-3">
                                                            <label class="text-muted small">Jenis Kelamin</label>
                                                            <div class="fw-bold">
                                                                {{ ($p->petugas->jenis_kelamin ?? '') == 'L' ? 'Laki-laki' : 'Perempuan' }}
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6 mb-3">
                                                            <label class="text-muted small">No HP</label>
                                                            <div class="fw-bold">{{ $p->petugas->no_hp ?? '-' }}</div>
                                                        </div>
                                                        <div class="col-md-6 mb-3">
                                                            <label class="text-muted small">Tanggal Lahir</label>
                                                            <div class="fw-bold">{{ $p->petugas->tanggal_lahir ?? '-' }}</div>
                                                        </div>
                                                        <div class="col-12 mb-3">
                                                            <label class="text-muted small">Alamat</label>
                                                            <div class="fw-bold">{{ $p->petugas->alamat ?? '-' }}</div>
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
                            <div class="modal fade" id="editPetugasModal{{ $p->petugas?->id ?? $p->id }}" tabindex="-1">
                                <div class="modal-dialog modal-lg">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Edit Data Petugas</h5>
                                            <button type="button" class="btn-close" data-dismiss="modal"></button>
                                        </div>
                                        <form action="{{ route('admin.petugas.update', $p->petugas->id) }}"
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
                                                                value="{{ $p->petugas->nip }}"
                                                                class="form-control" required>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label class="form-label">Nama</label>
                                                            <input type="text" name="nama"
                                                                value="{{ $p->petugas->nama }}"
                                                                class="form-control" required>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label class="form-label">Jenis Kelamin</label>
                                                            <select name="jenis_kelamin" class="form-control" required>
                                                                <option value="L" {{ ($p->petugas->jenis_kelamin ?? '') == 'L' ? 'selected' : '' }}>Laki-laki</option>
                                                                <option value="P" {{ ($p->petugas->jenis_kelamin ?? '') == 'P' ? 'selected' : '' }}>Perempuan</option>
                                                            </select>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label class="form-label">Tanggal Lahir</label>
                                                            <input type="date" name="tanggal_lahir"
                                                                value="{{ $p->petugas->tanggal_lahir ?? '' }}"
                                                                class="form-control">
                                                        </div>
                                                        <div class="mb-3">
                                                            <label class="form-label">No HP</label>
                                                            <input type="text" name="no_hp"
                                                                value="{{ $p->petugas->no_hp ?? '' }}"
                                                                class="form-control">
                                                        </div>
                                                        <div class="mb-3">
                                                            <label class="form-label">Alamat</label>
                                                            <textarea name="alamat" class="form-control">{{ $p->petugas->alamat ?? '' }}</textarea>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label class="form-label">Status</label>
                                                            <select name="status" class="form-control">
                                                                <option value="aktif" {{ ($p->petugas->status ?? '') == 'aktif' ? 'selected' : '' }}>Aktif</option>
                                                                <option value="nonaktif" {{ ($p->petugas->status ?? '') == 'nonaktif' ? 'selected' : '' }}>Nonaktif</option>
                                                            </select>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label class="form-label">Email</label>
                                                            <input type="email" name="email"
                                                                value="{{ $p->email }}"
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
                                                            <img src="{{ $p->petugas?->foto ? asset($p->petugas?->foto) : asset('assets/images/avatar-1.jpg') }}"
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
                            <div class="modal fade" id="deletePetugasModal{{ $p->petugas?->id ?? $p->id }}" tabindex="-1">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header bg-danger text-white">
                                            <h5 class="modal-title">Hapus Petugas</h5>
                                            <button type="button" class="btn-close btn-close-white" data-dismiss="modal"></button>
                                        </div>
                                        <div class="modal-body text-center">
                                            <i class="ph ph-warning-circle" style="font-size:48px; color:#dc2626;"></i>
                                            <p class="mt-3">Yakin ingin menghapus petugas
                                                <strong>"{{ $p->petugas->nama }}"</strong>?
                                            </p>
                                            <small class="text-muted">NIP: {{ $p->petugas->nip }}</small>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                                            <form action="{{ route('admin.petugas.destroy', $p->petugas->id) }}" method="POST" class="d-inline">
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
                                <td colspan="8" class="text-center text-muted py-4">Belum ada data petugas</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- ===== MODAL CREATE ===== --}}
<div class="modal fade" id="createPetugasModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tambah Petugas Baru</h5>
                <button type="button" class="btn-close" data-dismiss="modal"></button>
            </div>
            <form action="{{ route('admin.petugas.store') }}" method="POST" enctype="multipart/form-data">
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
                            <label class="form-label">Jenis Kelamin</label>
                            <select name="jenis_kelamin" class="form-control" required>
                                <option value="">Pilih</option>
                                <option value="L">Laki-laki</option>
                                <option value="P">Perempuan</option>
                            </select>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">Tanggal Lahir</label>
                            <input type="date" name="tanggal_lahir" class="form-control">
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">No HP</label>
                            <input type="text" name="no_hp" class="form-control">
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">Status</label>
                            <select name="status" class="form-control">
                                <option value="aktif">Aktif</option>
                                <option value="nonaktif">Nonaktif</option>
                            </select>
                        </div>

                        <div class="col-12 mb-3">
                            <label class="form-label">Alamat</label>
                            <textarea name="alamat" class="form-control" rows="2"></textarea>
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