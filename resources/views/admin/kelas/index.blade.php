@extends('layouts.admin')

@section('title', 'Manajemen Kelas')

@section('content')

<style>
    .kelas-header {
        background: linear-gradient(135deg, #1e3a5f 0%, #2d6a9f 100%);
        border-radius: 12px;
        padding: 24px 28px;
        margin-bottom: 24px;
        display: flex;
        justify-content: space-between;
    }

    .kelas-header h4 {
        color: #fff;
        margin: 0;
    }

    .kelas-header p {
        color: rgba(255, 255, 255, 0.7);
    }

    .card-form,
    .card-table {
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

    .btn-tambah {
        background: linear-gradient(135deg, #1e3a5f, #2d6a9f);
        color: #fff;
        border: none;
        border-radius: 8px;
        padding: 10px;
        width: 100%;
    }

    .table thead th {
        background: #f8fafc;
        font-size: 0.75rem;
    }

    .nama-kelas {
        font-weight: 600;
        color: #1e3a5f;
    }

    .aksi-group {
        display: flex;
        gap: 6px;
    }

    .btn-aksi {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 6px 12px;
        font-size: 0.75rem;
        font-weight: 600;
        border-radius: 7px;
        cursor: pointer;
        transition: 0.2s;
    }

    .btn-edit {
        background: #fffbeb;
        color: #d97706;
        border: 1px solid #fde68a;
    }

    .btn-hapus {
        background: #fef2f2;
        color: #dc2626;
        border: 1px solid #fecaca;
    }
</style>

<div class="kelas-header">
    <div>
        <h4>Manajemen Kelas</h4>
        <p>Kelola Data Kelas Siswa</p>
    </div>
</div>

@if(session('success'))
<div class="alert alert-success">{{ session('success') }}</div>
@endif

<div class="row">

    {{-- FORM --}}
    <div class="col-md-4">
        <div class="card card-form p-3">
            <form action="{{ route('admin.kelas.store') }}" method="POST">
                @csrf

                <div class="mb-3">
                    <label>Kelas</label>
                    <input type="text" name="nama_kelas"
                        class="form-control-custom"
                        placeholder="XI RPL" required>
                </div>

                {{-- 🔥 STEP 1: KODE --}}
                <div class="mb-3">
                    <label>Kode Jurusan</label>
                    <select id="kode_jurusan" class="form-control-custom">
                        <option value="">-- Pilih Kode --</option>
                        @foreach($jurusan as $j)
                        <option value="{{ $j->id_jurusan }}">
                            {{ $j->kode_jurusan }}
                        </option>
                        @endforeach
                    </select>
                </div>

                {{-- 🔥 STEP 2: NAMA --}}
                <div class="mb-3">
                    <label>Jurusan</label>
                    <select name="id_jurusan" id="nama_jurusan" class="form-control-custom" required>
                        <option value="">-- Pilih Jurusan --</option>
                        @foreach($jurusan as $j)
                        <option value="{{ $j->id_jurusan }}" data-kode="{{ $j->id_jurusan }}">
                            {{ $j->nama_jurusan }}
                        </option>
                        @endforeach
                    </select>
                </div>

                <button class="btn-tambah">Tambah</button>
            </form>
        </div>
    </div>

    {{-- TABLE --}}
    <div class="col-md-8">
        <div class="card card-table p-3">
            <table class="table">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Kelas</th>
                        <th>Kode</th>
                        <th>Jurusan</th>
                        <th>Aksi</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($kelas as $index => $k)
                    <tr>
                        <td>{{ $index + 1 }}</td>

                        <td>
                            <span class="nama-kelas">
                                {{ $k->nama_kelas }}
                            </span>
                        </td>

                        <td>
                            <b>{{ $k->jurusan->kode_jurusan ?? '-' }}</b>
                        </td>

                        <td>
                            {{ $k->jurusan->nama_jurusan ?? '-' }}
                        </td>

                        <td>
                            <div class="aksi-group">

                                <button class="btn-aksi btn-edit"
                                    data-toggle="modal"
                                    data-target="#edit{{ $k->id_kelas }}">
                                    ✏️ Edit
                                </button>

                                <button class="btn-aksi btn-hapus"
                                    data-toggle="modal"
                                    data-target="#delete{{ $k->id_kelas }}">
                                    🗑️ Hapus
                                </button>

                            </div>
                        </td>
                    </tr>

                    {{-- MODAL EDIT --}}
                    <div class="modal fade" id="edit{{ $k->id_kelas }}" tabindex="-1">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content" style="border:none; border-radius:14px; overflow:hidden;">

                                <form action="{{ route('admin.kelas.update', $k->id_kelas) }}" method="POST">
                                    @csrf
                                    @method('PUT')

                                    {{-- HEADER --}}
                                    <div style="padding:16px 20px; border-bottom:1px solid #f1f5f9;">
                                        <h5 style="margin:0; font-weight:700; color:#1e3a5f;">
                                            ✏️ Edit Kelas
                                        </h5>
                                    </div>

                                    {{-- BODY --}}
                                    <div class="modal-body">

                                        <div class="mb-3">
                                            <label style="font-size:0.75rem; font-weight:600; color:#64748b;">
                                                Nama Kelas
                                            </label>
                                            <input type="text" name="nama_kelas"
                                                value="{{ $k->nama_kelas }}"
                                                class="form-control"
                                                style="border-radius:8px;">
                                        </div>

                                        <div class="mb-2">
                                            <label style="font-size:0.75rem; font-weight:600; color:#64748b;">
                                                Jurusan
                                            </label>
                                            <select name="id_jurusan" class="form-control" style="border-radius:8px;">
                                                @foreach($jurusan as $j)
                                                <option value="{{ $j->id_jurusan }}"
                                                    {{ $k->id_jurusan == $j->id_jurusan ? 'selected' : '' }}>
                                                    {{ $j->kode_jurusan }} - {{ $j->nama_jurusan }}
                                                </option>
                                                @endforeach
                                            </select>
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
                    <div class="modal fade" id="delete{{ $k->id_kelas }}" tabindex="-1">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content" style="border:none; border-radius:14px; overflow:hidden;">

                                {{-- HEADER --}}
                                <div style="background:linear-gradient(135deg,#dc2626,#ef4444); padding:16px 20px;">
                                    <h5 style="color:#fff; font-weight:700; margin:0;">
                                        🗑️ Hapus Kelas
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
                                        Apakah kamu yakin ingin menghapus kelas<br>
                                        <strong>"{{ $k->nama_kelas }}"</strong>?
                                    </p>

                                    {{-- WARNING --}}
                                    @if(($k->siswa_count ?? 0) > 0)
                                    <div style="
                    background:#fef2f2;
                    border:1px solid #fecaca;
                    padding:12px;
                    border-radius:8px;
                    font-size:0.82rem;
                    color:#991b1b;
                    margin-top:10px;">
                                        ⚠️ Kelas ini masih dipakai <b>{{ $k->siswa_count }}</b> siswa
                                    </div>
                                    @endif

                                </div>

                                {{-- FOOTER --}}
                                <div style="padding:14px 20px; border-top:1px solid #f1f5f9; display:flex; justify-content:flex-end; gap:8px;">
                                    <button type="button" class="btn btn-light btn-sm" data-dismiss="modal">
                                        Batal
                                    </button>

                                    <form action="{{ route('admin.kelas.destroy', $k->id_kelas) }}" method="POST">
                                        @csrf
                                        @method('DELETE')

                                        <button type="submit" class="btn btn-danger btn-sm"
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
                        <td colspan="5" class="text-center">
                            Belum ada data
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>

{{-- 🔥 SCRIPT FILTER --}}
<script>
    const kodeSelect = document.getElementById('kode_jurusan');
    const namaSelect = document.getElementById('nama_jurusan');

    kodeSelect.addEventListener('change', function() {
        let selected = this.value;

        Array.from(namaSelect.options).forEach(opt => {
            if (opt.value === "" || opt.dataset.kode === selected) {
                opt.style.display = 'block';
            } else {
                opt.style.display = 'none';
            }
        });

        namaSelect.value = "";
    });
</script>

@endsection