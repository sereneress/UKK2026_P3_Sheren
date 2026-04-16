@extends('layouts.petugas')

@section('title', 'History Aspirasi')

@section('content')

<style>
    .page-header-custom {
        background: linear-gradient(135deg, #1e3a5f 0%, #2d6a9f 100%);
        border-radius: 12px;
        padding: 24px 28px;
        margin-bottom: 24px;
    }

    .page-header-custom h4 { color: #fff; margin: 0; }
    .page-header-custom p  { color: rgba(255,255,255,0.7); margin: 0; font-size: 13px; }

    .card-custom {
        border: none;
        border-radius: 12px;
        box-shadow: 0 2px 12px rgba(0,0,0,0.06);
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

    .table tbody tr:hover { background: #f9fafb; }

    .btn-action {
        font-size: 12px;
        border-radius: 6px;
        padding: 5px 10px;
    }

    .btn-detail  { background: #eff6ff; color: #1d4ed8; border: none; }
    .btn-history { background: #f1f5f9; color: #334155; border: none; }
    .btn-detail:hover  { background: #dbeafe; }
    .btn-history:hover { background: #e2e8f0; }

    .badge-selesai { background: #dcfce7; color: #166534; display:inline-block; font-size:11px; padding:3px 10px; border-radius:20px; }

    /* Timeline */
    .timeline { position: relative; padding-left: 25px; }
    .timeline::before {
        content: '';
        position: absolute;
        left: 8px; top: 0; bottom: 0;
        width: 2px;
        background: #e5e7eb;
    }
    .timeline-item { position: relative; margin-bottom: 20px; }
    .timeline-dot {
        position: absolute;
        left: -22px; top: 5px;
        width: 16px; height: 16px;
        border-radius: 50%;
    }
    .dot-success { background: #22c55e; }
    .dot-warning { background: #facc15; }
    .dot-danger  { background: #ef4444; }
    .timeline-content { font-size: 13px; }
</style>

<div class="container-fluid">

    {{-- HEADER --}}
    <div class="page-header-custom">
        <h4>History Aspirasi</h4>
        <p>Daftar aspirasi yang telah selesai ditangani</p>
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
                <label class="form-label" style="font-size:12px; color:#64748b; font-weight:600;">Dari Tanggal</label>
                <input type="date" name="date_from" class="form-control form-control-custom" value="{{ request('date_from') }}">
            </div>
            <div class="col-md-3">
                <label class="form-label" style="font-size:12px; color:#64748b; font-weight:600;">Sampai Tanggal</label>
                <input type="date" name="date_to" class="form-control form-control-custom" value="{{ request('date_to') }}">
            </div>
            <div class="col-md-3 d-flex align-items-end">
                <button type="submit" class="btn-filter w-100">Filter</button>
            </div>
        </form>

        {{-- TABLE --}}
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Tanggal Selesai</th>
                        <th>ID Aspirasi</th>
                        <th>Pengirim</th>
                        <th>Kategori</th>
                        <th>Status Akhir</th>
                        <th class="text-center">Riwayat</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($history->where('status_baru', 'Selesai') as $index => $h)
                    <tr>
                        <td>{{ $history->firstItem() + $index }}</td>
                        <td style="color:#6c757d; font-size:12px;">{{ $h->created_at->format('d M Y H:i') }}</td>
                        <td class="text-muted" style="font-size:12px;">#{{ $h->id_aspirasi }}</td>
                        <td>
                            @php $pengirim = $h->aspirasi->user->siswa ?? $h->aspirasi->user->guru; @endphp
                            <div style="font-weight:500; font-size:13px;">{{ $pengirim->nama ?? $h->aspirasi->user->email }}</div>
                            <div style="font-size:11px; color:#6c757d;">{{ $pengirim->kelas ?? $pengirim->jabatan ?? '-' }}</div>
                        </td>
                        <td>{{ $h->aspirasi->kategori->nama_kategori ?? '-' }}</td>
                        <td><span class="badge-selesai">Selesai</span></td>
                        <td class="text-center">
                            <button class="btn btn-action btn-history"
                                data-bs-toggle="modal"
                                data-bs-target="#historyModal{{ $h->id_aspirasi }}">
                                Riwayat
                            </button>
                        </td>
                        <td class="text-center">
                            <a href="{{ route('petugas.aspirasi.detail', $h->id_aspirasi) }}"
                                class="btn btn-action btn-detail">
                                Detail
                            </a>
                        </td>
                    </tr>

                    {{-- MODAL --}}
                    <div class="modal fade" id="historyModal{{ $h->id_aspirasi }}">
                        <div class="modal-dialog">
                            <div class="modal-content" style="border-radius:12px; border:none;">
                                <div class="modal-header" style="background: linear-gradient(135deg,#1e3a5f,#2d6a9f); border-radius:12px 12px 0 0;">
                                    <h5 class="modal-title text-white" style="font-size:15px;">
                                        Riwayat Status #{{ $h->id_aspirasi }}
                                    </h5>
                                    <button class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                                </div>
                                <div class="modal-body">
                                    <div class="timeline">
                                        @forelse($h->aspirasi->historyStatus as $hs)
                                        <div class="timeline-item">
                                            <div class="timeline-dot {{ $hs->status_baru == 'Selesai' ? 'dot-success' : ($hs->status_baru == 'Proses' ? 'dot-warning' : 'dot-danger') }}"></div>
                                            <div class="timeline-content">
                                                <strong>{{ $hs->status_lama }} → {{ $hs->status_baru }}</strong><br>
                                                <small class="text-muted">{{ $hs->created_at->format('d M Y H:i') }}</small>
                                            </div>
                                        </div>
                                        @empty
                                        <p class="text-muted" style="font-size:13px;">Belum ada riwayat</p>
                                        @endforelse
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button class="btn btn-sm" data-bs-dismiss="modal"
                                        style="background:#f1f5f9; color:#334155; border:none; border-radius:8px; font-size:13px;">
                                        Tutup
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    @empty
                    <tr>
                        <td colspan="8" class="text-center text-muted py-4" style="font-size:13px;">
                            Belum ada aspirasi yang selesai
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- PAGINATION --}}
        <div class="mt-3 d-flex justify-content-center">
            {{ $history->withQueryString()->links() }}
        </div>

    </div>

</div>

@endsection
