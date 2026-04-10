@extends('layouts.admin')

@section('title', 'Status Aspirasi')

@section('content')
<div class="row">
    <div class="col-xl-12">
        <div class="page-header">
            <h2 class="pageheader-title">Status Aspirasi</h2>
            <p class="pageheader-text">Pantau aspirasi yang sedang berjalan.</p>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-12">

        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Aspirasi Aktif</h5>
                <small class="text-muted">Menunggu & Diproses</small>
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
                                <th>Tanggal</th>
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
                                <td>{{ $item->created_at->format('d/m/Y H:i') }}</td>
                                <td>{{ $item->kategori->nama_kategori ?? '-' }}</td>
                                <td>{{ \Illuminate\Support\Str::limit($item->lokasi, 30) }}</td>

                                {{-- STATUS --}}
                                <td>
                                    @if($item->status == 'Menunggu')
                                        <span class="badge badge-warning">
                                            Menunggu
                                        </span>
                                    @else
                                        <span class="badge badge-info">
                                            Diproses
                                        </span>
                                    @endif
                                </td>

                                {{-- AKSI --}}
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
                                        <i class="fa fa-check-circle" style="font-size:40px;color:#28a745;"></i>
                                        <p class="mt-2 text-muted">Semua aspirasi sudah selesai</p>

                                        <a href="{{ route('siswa.aspirasi.history') }}"
                                            class="btn btn-info btn-sm">
                                            History
                                        </a>

                                        <a href="{{ route('siswa.aspirasi.create') }}"
                                            class="btn btn-primary btn-sm">
                                            Buat Baru
                                        </a>
                                    </div>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                {{-- MOBILE CARD --}}
                <div class="d-md-none">
                    @forelse($aspirasi as $item)
                    <div class="card mb-3">
                        <div class="card-body">

                            <div class="d-flex justify-content-between mb-2">
                                <small class="text-muted">
                                    {{ $item->created_at->format('d/m/Y H:i') }}
                                </small>

                                @if($item->status == 'Menunggu')
                                    <span class="badge badge-warning">Menunggu</span>
                                @else
                                    <span class="badge badge-info">Diproses</span>
                                @endif
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
                        <i class="fa fa-check-circle" style="font-size:40px;color:#28a745;"></i>
                        <p class="mt-2 text-muted">Semua aspirasi sudah selesai</p>

                        <a href="{{ route('siswa.aspirasi.history') }}" class="btn btn-info btn-sm">
                            History
                        </a>

                        <a href="{{ route('siswa.aspirasi.create') }}" class="btn btn-primary btn-sm">
                            Buat Baru
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