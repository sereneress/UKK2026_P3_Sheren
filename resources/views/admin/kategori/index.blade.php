@extends('layouts.admin')

@section('title', 'Manajemen Kategori')

@section('content')

<style>
    .page-header {
        background: linear-gradient(135deg, #1e3a5f 0%, #2d6a9f 100%);
        border-radius: 12px;
        padding: 24px 28px;
        margin-bottom: 24px;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .page-header h4 {
        color: #fff;
        font-weight: 700;
        margin: 0;
        font-size: 1.3rem;
        letter-spacing: 0.3px;
    }

    .page-header p {
        color: rgba(255, 255, 255, 0.7);
        margin: 4px 0 0;
        font-size: 0.85rem;
    }

    .page-header .icon-box {
        background: rgba(255, 255, 255, 0.15);
        border-radius: 50%;
        width: 52px;
        height: 52px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
        color: #fff;
    }

    /* ALERT */
    .alert-floating {
        border: none;
        border-radius: 10px;
        padding: 14px 20px;
        font-size: 0.875rem;
        font-weight: 500;
        display: flex;
        align-items: center;
        gap: 10px;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
        animation: slideDown 0.3s ease;
    }

    .alert-floating.alert-success {
        background: #f0fdf4;
        color: #166534;
        border-left: 4px solid #22c55e;
    }

    .alert-floating.alert-danger {
        background: #fef2f2;
        color: #991b1b;
        border-left: 4px solid #ef4444;
    }

    @keyframes slideDown {
        from {
            opacity: 0;
            transform: translateY(-10px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    /* CARD FORM */
    .card-form {
        border: none;
        border-radius: 12px;
        box-shadow: 0 2px 12px rgba(0, 0, 0, 0.06);
    }

    .card-form .card-header {
        background: #fff;
        border-bottom: 2px solid #f1f5f9;
        border-radius: 12px 12px 0 0 !important;
        padding: 18px 22px;
    }

    .card-form .card-header h5 {
        font-weight: 700;
        font-size: 1rem;
        color: #1e3a5f;
        margin: 0;
    }

    .card-form .card-body {
        padding: 22px;
    }

    .form-label-custom {
        font-size: 0.82rem;
        font-weight: 600;
        color: #64748b;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin-bottom: 6px;
        display: block;
    }

    .form-control-custom {
        border-radius: 8px;
        border: 1.5px solid #e2e8f0;
        font-size: 0.9rem;
        padding: 9px 13px;
        transition: border-color 0.2s, box-shadow 0.2s;
        width: 100%;
    }

    .form-control-custom:focus {
        border-color: #2d6a9f;
        box-shadow: 0 0 0 3px rgba(45, 106, 159, 0.1);
        outline: none;
    }

    .form-control-custom.is-invalid {
        border-color: #ef4444;
    }

    .btn-tambah {
        background: linear-gradient(135deg, #1e3a5f, #2d6a9f);
        color: #fff;
        border: none;
        border-radius: 8px;
        padding: 10px 20px;
        font-weight: 600;
        font-size: 0.88rem;
        width: 100%;
        transition: opacity 0.2s, transform 0.1s;
        cursor: pointer;
    }

    .btn-tambah:hover {
        opacity: 0.9;
        transform: translateY(-1px);
    }

    /* CARD TABLE */
    .card-table {
        border: none;
        border-radius: 12px;
        box-shadow: 0 2px 12px rgba(0, 0, 0, 0.06);
        overflow: hidden;
    }

    .card-table .card-header {
        background: #fff;
        border-bottom: 2px solid #f1f5f9;
        padding: 18px 22px;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .card-table .card-header h5 {
        font-weight: 700;
        font-size: 1rem;
        color: #1e3a5f;
        margin: 0;
    }

    .total-badge {
        background: #e0f0ff;
        color: #1e3a5f;
        font-size: 0.78rem;
        font-weight: 700;
        padding: 4px 12px;
        border-radius: 20px;
    }

    .table thead th {
        background: #f8fafc;
        color: #64748b;
        font-size: 0.75rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.6px;
        border: none;
        padding: 12px 16px;
    }

    .table tbody td {
        padding: 14px 16px;
        vertical-align: middle;
        border-top: 1px solid #f1f5f9;
        font-size: 0.88rem;
        color: #334155;
    }

    .table tbody tr:hover td {
        background: #f8fafc;
    }

    .nama-item {
        font-weight: 600;
        color: #1e3a5f;
    }

    .badge-aspirasi {
        background: #dbeafe;
        color: #1d4ed8;
        font-size: 0.75rem;
        font-weight: 700;
        padding: 4px 12px;
        border-radius: 20px;
        display: inline-block;
    }

    .badge-aspirasi.empty {
        background: #f1f5f9;
        color: #94a3b8;
    }

    /* ACTION BUTTONS */
    .btn-edit {
        background: #fffbeb;
        color: #d97706;
        border: 1.5px solid #fde68a;
        border-radius: 7px;
        padding: 5px 12px;
        font-size: 0.8rem;
        font-weight: 600;
        transition: all 0.15s;
        cursor: pointer;
    }

    .btn-edit:hover {
        background: #fef3c7;
        color: #b45309;
    }

    .btn-hapus {
        background: #fef2f2;
        color: #dc2626;
        border: 1.5px solid #fecaca;
        border-radius: 7px;
        padding: 5px 12px;
        font-size: 0.8rem;
        font-weight: 600;
        transition: all 0.15s;
        cursor: pointer;
    }

    .btn-hapus:hover {
        background: #fee2e2;
        color: #b91c1c;
    }

    /* MODAL */
    .modal-content {
        border: none;
        border-radius: 14px;
        box-shadow: 0 20px 60px rgba(0, 0, 0, 0.15);
        overflow: hidden;
    }

    .modal-header {
        border-bottom: 1px solid #f1f5f9;
        padding: 18px 22px;
    }

    .modal-header h5 {
        font-weight: 700;
        font-size: 1rem;
        color: #1e3a5f;
        margin: 0;
    }

    .modal-body {
        padding: 22px;
    }

    .modal-footer {
        border-top: 1px solid #f1f5f9;
        padding: 14px 22px;
    }

    .modal-delete-header {
        background: linear-gradient(135deg, #dc2626, #ef4444);
        border-bottom: none;
        padding: 18px 22px;
    }

    .modal-delete-header h5 {
        color: #fff;
        margin: 0;
        font-weight: 700;
        font-size: 1rem;
    }

    .modal-delete-header .btn-close {
        filter: invert(1) brightness(2);
    }

    .delete-icon {
        width: 64px;
        height: 64px;
        background: #fef2f2;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 16px;
        font-size: 1.8rem;
    }

    .delete-text {
        text-align: center;
        color: #334155;
        font-size: 0.92rem;
        line-height: 1.6;
    }

    .warn-box {
        display: flex;
        align-items: center;
        gap: 8px;
        padding: 12px 14px;
        border-radius: 8px;
        font-size: 0.84rem;
        margin-top: 14px;
    }

    .warn-box.yellow {
        background: #fffbeb;
        border: 1px solid #fde68a;
        color: #92400e;
    }

    .warn-box.red {
        background: #fef2f2;
        border: 1px solid #fecaca;
        color: #991b1b;
    }

    .empty-state {
        text-align: center;
        padding: 52px 20px;
        color: #94a3b8;
    }

    .empty-state .empty-icon {
        font-size: 2.8rem;
        margin-bottom: 12px;
        display: block;
        opacity: 0.5;
    }

    .empty-state p {
        font-size: 0.88rem;
        margin: 0;
    }
</style>

{{-- PAGE HEADER --}}
<div class="page-header">
    <div>
        <h4><i class="ph ph-tag mr-2"></i>Manajemen Kategori</h4>
        <p>Kelola kategori pengaduan yang tersedia</p>
    </div>
    <div class="icon-box">
        <i class="ph ph-tag"></i>
    </div>
</div>

{{-- ALERT SUCCESS --}}
@if(session('success'))
<div class="alert-floating alert-success alert mb-4" role="alert">
    <i class="ph ph-check-circle" style="font-size:1.2rem; flex-shrink:0;"></i>
    <span>{{ session('success') }}</span>
    <button type="button" class="close ml-auto" data-dismiss="alert"
        style="background:none;border:none;font-size:1.1rem;color:#166534;line-height:1;padding:0;cursor:pointer;">&times;</button>
</div>
@endif

{{-- ALERT ERROR --}}
@if($errors->any())
<div class="alert-floating alert-danger alert mb-4" role="alert">
    <i class="ph ph-warning-circle" style="font-size:1.2rem; flex-shrink:0;"></i>
    <div>
        @foreach($errors->all() as $error)
        <div>{{ $error }}</div>
        @endforeach
    </div>
    <button type="button" class="close ml-auto" data-dismiss="alert"
        style="background:none;border:none;font-size:1.1rem;color:#991b1b;line-height:1;padding:0;cursor:pointer;">&times;</button>
</div>
@endif

<div class="row">

    {{-- FORM TAMBAH --}}
    <div class="col-xl-4 mb-4">
        <div class="card card-form h-100">
            <div class="card-header">
                <h5><i class="ph ph-plus-circle mr-1"></i> Tambah Kategori Baru</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.kategori.store') }}" method="POST">
                    @csrf

                    <div class="mb-3">
                        <label class="form-label-custom">Nama Kategori</label>
                        <input type="text" name="nama_kategori"
                            class="form-control-custom @error('nama_kategori') is-invalid @enderror"
                            value="{{ old('nama_kategori') }}"
                            placeholder="Contoh: Fasilitas, Kebersihan..."
                            required>
                        @error('nama_kategori')
                        <div style="color:#ef4444;font-size:0.8rem;margin-top:4px;">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label class="form-label-custom">Deskripsi <span style="color:#94a3b8;text-transform:none;font-weight:400;">(opsional)</span></label>
                        <textarea name="deskripsi"
                            class="form-control-custom"
                            rows="3"
                            placeholder="Keterangan singkat tentang kategori ini...">{{ old('deskripsi') }}</textarea>
                    </div>

                    <button type="submit" class="btn-tambah">
                        <i class="ph ph-plus mr-1"></i> Tambah Kategori
                    </button>
                </form>
            </div>
        </div>
    </div>

    {{-- TABLE --}}
    <div class="col-xl-8 mb-4">
        <div class="card card-table">
            <div class="card-header">
                <h5><i class="ph ph-list-bullets mr-1"></i> Daftar Kategori</h5>
                <span class="total-badge">Total: {{ $kategoris->count() }} kategori</span>
            </div>

            <div class="card-body p-0">
                <table class="table mb-0">
                    <thead>
                        <tr>
                            <th style="width:5%">No</th>
                            <th>Nama Kategori</th>
                            <th>Deskripsi</th>
                            <th style="width:16%">Aspirasi</th>
                            <th style="width:18%">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($kategoris as $index => $kategori)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td><span class="nama-item">{{ $kategori->nama_kategori }}</span></td>
                            <td class="text-muted" style="font-size:0.85rem;">
                                {{ $kategori->deskripsi ? Str::limit($kategori->deskripsi, 50) : '-' }}
                            </td>
                            <td>
                                <span class="badge-aspirasi {{ ($kategori->aspirasi_count ?? 0) == 0 ? 'empty' : '' }}">
                                    {{ $kategori->aspirasi_count ?? 0 }} aspirasi
                                </span>
                            </td>
                            <td>
                                <button class="btn-aksi btn-edit"
                                    data-toggle="modal"
                                    data-target="#editModal{{ $kategori->id_kategori }}">
                                    ✏️ Edit
                                </button>
                                <button class="btn-aksi btn-hapus"
                                    data-toggle="modal"
                                    data-target="#deleteModal{{ $kategori->id_kategori }}">
                                    🗑️ Hapus
                                </button>
                            </td>
                        </tr>

                        {{-- MODAL EDIT --}}
                        <div class="modal fade" id="editModal{{ $kategori->id_kategori }}" tabindex="-1">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content" style="border:none; border-radius:14px; overflow:hidden;">

                                    <form action="{{ route('admin.kategori.update', $kategori->id_kategori) }}" method="POST">
                                        @csrf
                                        @method('PUT')

                                        {{-- HEADER --}}
                                        <div style="padding:16px 20px; border-bottom:1px solid #f1f5f9;">
                                            <h5 style="margin:0; font-weight:700; color:#1e3a5f;">
                                                ✏️ Edit Kategori
                                            </h5>
                                        </div>

                                        {{-- BODY --}}
                                        <div class="modal-body">

                                            <div class="mb-3">
                                                <label style="font-size:0.75rem; font-weight:600; color:#64748b;">
                                                    Nama Kategori
                                                </label>
                                                <input type="text"
                                                    name="nama_kategori"
                                                    value="{{ $kategori->nama_kategori }}"
                                                    class="form-control"
                                                    style="border-radius:8px;"
                                                    required>
                                            </div>

                                            <div class="mb-2">
                                                <label style="font-size:0.75rem; font-weight:600; color:#64748b;">
                                                    Deskripsi
                                                </label>
                                                <textarea name="deskripsi"
                                                    class="form-control"
                                                    rows="3"
                                                    style="border-radius:8px;">{{ $kategori->deskripsi }}</textarea>
                                            </div>

                                            @if(($kategori->aspirasi_count ?? 0) > 0)
                                            <div style="
                        background:#fffbeb;
                        border:1px solid #fde68a;
                        padding:12px;
                        border-radius:8px;
                        font-size:0.82rem;
                        color:#92400e;
                        margin-top:10px;">
                                                ⚠️ Kategori ini dipakai di <b>{{ $kategori->aspirasi_count }}</b> aspirasi
                                            </div>
                                            @endif

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
                        <div class="modal fade" id="deleteModal{{ $kategori->id_kategori }}" tabindex="-1">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content" style="border:none; border-radius:14px; overflow:hidden;">

                                    {{-- HEADER --}}
                                    <div style="background:linear-gradient(135deg,#dc2626,#ef4444); padding:16px 20px;">
                                        <h5 style="color:#fff; font-weight:700; margin:0;">
                                            🗑️ Hapus Kategori
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
                                            Apakah kamu yakin ingin menghapus kategori<br>
                                            <strong>"{{ $kategori->nama_kategori }}"</strong>?
                                        </p>

                                        @if(($kategori->aspirasi_count ?? 0) > 0)
                                        <div style="
                    background:#fef2f2;
                    border:1px solid #fecaca;
                    padding:12px;
                    border-radius:8px;
                    font-size:0.82rem;
                    color:#991b1b;
                    margin-top:10px;">
                                            ⚠️ Ada <b>{{ $kategori->aspirasi_count }}</b> aspirasi yang memakai kategori ini
                                        </div>
                                        @endif

                                    </div>

                                    {{-- FOOTER --}}
                                    <div style="padding:14px 20px; border-top:1px solid #f1f5f9; display:flex; justify-content:flex-end; gap:8px;">

                                        <button type="button" class="btn btn-light btn-sm" data-dismiss="modal">
                                            Batal
                                        </button>

                                        <form action="{{ route('admin.kategori.destroy', $kategori->id_kategori) }}" method="POST">
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
                            <td colspan="5">
                                <div class="empty-state">
                                    <i class="ph ph-tag empty-icon"></i>
                                    <p>Belum ada data kategori.<br>Tambahkan kategori baru melalui form di sebelah kiri.</p>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>

<script>
    setTimeout(() => {
        document.querySelectorAll('.alert-floating').forEach(el => {
            el.style.transition = 'opacity 0.5s ease';
            el.style.opacity = '0';
            setTimeout(() => el.remove(), 500);
        });
    }, 4000);
</script>

@endsection