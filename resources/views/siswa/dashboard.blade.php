@extends('layouts.siswa')

@section('title', 'Dashboard Siswa')

@section('content')
<div class="row">
    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
        <div class="page-header">
            <h2 class="pageheader-title">Dashboard Siswa</h2>
            <p class="pageheader-text">Halo, {{ Auth::user()->name }}! Sampaikan aspirasimu di sini.</p>
            <div class="page-breadcrumb">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="#" class="breadcrumb-link">Home</a></li>
                        <li class="breadcrumb-item active">Dashboard</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</div>

<div class="ecommerce-widget">
    <div class="row">
        <div class="col-xl-3 col-lg-6 col-md-6 col-sm-12 col-12">
            <div class="card border-3 border-top border-top-primary">
                <div class="card-body">
                    <h5 class="text-muted">Total Aspirasi</h5>
                    <div class="metric-value d-inline-block">
                        <h1 class="mb-1">{{ $totalAspirasi ?? 0 }}</h1>
                    </div>
                    <div class="metric-label d-inline-block float-right">
                        <span class="icon-circle-small icon-box-xs text-primary bg-primary-light">
                            <i class="fa fa-fw fa-comments"></i>
                        </span>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-lg-6 col-md-6 col-sm-12 col-12">
            <div class="card border-3 border-top border-top-warning">
                <div class="card-body">
                    <h5 class="text-muted">Menunggu</h5>
                    <div class="metric-value d-inline-block">
                        <h1 class="mb-1">{{ $aspirasiPending ?? 0 }}</h1>
                    </div>
                    <div class="metric-label d-inline-block float-right">
                        <span class="icon-circle-small icon-box-xs text-warning bg-warning-light">
                            <i class="fa fa-fw fa-clock"></i>
                        </span>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-lg-6 col-md-6 col-sm-12 col-12">
            <div class="card border-3 border-top border-top-info">
                <div class="card-body">
                    <h5 class="text-muted">Diproses</h5>
                    <div class="metric-value d-inline-block">
                        <h1 class="mb-1">{{ $aspirasiProses ?? 0 }}</h1>
                    </div>
                    <div class="metric-label d-inline-block float-right">
                        <span class="icon-circle-small icon-box-xs text-info bg-info-light">
                            <i class="fa fa-fw fa-spinner"></i>
                        </span>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-lg-6 col-md-6 col-sm-12 col-12">
            <div class="card border-3 border-top border-top-success">
                <div class="card-body">
                    <h5 class="text-muted">Selesai</h5>
                    <div class="metric-value d-inline-block">
                        <h1 class="mb-1">{{ $aspirasiSelesai ?? 0 }}</h1>
                    </div>
                    <div class="metric-label d-inline-block float-right">
                        <span class="icon-circle-small icon-box-xs text-success bg-success-light">
                            <i class="fa fa-fw fa-check-circle"></i>
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-xl-8 col-lg-8 col-md-12 col-sm-12 col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Aspirasi Saya</h5>
                    <a href="{{ route('siswa.aspirasi.create') }}" class="btn btn-primary btn-sm">
                        <i class="fa fa-plus mr-1"></i>Buat Aspirasi
                    </a>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table">
                            <thead class="bg-light">
                                <tr class="border-0">
                                    <th class="border-0">#</th>
                                    <th class="border-0">Judul</th>
                                    <th class="border-0">Kategori</th>
                                    <th class="border-0">Tanggal</th>
                                    <th class="border-0">Status</th>
                                    <th class="border-0">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($myAspirasi ?? [] as $index => $aspirasi)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ Str::limit($aspirasi->judul, 35) }}</td>
                                    <td>{{ $aspirasi->kategori->nama ?? '-' }}</td>
                                    <td>{{ $aspirasi->created_at->format('d-m-Y') }}</td>
                                    <td>
                                        <span class="badge badge-{{ $aspirasi->status === 'selesai' ? 'success' : ($aspirasi->status === 'proses' ? 'warning' : 'secondary') }}">
                                            {{ ucfirst($aspirasi->status) }}
                                        </span>
                                    </td>
                                    <td>
                                        <a href="{{ route('siswa.aspirasi.show', $aspirasi->id) }}"
                                            class="btn btn-sm btn-outline-primary">
                                            <i class="fa fa-eye"></i>
                                        </a>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="6" class="text-center text-muted py-4">
                                        Belum ada aspirasi. <a href="{{ route('siswa.aspirasi.create') }}">Buat sekarang</a>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-4 col-lg-4 col-md-12 col-sm-12 col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Aksi Cepat</h5>
                </div>
                <div class="card-body">
                    <a href="{{ route('siswa.aspirasi.create') }}" class="btn btn-primary btn-block mb-2">
                        <i class="fa fa-plus mr-2"></i>Buat Aspirasi Baru
                    </a>
                    <a href="{{ route('siswa.aspirasi.history') }}" class="btn btn-outline-secondary btn-block mb-2">
                        <i class="fa fa-history mr-2"></i>Riwayat Aspirasi
                    </a>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection