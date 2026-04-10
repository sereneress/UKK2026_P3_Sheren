@extends('layouts.admin')

@section('title', 'Dashboard Guru')

@section('content')
<div class="row">
    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
        <div class="page-header">
            <h2 class="pageheader-title">Dashboard Guru</h2>
            <p class="pageheader-text">Selamat datang, {{ Auth::user()->name }}. Kelola aspirasi siswa di sini.</p>
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
                    <h5 class="text-muted">Menunggu Respons</h5>
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
                    <h5 class="text-muted">Sedang Diproses</h5>
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
        <div class="col-xl-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Aspirasi Terbaru</h5>
                    <a href="{{ route('guru.aspirasi.index') }}" class="btn btn-sm btn-outline-primary">
                        Lihat Semua
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
                                    <th class="border-0">Siswa</th>
                                    <th class="border-0">Tanggal</th>
                                    <th class="border-0">Status</th>
                                    <th class="border-0">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($recentAspirasi ?? [] as $index => $aspirasi)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ Str::limit($aspirasi->judul, 35) }}</td>
                                    <td>{{ $aspirasi->kategori->nama ?? '-' }}</td>
                                    <td>{{ $aspirasi->user->name ?? '-' }}</td>
                                    <td>{{ $aspirasi->created_at->format('d-m-Y') }}</td>
                                    <td>
                                        <span class="badge badge-{{ $aspirasi->status === 'selesai' ? 'success' : ($aspirasi->status === 'proses' ? 'warning' : 'secondary') }}">
                                            {{ ucfirst($aspirasi->status) }}
                                        </span>
                                    </td>
                                    <td>
                                        <a href="{{ route('guru.aspirasi.show', $aspirasi->id) }}"
                                            class="btn btn-sm btn-outline-primary">
                                            <i class="fa fa-eye"></i>
                                        </a>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="7" class="text-center text-muted py-4">Belum ada aspirasi masuk.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection