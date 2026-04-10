@extends('layouts.admin')

@section('title', 'Manajemen Kategori')

@section('content')
<div class="row">
    <!-- FORM TAMBAH -->
    <div class="col-xl-4">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Tambah Kategori</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.kategori.store') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label>Nama Kategori</label>
                        <input type="text" name="nama_kategori"
                            class="form-control @error('nama_kategori') is-invalid @enderror"
                            value="{{ old('nama_kategori') }}" required>

                        @error('nama_kategori')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label>Deskripsi</label>
                        <textarea name="deskripsi" class="form-control" rows="3">{{ old('deskripsi') }}</textarea>
                    </div>

                    <button class="btn btn-primary btn-block">Tambah</button>
                </form>
            </div>
        </div>
    </div>

    <!-- TABLE -->
    <div class="col-xl-8">
        <div class="card">
            <div class="card-header">
                <h5>Daftar Kategori</h5>
            </div>

            <div class="card-body p-0">
                <table class="table">
                    <thead class="bg-light">
                        <tr>
                            <th>No</th>
                            <th>Nama</th>
                            <th>Deskripsi</th>
                            <th>Aspirasi</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($kategoris as $index => $kategori)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $kategori->nama_kategori }}</td>
                            <td>
                                {{ $kategori->deskripsi ? Str::limit($kategori->deskripsi, 50) : '-' }}
                            </td>
                            <td>
                                <span class="badge badge-info">
                                    {{ $kategori->aspirasi_count ?? 0 }}
                                </span>
                            </td>
                            <td>
                                <!-- EDIT -->
                                <button class="btn btn-warning btn-sm"
                                    data-toggle="modal"
                                    data-target="#editModal{{ $kategori->id_kategori }}">
                                    Edit
                                </button>

                                <!-- DELETE -->
                                <button class="btn btn-danger btn-sm"
                                    data-toggle="modal"
                                    data-target="#deleteModal{{ $kategori->id_kategori }}">
                                    Hapus
                                </button>
                            </td>
                        </tr>

                        <!-- MODAL EDIT -->
                        <div class="modal fade" id="editModal{{ $kategori->id_kategori }}">
                            <div class="modal-dialog">
                                <div class="modal-content">

                                    <form action="{{ route('admin.kategori.update', $kategori->id_kategori) }}" method="POST">
                                        @csrf
                                        @method('PUT')

                                        <div class="modal-header">
                                            <h5>Edit Kategori</h5>
                                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                                        </div>

                                        <div class="modal-body">
                                            <input type="text" name="nama_kategori"
                                                class="form-control mb-2"
                                                value="{{ $kategori->nama_kategori }}" required>

                                            <textarea name="deskripsi"
                                                class="form-control"
                                                rows="3">{{ $kategori->deskripsi }}</textarea>

                                            @if(($kategori->aspirasi_count ?? 0) > 0)
                                            <div class="alert alert-warning mt-2">
                                                Kategori dipakai di {{ $kategori->aspirasi_count }} aspirasi
                                            </div>
                                            @endif
                                        </div>

                                        <div class="modal-footer">
                                            <button class="btn btn-secondary" data-dismiss="modal">Batal</button>
                                            <button class="btn btn-primary">Simpan</button>
                                        </div>
                                    </form>

                                </div>
                            </div>
                        </div>

                        <!-- MODAL DELETE -->
                        <div class="modal fade" id="deleteModal{{ $kategori->id_kategori }}">
                            <div class="modal-dialog">
                                <div class="modal-content">

                                    <div class="modal-header bg-danger text-white">
                                        <h5>Hapus Kategori</h5>
                                    </div>

                                    <div class="modal-body text-center">
                                        Hapus <b>{{ $kategori->nama_kategori }}</b> ?

                                        @if(($kategori->aspirasi_count ?? 0) > 0)
                                        <div class="alert alert-danger mt-2">
                                            Ada {{ $kategori->aspirasi_count }} aspirasi terkait!
                                        </div>
                                        @endif
                                    </div>

                                    <div class="modal-footer">
                                        <button class="btn btn-secondary" data-dismiss="modal">Batal</button>

                                        <form action="{{ route('admin.kategori.destroy', $kategori->id_kategori) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-danger">Ya, Hapus</button>
                                        </form>
                                    </div>

                                </div>
                            </div>
                        </div>

                        @empty
                        <tr>
                            <td colspan="5" class="text-center">Belum ada data</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection