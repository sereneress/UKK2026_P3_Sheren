@extends('layouts.petugas')

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
        padding: 8px 14px;
        font-weight: 500;
        font-size: 13px;
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

    .table tbody tr:hover {
        background: #f9fafb;
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

    .btn-detail:hover {
        background: #dbeafe;
    }

    .badge-status {
        display: inline-block;
        font-size: 11px;
        padding: 3px 10px;
        border-radius: 20px;
        font-weight: 400;
    }

    .badge-menunggu { background: #fff8e1; color: #b45309; }
    .badge-proses   { background: #e0f2fe; color: #0369a1; }
    .badge-selesai  { background: #dcfce7; color: #166534; }
</style>

<div class="container-fluid">

    {{-- HEADER --}}
    <div class="page-header-custom">
        <h4>Data Aspirasi</h4>
        <p>Kelola dan tindak lanjuti aspirasi yang masuk</p>
    </div>

    <div class="card card-custom p-3">

        {{-- FILTER --}}
        <form method="GET" class="row g-2 mb-4">
            <div class="col-md-3">
                <label class="form-label" style="font-size:12px; color:#64748b; font-weight:600;">Filter Status</label>
                <select name="status" class="form-control form-control-custom">
                    <option value="">Semua Status</option>
                    <option value="Menunggu" {{ request('status') == 'Menunggu' ? 'selected' : '' }}>Menunggu</option>
                    <option value="Proses"   {{ request('status') == 'Proses'   ? 'selected' : '' }}>Diproses</option>
                    <option value="Selesai"  {{ request('status') == 'Selesai'  ? 'selected' : '' }}>Selesai</option>
                </select>
            </div>
            <div class="col-md-3">
                <label class="form-label" style="font-size:12px; color:#64748b; font-weight:600;">Kategori</label>
                <select name="kategori" class="form-control form-control-custom">
                    <option value="">Semua Kategori</option>
                    @foreach($kategoris as $kategori)
                    <option value="{{ $kategori->id_kategori }}" {{ request('kategori') == $kategori->id_kategori ? 'selected' : '' }}>
                        {{ $kategori->nama_kategori }}
                    </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-4">
                <label class="form-label" style="font-size:12px; color:#64748b; font-weight:600;">Cari</label>
                <input type="text" name="search" class="form-control form-control-custom"
                    placeholder="Cari keterangan atau lokasi..."
                    value="{{ request('search') }}">
            </div>
            <div class="col-md-2 d-flex align-items-end">
                <button type="submit" class="btn-filter w-100">Filter</button>
            </div>
        </form>

        {{-- TABLE --}}
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>ID</th>
                        <th>Pengirim</th>
                        <th>Kategori</th>
                        <th>Ruangan</th>
                        <th>Keterangan</th>
                        <th>Status</th>
                        <th>Tanggal</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($aspirasi as $index => $a)
                    <tr>
                        <td>{{ $aspirasi->firstItem() + $index }}</td>
                        <td class="text-muted" style="font-size:12px;">#{{ $a->id_aspirasi }}</td>
                        <td>
                            @php $pengirim = $a->user->siswa ?? $a->user->guru; @endphp
                            <div style="font-weight:500; font-size:13px;">{{ $pengirim->nama ?? $a->user->email }}</div>
                            <div style="font-size:11px; color:#6c757d;">{{ $pengirim->kelas ?? $pengirim->jabatan ?? '-' }}</div>
                        </td>
                        <td>{{ $a->kategori->nama_kategori ?? '-' }}</td>
                        <td>{{ $a->ruangan->nama_ruangan ?? $a->lokasi }}</td>
                        <td style="max-width:200px;" title="{{ $a->keterangan }}">
                            {{ Str::limit($a->keterangan, 50) }}
                        </td>
                        <td>
                            @php
                            $badgeClass = match($a->status) {
                                'Selesai' => 'badge-selesai',
                                'Proses'  => 'badge-proses',
                                default   => 'badge-menunggu',
                            };
                            @endphp
                            <span class="badge-status {{ $badgeClass }}">{{ $a->status }}</span>
                        </td>
                        <td style="color:#6c757d; font-size:12px;">
                            {{ $a->created_at->format('d M Y') }}
                        </td>
                        <td class="text-center">
                            <a href="{{ route('petugas.aspirasi.detail', $a->id_aspirasi) }}"
                                class="btn btn-action btn-detail">
                                Detail
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="9" class="text-center text-muted py-4" style="font-size:13px;">
                            Tidak ada data aspirasi
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- PAGINATION --}}
        <div class="mt-3 d-flex justify-content-center">
            {{ $aspirasi->withQueryString()->links() }}
        </div>

    </div>

</div>

@endsection
