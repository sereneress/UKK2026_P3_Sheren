@extends('layouts.admin')

@section('title', 'Riwayat Aspirasi')

@section('content')
<div class="row">
    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
        <div class="page-header">
            <h2 class="pageheader-title">Riwayat Aspirasi</h2>
            <p class="pageheader-text">Riwayat aspirasi yang telah selesai atau ditolak.</p>
            <div class="page-breadcrumb">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('guru.dashboard') }}" class="breadcrumb-link">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('guru.aspirasi.index') }}" class="breadcrumb-link">Aspirasi</a></li>
                        <li class="breadcrumb-item active">Riwayat</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-xl-12">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Riwayat Semua Aspirasi</h5>
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
                                <th class="border-0">Status Akhir</th>
                                <th class="border-0">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($histories ?? [] as $index => $aspirasi)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ Str::limit($aspirasi->judul, 40) }}</td>
                                <td><span class="badge badge-info">{{ $aspirasi->kategori->nama ?? '-' }}</span></td>
                                <td>{{ $aspirasi->user->name ?? '-' }}</td>
                                <td>{{ $aspirasi->updated_at->format('d-m-Y H:i') }}</td>
                                <td>
                                    <span class="badge badge-{{ $aspirasi->status === 'selesai' ? 'success' : 'danger' }}">
                                        {{ ucfirst($aspirasi->status) }}
                                    </span>
                                </td>
                                <td>
                                    <a href="{{ route('guru.aspirasi.show', $aspirasi->id) }}"
                                        class="btn btn-sm btn-outline-primary">
                                        <i class="fa fa-eye mr-1"></i>Detail
                                    </a>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="7" class="text-center text-muted py-4">Belum ada riwayat aspirasi.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            @if(isset($histories) && method_exists($histories, 'hasPages') && $histories->hasPages())
            <div class="card-footer">
                {{ $histories->links() }}
            </div>
            @endif
        </div>
    </div>
</div>
@endsection