@extends('layouts.admin')

@section('title', 'Manajemen Ruangan')

@section('content')

<style>
    .page-header {
        background: linear-gradient(135deg, #1e3a5f, #2d6a9f);
        border-radius: 12px;
        padding: 24px;
        margin-bottom: 20px;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .page-header h4 {
        color: #fff;
        margin: 0;
        font-weight: 700;
    }

    .card-custom {
        border: none;
        border-radius: 12px;
        box-shadow: 0 2px 12px rgba(0, 0, 0, 0.06);
    }

    .form-control-custom {
        border-radius: 8px;
        border: 1.5px solid #e2e8f0;
        padding: 9px 13px;
        width: 100%;
    }

    .form-control-custom:focus {
        border-color: #2d6a9f;
        box-shadow: 0 0 0 3px rgba(45, 106, 159, 0.1);
        outline: none;
    }

    .btn-primary-custom {
        background: linear-gradient(135deg, #1e3a5f, #2d6a9f);
        border: none;
        border-radius: 8px;
        padding: 10px;
        width: 100%;
        color: #fff;
        font-weight: 600;
    }

    .table thead th {
        background: #f8fafc;
        font-size: 0.75rem;
    }

    .aksi-group {
        display: flex;
        gap: 6px;
    }

    .btn-edit {
        background: #fffbeb;
        color: #d97706;
        border: 1px solid #fde68a;
        padding: 5px 10px;
        border-radius: 7px;
        font-size: 0.75rem;
        cursor: pointer;
    }

    .btn-hapus {
        background: #fef2f2;
        color: #dc2626;
        border: 1px solid #fecaca;
        padding: 5px 10px;
        border-radius: 7px;
        font-size: 0.75rem;
        cursor: pointer;
    }

    .btn-edit:hover {
        background: #fef3c7;
    }

    .btn-hapus:hover {
        background: #fee2e2;
    }

    .modal-content {
        border-radius: 12px;
        border: none;
    }
</style>

{{-- HEADER --}}
<div class="page-header">
    <h4>Manajemen Ruangan</h4>
</div>

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

<div class="row">

    {{-- FORM --}}
    <div class="col-md-4">
        <div class="card card-custom p-3">

            <form action="{{ route('admin.ruangan.store') }}" method="POST">
                @csrf

                <div class="mb-3">
                    <label>Kode Ruangan</label>
                    <input type="text" name="kode_ruangan" class="form-control-custom" required>
                </div>

                <div class="mb-3">
                    <label>Nama Ruangan</label>
                    <input type="text" name="nama_ruangan" class="form-control-custom" required>
                </div>

                <div class="mb-3">
                    <label>Jenis Ruangan</label>
                    <select name="jenis_ruangan" class="form-control-custom" required>
                        <option value="">Pilih Jenis</option>
                        <option value="Kelas">Kelas</option>
                        <option value="Laboratorium">Laboratorium</option>
                        <option value="Perpustakaan">Perpustakaan</option>
                        <option value="Kantin">Kantin</option>
                        <option value="Ruang Guru">Ruang Guru</option>
                        <option value="Ruang Kepala Sekolah">Ruang Kepala Sekolah</option>
                        <option value="Ruang UKS">Ruang UKS</option>
                        <option value="Lainnya">Lainnya</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label>Lokasi</label>
                    <input type="text" name="lokasi" class="form-control-custom">
                </div>

                <div class="mb-3">
                    <label>Kondisi</label>
                    <select name="kondisi" class="form-control-custom">
                        <option value="Baik">Baik</option>
                        <option value="Rusak Ringan">Rusak Ringan</option>
                        <option value="Rusak Berat">Rusak Berat</option>
                        <option value="Dalam Perbaikan">Dalam Perbaikan</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label>Deskripsi</label>
                    <textarea name="deskripsi" class="form-control-custom"></textarea>
                </div>

                <button class="btn-primary-custom">Tambah</button>
            </form>

        </div>
    </div>

    {{-- TABLE --}}
    <div class="col-md-8">
        <div class="card card-custom p-3">

            <table class="table">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Kode</th>
                        <th>Nama</th>
                        <th>Jenis</th>
                        <th>Lokasi</th>
                        <th>Kondisi</th>
                        <th>Aksi</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($ruangans as $index => $r)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td><b>{{ $r->kode_ruangan }}</b></td>
                        <td>{{ $r->nama_ruangan }}</td>
                        <td>{{ $r->jenis_ruangan }}</td>
                        <td>{{ $r->lokasi ?? '-' }}</td>
                        <td>{{ $r->kondisi ?? '-' }}</td>

                        <td>
                            <div class="aksi-group">
                                <button class="btn-edit"
                                    data-toggle="modal"
                                    data-target="#edit{{ $r->id_ruangan }}">
                                    ✏️ Edit
                                </button>

                                <button class="btn-hapus"
                                    data-toggle="modal"
                                    data-target="#delete{{ $r->id_ruangan }}">
                                    🗑️ Hapus
                                </button>
                            </div>
                        </td>
                    </tr>

                    {{-- MODAL EDIT --}}
                    <div class="modal fade" id="edit{{ $r->id_ruangan }}" tabindex="-1">
                        <div class="modal-dialog modal-dialog-centered modal-lg">
                            <div class="modal-content" style="border:none; border-radius:14px; overflow:hidden;">

                                <form action="{{ route('admin.ruangan.update', $r->id_ruangan) }}" method="POST">
                                    @csrf
                                    @method('PUT')

                                    {{-- HEADER --}}
                                    <div style="padding:16px 20px; border-bottom:1px solid #f1f5f9;">
                                        <h5 style="margin:0; font-weight:700; color:#1e3a5f;">
                                            ✏️ Edit Ruangan
                                        </h5>
                                    </div>

                                    {{-- BODY --}}
                                    <div class="modal-body">
                                        <div class="row">

                                            <div class="col-md-6 mb-3">
                                                <label style="font-size:0.75rem; font-weight:600; color:#64748b;">Kode Ruangan</label>
                                                <input type="text" name="kode_ruangan"
                                                    value="{{ $r->kode_ruangan }}"
                                                    class="form-control"
                                                    style="border-radius:8px;">
                                            </div>

                                            <div class="col-md-6 mb-3">
                                                <label style="font-size:0.75rem; font-weight:600; color:#64748b;">Nama Ruangan</label>
                                                <input type="text" name="nama_ruangan"
                                                    value="{{ $r->nama_ruangan }}"
                                                    class="form-control"
                                                    style="border-radius:8px;">
                                            </div>

                                            <div class="col-md-6 mb-3">
                                                <label style="font-size:0.75rem; font-weight:600; color:#64748b;">Jenis Ruangan</label>
                                                <select name="jenis_ruangan" class="form-control" style="border-radius:8px;">
                                                    @foreach(['Kelas','Laboratorium','Perpustakaan','Kantin','Ruang Guru','Ruang Kepala Sekolah','Ruang UKS','Lainnya'] as $jenis)
                                                    <option value="{{ $jenis }}" @selected($r->jenis_ruangan == $jenis)>
                                                        {{ $jenis }}
                                                    </option>
                                                    @endforeach
                                                </select>
                                            </div>

                                            <div class="col-md-6 mb-3">
                                                <label style="font-size:0.75rem; font-weight:600; color:#64748b;">Kondisi</label>
                                                <select name="kondisi" class="form-control" style="border-radius:8px;">
                                                    @foreach(['Baik','Rusak Ringan','Rusak Berat','Dalam Perbaikan'] as $k)
                                                    <option value="{{ $k }}" @selected($r->kondisi == $k)>
                                                        {{ $k }}
                                                    </option>
                                                    @endforeach
                                                </select>
                                            </div>

                                            <div class="col-md-6 mb-3">
                                                <label style="font-size:0.75rem; font-weight:600; color:#64748b;">Lokasi</label>
                                                <input type="text" name="lokasi"
                                                    value="{{ $r->lokasi }}"
                                                    class="form-control"
                                                    style="border-radius:8px;">
                                            </div>

                                            <div class="col-md-6 mb-3">
                                                <label style="font-size:0.75rem; font-weight:600; color:#64748b;">Kapasitas</label>
                                                <input type="number" name="kapasitas"
                                                    value="{{ $r->kapasitas }}"
                                                    class="form-control"
                                                    style="border-radius:8px;">
                                            </div>

                                            <div class="col-12 mb-3">
                                                <label style="font-size:0.75rem; font-weight:600; color:#64748b;">Deskripsi</label>
                                                <textarea name="deskripsi" class="form-control" style="border-radius:8px;">{{ $r->deskripsi }}</textarea>
                                            </div>

                                        </div>
                                    </div>

                                    {{-- FOOTER --}}
                                    <div style="padding:14px 20px; border-top:1px solid #f1f5f9; display:flex; justify-content:flex-end; gap:8px;">
                                        <button type="button" class="btn btn-light btn-sm" data-dismiss="modal">
                                            Batal
                                        </button>

                                        <button type="submit" class="btn btn-primary btn-sm"
                                            style="border-radius:8px; font-weight:600;">
                                            💾 Simpan
                                        </button>
                                    </div>

                                </form>

                            </div>
                        </div>
                    </div>


                    {{-- MODAL DELETE --}}
                    <div class="modal fade" id="delete{{ $r->id_ruangan }}" tabindex="-1">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content" style="border:none; border-radius:14px; overflow:hidden;">

                                {{-- HEADER --}}
                                <div style="background:linear-gradient(135deg,#dc2626,#ef4444); padding:16px 20px;">
                                    <h5 style="color:#fff; font-weight:700; margin:0;">
                                        🗑️ Hapus Ruangan
                                    </h5>
                                </div>

                                {{-- BODY --}}
                                <div class="modal-body text-center">

                                    <div style="
                    width:64px;
                    height:64px;
                    background:#fef2f2;
                    border-radius:50%;
                    display:flex;
                    align-items:center;
                    justify-content:center;
                    margin:0 auto 14px;
                    font-size:1.6rem;">
                                        ⚠️
                                    </div>

                                    <p style="font-size:0.92rem; color:#334155; line-height:1.6;">
                                        Apakah kamu yakin ingin menghapus ruangan<br>
                                        <strong>"{{ $r->nama_ruangan }}"</strong>?
                                    </p>

                                </div>

                                {{-- FOOTER --}}
                                <div style="padding:14px 20px; border-top:1px solid #f1f5f9; display:flex; justify-content:flex-end; gap:8px;">

                                    <button type="button" class="btn btn-light btn-sm" data-dismiss="modal">
                                        Batal
                                    </button>

                                    <form action="{{ route('admin.ruangan.destroy', $r->id_ruangan) }}" method="POST">
                                        @csrf
                                        @method('DELETE')

                                        <button type="submit"
                                            class="btn btn-danger btn-sm"
                                            style="border-radius:8px; font-weight:600;">
                                            🗑️ Ya, Hapus
                                        </button>
                                    </form>

                                </div>

                            </div>
                        </div>
                    </div>

                    @empty
                    <tr>
                        <td colspan="8" class="text-center">Tidak ada data</td>
                    </tr>
                    @endforelse

                </tbody>
            </table>

        </div>
    </div>

</div>

@endsection