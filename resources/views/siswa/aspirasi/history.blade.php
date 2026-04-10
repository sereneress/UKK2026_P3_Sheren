@extends('layouts.admin')

@section('title', 'Riwayat Aspirasi')

@section('content')
<div class="row">
    <div class="col-xl-12">
        <div class="page-header">
            <h2 class="pageheader-title">Riwayat Aspirasi</h2>
            <p class="pageheader-text">Aspirasi yang sudah selesai ditangani.</p>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-12">

        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">History Aspirasi</h5>
                <small class="text-muted">Status: Selesai</small>
            </div>

            <div class="card-body">

                {{-- SUCCESS --}}
                @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
                @endif

                {{-- DESKTOP TABLE --}}
                <div class="table-responsive d-none d-md-block">
                    <table class="table table-bordered table-hover">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Tanggal Selesai</th>
                                <th>Kategori</th>
                                <th>Lokasi</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($aspirasi as $index => $item)
                            <tr>
                                <td>{{ $index + $aspirasi->firstItem() }}</td>
                                <td>{{ $item->updated_at->format('d/m/Y H:i') }}</td>
                                <td>{{ $item->kategori->nama_kategori ?? '-' }}</td>
                                <td>{{ \Illuminate\Support\Str::limit($item->lokasi, 40) }}</td>

                                <td>
                                    <span class="badge badge-success">Selesai</span>
                                </td>

                                <td>
                                    <a href="{{ route('siswa.aspirasi.detail', $item->id_aspirasi) }}"
                                        class="btn btn-info btn-sm">
                                        <i class="fa fa-eye"></i> Detail
                                    </a>
                                </td>
                            </tr>

                            @empty
                            <tr>
                                <td colspan="6" class="text-center">
                                    <div class="py-4">
                                        <i class="fa fa-history" style="font-size:40px;color:#ccc;"></i>
                                        <p class="mt-2 text-muted">Belum ada history aspirasi</p>

                                        <a href="{{ route('siswa.aspirasi.create') }}"
                                            class="btn btn-primary btn-sm">
                                            Buat Aspirasi
                                        </a>
                                    </div>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                {{-- MOBILE VIEW --}}
                <div class="d-md-none">
                    @forelse($aspirasi as $item)
                    <div class="card mb-3">
                        <div class="card-body">

                            <div class="d-flex justify-content-between mb-2">
                                <small class="text-muted">
                                    Selesai: {{ $item->updated_at->format('d/m/Y H:i') }}
                                </small>

                                <span class="badge badge-success">Selesai</span>
                            </div>

                            <p><strong>Kategori:</strong> {{ $item->kategori->nama_kategori ?? '-' }}</p>
                            <p><strong>Lokasi:</strong> {{ $item->lokasi }}</p>

                            <a href="{{ route('siswa.aspirasi.detail', $item->id_aspirasi) }}"
                                class="btn btn-info btn-sm btn-block">
                                Lihat Detail
                            </a>

                        </div>
                    </div>

                    @empty
                    <div class="text-center py-4">
                        <i class="fa fa-history" style="font-size:40px;color:#ccc;"></i>
                        <p class="mt-2 text-muted">Belum ada history aspirasi</p>

                        <a href="{{ route('siswa.aspirasi.create') }}"
                            class="btn btn-primary">
                            Buat Aspirasi
                        </a>
                    </div>
                    @endforelse
                </div>

                {{-- PAGINATION --}}
                <div class="d-flex justify-content-center mt-3">
                    {{ $aspirasi->links() }}
                </div>

            </div>
        </div>

    </div>
</div>
@endsection