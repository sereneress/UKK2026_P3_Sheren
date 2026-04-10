@extends('layouts.admin')

@section('title', 'Manajemen Sarana')

@section('content')
<div class="row">
    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
        <div class="page-header">
            <h2 class="pageheader-title">Manajemen Sarana</h2>
            <p class="pageheader-text">Kelola data sarana dan prasarana sekolah.</p>
            <div class="page-breadcrumb">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}" class="breadcrumb-link">Dashboard</a></li>
                        <li class="breadcrumb-item active">Sarana</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-xl-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Daftar Sarana</h5>
                <a href="{{ route('admin.sarana.create') }}" class="btn btn-primary btn-sm">
                    <i class="fa fa-plus mr-1"></i>Tambah Sarana
                </a>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table">
                        <thead class="bg-light">
                            <tr class="border-0">
                                <th class="border-0">#</th>
                                <th class="border-0">Nama Sarana</th>
                                <th class="border-0">Lokasi</th>
                                <th class="border-0">Kondisi</th>
                                <th class="border-0">Keterangan</th>
                                <th class="border-0">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($saranas ?? [] as $index => $sarana)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td><strong>{{ $sarana->nama }}</strong></td>
                                <td>{{ $sarana->lokasi ?? '-' }}</td>
                                <td>
                                    @php
                                        $kondisiClass = match(strtolower($sarana->kondisi ?? '')) {
                                            'baik'   => 'success',
                                            'rusak'  => 'danger',
                                            'sedang' => 'warning',
                                            default  => 'secondary',
                                        };
                                    @endphp
                                    <span class="badge badge-{{ $kondisiClass }}">{{ ucfirst($sarana->kondisi ?? '-') }}</span>
                                </td>
                                <td>{{ Str::limit($sarana->keterangan ?? '-', 50) }}</td>
                                <td>
                                    <a href="{{ route('admin.sarana.show', $sarana->id) }}"
                                        class="btn btn-sm btn-outline-info" title="Detail">
                                        <i class="fa fa-eye"></i>
                                    </a>
                                    <a href="{{ route('admin.sarana.edit', $sarana->id) }}"
                                        class="btn btn-sm btn-outline-primary" title="Edit">
                                        <i class="fa fa-edit"></i>
                                    </a>
                                    <form action="{{ route('admin.sarana.destroy', $sarana->id) }}" method="POST" class="d-inline"
                                        onsubmit="return confirm('Yakin ingin menghapus sarana ini?')">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger" title="Hapus">
                                            <i class="fa fa-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="text-center text-muted py-4">Belum ada data sarana.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            @if(isset($saranas) && method_exists($saranas, 'hasPages') && $saranas->hasPages())
            <div class="card-footer">
                {{ $saranas->links() }}
            </div>
            @endif
        </div>
    </div>
</div>
@endsection