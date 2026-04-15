@extends('layouts.siswa')

@section('title', 'Data Aspirasi')

@section('content')

<style>
    .page-header-custom {
        background: linear-gradient(135deg, #1e3a5f 0%, #2d6a9f 100%);
        border-radius: 12px;
        padding: 24px 28px;
        margin-bottom: 24px;
    }

    .page-header-custom h4 {
        color: #fff;
        margin: 0;
    }

    .page-header-custom p {
        color: rgba(255, 255, 255, 0.7);
        margin: 0;
        font-size: 13px;
    }

    .card-custom {
        border: none;
        border-radius: 12px;
        box-shadow: 0 2px 12px rgba(0, 0, 0, 0.06);
    }

    .form-control-custom {
        border-radius: 8px;
        border: 1.5px solid #e2e8f0;
        padding: 8px 12px;
        font-size: 13px;
    }

    .btn-filter {
        background: linear-gradient(135deg, #1e3a5f, #2d6a9f);
        color: #fff;
        border: none;
        border-radius: 8px;
        padding: 8px;
        font-weight: 500;
    }

    .table thead th {
        font-size: 12px;
        color: #6c757d;
        background: #f8fafc;
        border-bottom: 1px solid #e5e7eb;
    }

    .table tbody td {
        font-size: 13px;
        vertical-align: middle;
    }

    .btn-action {
        font-size: 12px;
        border-radius: 6px;
        padding: 5px 10px;
    }

    .btn-detail {
        background: #eff6ff;
        color: #1d4ed8;
        border: none;
    }

    .btn-delete {
        background: #fef2f2;
        color: #dc2626;
        border: none;
    }

    .btn-detail:hover {
        background: #dbeafe;
    }

    .btn-delete:hover {
        background: #fee2e2;
    }

    .img-thumb {
        width: 60px;
        border-radius: 6px;
        border: 1px solid #e5e7eb;
    }

    .table tbody tr:hover {
        background: #f9fafb;
    }
</style>

<div class="container-fluid">

    {{-- HEADER --}}
    <div class="page-header-custom">
        <h4>Data Aspirasi</h4>
        <p>Daftar aspirasi yang telah dikirim</p>
    </div>

    <div class="card card-custom p-3">

        {{-- TABLE --}}
        <div class="table-responsive">
            <table class="table">

                <thead>
                    <tr>
                        <th>No</th>
                        <th>Tanggal</th>
                        <th>Kategori</th>
                        <th>Ruangan</th>
                        <th>Keterangan</th>
                        <th>Foto</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($aspirasi as $index => $item)
                    <tr>

                        <td>{{ $aspirasi->firstItem() + $index }}</td>

                        <td>{{ $item->updated_at->format('d M Y') }}</td>

                        <td>{{ $item->kategori->nama_kategori ?? '-' }}</td>

                        <td>{{ $item->ruangan->nama_ruangan ?? $item->lokasi }}</td>

                        <td style="max-width:200px;"
                            title="{{ $item->keterangan }}">
                            {{ \Illuminate\Support\Str::limit($item->keterangan, 50) }}
                        </td>

                        <td>
                            <img src="{{ asset('storage/' . $item->foto) }}" width="80">
                        </td>

                        <td class="text-center">
                            <a href="{{ route('siswa.aspirasi.detail', $item) }}"
                                class="btn btn-action btn-detail">
                                Detail
                            </a>

                            <button class="btn btn-action btn-delete">
                                Hapus
                            </button>
                        </td>



                    </tr>

                    @empty
                    <tr>
                        <td colspan="9" class="text-center text-muted py-4">
                            Belum ada riwayat aspirasi
                        </td>
                    </tr>
                    @endforelse
                </tbody>

            </table>
        </div>

        {{-- PAGINATION --}}
        <div class="mt-3 d-flex justify-content-center">
            {{ $aspirasi->links() }}
        </div>

    </div>

</div>

@endsection