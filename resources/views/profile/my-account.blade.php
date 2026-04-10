@extends('layouts.admin')
@section('title', 'Profil Saya')
@section('content')
<div class="row">
    <div class="col-xl-12">
        <div class="page-header">
            <h2 class="pageheader-title">Profil Saya</h2>
            <p class="pageheader-text">Lihat dan kelola informasi akun Anda.</p>
            <div class="page-breadcrumb">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="#" class="breadcrumb-link">Dashboard</a></li>
                        <li class="breadcrumb-item active">Profil</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-xl-4 col-lg-4 col-md-12">
        <div class="card text-center">
            <div class="card-body py-4">
                <img src="{{ asset('assets/images/avatar-1.jpg') }}" alt="Avatar"
                    class="rounded-circle mb-3" style="width:100px;height:100px;object-fit:cover;">
                <h5 class="mb-1">{{ Auth::user()->name }}</h5>
                <p class="text-muted mb-2">{{ Auth::user()->email }}</p>
                <span class="badge badge-{{ Auth::user()->role === 'admin' ? 'danger' : (Auth::user()->role === 'guru' ? 'primary' : 'success') }} px-3 py-2">
                    {{ ucfirst(Auth::user()->role ?? 'User') }}
                </span>
                <div class="mt-3">
                    <small class="text-muted">Bergabung: {{ Auth::user()->created_at->format('d M Y') }}</small>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-8 col-lg-8 col-md-12">
        <div class="card mb-4">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Edit Informasi Akun</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('profile.update') }}" method="POST">
                    @csrf @method('PATCH')
                    <div class="form-group">
                        <label for="name">Nama Lengkap</label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror"
                            id="name" name="name" value="{{ old('name', Auth::user()->name) }}" required>
                        @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" class="form-control @error('email') is-invalid @enderror"
                            id="email" name="email" value="{{ old('email', Auth::user()->email) }}" required>
                        @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <button type="submit" class="btn btn-primary">
                        <i class="fa fa-save mr-2"></i>Simpan Perubahan
                    </button>
                </form>
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Ubah Password</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('password.update') }}" method="POST">
                    @csrf @method('PUT')
                    <div class="form-group">
                        <label for="current_password">Password Saat Ini</label>
                        <input type="password" class="form-control @error('current_password') is-invalid @enderror"
                            id="current_password" name="current_password" required>
                        @error('current_password')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="form-group">
                        <label for="password">Password Baru</label>
                        <input type="password" class="form-control @error('password') is-invalid @enderror"
                            id="password" name="password" required>
                        @error('password')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="form-group">
                        <label for="password_confirmation">Konfirmasi Password Baru</label>
                        <input type="password" class="form-control" id="password_confirmation"
                            name="password_confirmation" required>
                    </div>
                    <button type="submit" class="btn btn-warning">
                        <i class="fa fa-key mr-2"></i>Update Password
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection