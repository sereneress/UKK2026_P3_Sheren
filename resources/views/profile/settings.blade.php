@extends('layouts.admin')
@section('title', 'Pengaturan')
@section('content')
<div class="row">
    <div class="col-xl-12">
        <div class="page-header">
            <h2 class="pageheader-title">Pengaturan Akun</h2>
            <p class="pageheader-text">Kelola preferensi dan keamanan akun Anda.</p>
            <div class="page-breadcrumb">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="#" class="breadcrumb-link">Dashboard</a></li>
                        <li class="breadcrumb-item active">Pengaturan</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-xl-8 col-lg-8 col-md-12">
        {{-- Notifikasi --}}
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="mb-0"><i class="fa fa-bell mr-2 text-primary"></i>Preferensi Notifikasi</h5>
            </div>
            <div class="card-body">
                <div class="custom-control custom-switch mb-3">
                    <input type="checkbox" class="custom-control-input" id="notif_email" checked>
                    <label class="custom-control-label" for="notif_email">
                        Notifikasi Email
                        <small class="d-block text-muted">Terima pemberitahuan melalui email</small>
                    </label>
                </div>
                <div class="custom-control custom-switch mb-3">
                    <input type="checkbox" class="custom-control-input" id="notif_status" checked>
                    <label class="custom-control-label" for="notif_status">
                        Update Status Aspirasi
                        <small class="d-block text-muted">Dapatkan notifikasi ketika status aspirasi berubah</small>
                    </label>
                </div>
                <div class="custom-control custom-switch">
                    <input type="checkbox" class="custom-control-input" id="notif_tanggapan">
                    <label class="custom-control-label" for="notif_tanggapan">
                        Notifikasi Tanggapan
                        <small class="d-block text-muted">Notifikasi ketika ada tanggapan dari guru</small>
                    </label>
                </div>
            </div>
        </div>

        {{-- Keamanan --}}
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="mb-0"><i class="fa fa-shield-alt mr-2 text-success"></i>Keamanan</h5>
            </div>
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center py-2 border-bottom">
                    <div>
                        <h6 class="mb-0">Verifikasi Dua Langkah</h6>
                        <small class="text-muted">Tambahkan lapisan keamanan ekstra pada akun</small>
                    </div>
                    <span class="badge badge-secondary">Nonaktif</span>
                </div>
                <div class="d-flex justify-content-between align-items-center py-2">
                    <div>
                        <h6 class="mb-0">Sesi Aktif</h6>
                        <small class="text-muted">Kelola perangkat yang sedang login</small>
                    </div>
                    <a href="#" class="btn btn-sm btn-outline-danger">Hapus Semua Sesi</a>
                </div>
            </div>
        </div>

        {{-- Hapus Akun --}}
        <div class="card border-danger">
            <div class="card-header bg-danger text-white">
                <h5 class="mb-0"><i class="fa fa-exclamation-triangle mr-2"></i>Zona Berbahaya</h5>
            </div>
            <div class="card-body">
                <h6>Hapus Akun</h6>
                <p class="text-muted small">Setelah akun dihapus, semua data tidak dapat dipulihkan. Harap pikirkan dengan matang.</p>
                <button type="button" class="btn btn-outline-danger btn-sm" data-toggle="modal" data-target="#deleteAccountModal">
                    <i class="fa fa-trash mr-2"></i>Hapus Akun Saya
                </button>
            </div>
        </div>
    </div>

    <div class="col-xl-4 col-lg-4 col-md-12">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Info Akun</h5>
            </div>
            <div class="card-body">
                <table class="table table-borderless table-sm">
                    <tr>
                        <th class="text-muted small">Nama</th>
                        <td class="small">{{ Auth::user()->name }}</td>
                    </tr>
                    <tr>
                        <th class="text-muted small">Email</th>
                        <td class="small">{{ Auth::user()->email }}</td>
                    </tr>
                    <tr>
                        <th class="text-muted small">Role</th>
                        <td class="small">{{ ucfirst(Auth::user()->role ?? '-') }}</td>
                    </tr>
                    <tr>
                        <th class="text-muted small">Bergabung</th>
                        <td class="small">{{ Auth::user()->created_at->format('d M Y') }}</td>
                    </tr>
                </table>
                <a href="{{ route('profile.edit') }}" class="btn btn-primary btn-block btn-sm">
                    <i class="fa fa-user-edit mr-2"></i>Edit Profil
                </a>
            </div>
        </div>
    </div>
</div>

{{-- Delete Account Modal --}}
<div class="modal fade" id="deleteAccountModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title">Konfirmasi Hapus Akun</h5>
                <button type="button" class="close text-white" data-dismiss="modal"><span>&times;</span></button>
            </div>
            <div class="modal-body text-center py-4">
                <i class="fa fa-exclamation-triangle fa-3x text-danger mb-3"></i>
                <p>Apakah Anda yakin ingin menghapus akun ini? Semua data akan hilang permanen.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                <form action="{{ route('profile.destroy') }}" method="POST" class="d-inline">
                    @csrf @method('DELETE')
                    <button type="submit" class="btn btn-danger">Ya, Hapus Akun</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection