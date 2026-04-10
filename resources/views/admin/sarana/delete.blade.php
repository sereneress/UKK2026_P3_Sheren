@extends('layouts.admin')

@section('title', 'Hapus Sarana')

@section('content')
<div class="row">
    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
        <div class="page-header">
            <h2 class="pageheader-title">Hapus Sarana</h2>
            <div class="page-breadcrumb">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}" class="breadcrumb-link">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('admin.sarana.index') }}" class="breadcrumb-link">Sarana</a></li>
                        <li class="breadcrumb-item active">Hapus</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</div>

<div class="row justify-content-center">
    <div class="col-xl-6 col-lg-6 col-md-8 col-sm-12 col-12">
        <div class="card border-danger">
            <div class="card-header bg-danger text-white">
                <h5 class="mb-0"><i class="fa fa-exclamation-triangle mr-2"></i>Konfirmasi Penghapusan</h5>
            </div>
            <div class="card-body text-center py-4">
                <i class="fas fa-trash-alt fa-4x text-danger mb-3"></i>
                <h5>Apakah Anda yakin ingin menghapus sarana ini?</h5>
                <p class="text-muted">Sarana: <strong>{{ $sarana->nama }}</strong></p>
                <p class="text-danger small">Tindakan ini tidak dapat dibatalkan.</p>

                <div class="d-flex justify-content-center mt-4">
                    <a href="{{ route('admin.sarana.index') }}" class="btn btn-secondary mr-3">
                        <i class="fa fa-times mr-2"></i>Batal
                    </a>
                    <form action="{{ route('admin.sarana.destroy', $sarana->id) }}" method="POST">
                        @csrf @method('DELETE')
                        <button type="submit" class="btn btn-danger">
                            <i class="fa fa-trash mr-2"></i>Ya, Hapus
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection