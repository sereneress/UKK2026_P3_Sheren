@extends('layouts.guru')

@section('title', 'Riwayat Aspirasi')

@section('content')

<style>
    /* ===== HEADER ===== */
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

    /* ===== CARD ===== */
    .card-custom {
        border: none;
        border-radius: 12px;
        box-shadow: 0 2px 12px rgba(0, 0, 0, 0.06);
    }

    /* ===== TABLE ===== */
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

    /* ===== BUTTON ===== */
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

    .btn-history {
        background: #f1f5f9;
        color: #334155;
        border: none;
    }

    .btn-detail:hover {
        background: #dbeafe;
    }

    .btn-history:hover {
        background: #e2e8f0;
    }

    /* ===== BADGE ===== */
    .badge-status {
        padding: 6px 10px;
        border-radius: 20px;
        font-size: 11px;
    }

    /* ===== TIMELINE ===== */
    .timeline {
        position: relative;
        padding-left: 25px;
    }

    .timeline::before {
        content: '';
        position: absolute;
        left: 8px;
        top: 0;
        bottom: 0;
        width: 2px;
        background: #e5e7eb;
    }

    .timeline-item {
        position: relative;
        margin-bottom: 20px;
    }

    .timeline-dot {
        position: absolute;
        left: -2px;
        top: 5px;
        width: 16px;
        height: 16px;
        border-radius: 50%;
    }

    .success {
        background: #22c55e;
    }

    .warning {
        background: #facc15;
    }

    .danger {
        background: #ef4444;
    }

    .timeline-content {
        margin-left: 20px;
    }
</style>

<div class="container-fluid">

    {{-- HEADER --}}
    <div class="page-header-custom">
        <h4>Riwayat Aspirasi</h4>
        <p>Daftar aspirasi yang telah selesai atau ditolak</p>
    </div>

    <div class="card card-custom p-3">

        <div class="table-responsive">
            <table class="table">

                <thead>
                    <tr>
                        <th>No</th>
                        <th>ID</th>
                        <th>Kategori</th>
                        <th>Ruangan</th>
                        <th>Keterangan</th>
                        <th>Tanggal</th>
                        <th>Status</th>
                        <th class="text-center">Riwayat</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($histories as $index => $aspirasi)
                    <tr>

                        <td>{{ $index + $histories->firstItem() }}</td>

                        <td><b>#{{ $item->id_aspirasi }}</b></td>

                        <td>{{ $aspirasi->kategori->nama_kategori ?? '-' }}</td>

                        <td>{{ $aspirasi->ruangan->nama_ruangan ?? $aspirasi->lokasi }}</td>

                        <td style="max-width:200px;">
                            {{ \Illuminate\Support\Str::limit($aspirasi->keterangan, 50) }}
                        </td>

                        <td>{{ $aspirasi->updated_at->format('d M Y') }}</td>

                        <td>
                            <span class="badge-status 
                                {{ $aspirasi->status == 'selesai' ? 'bg-success' : 'bg-danger' }}">
                                {{ ucfirst($aspirasi->status) }}
                            </span>
                        </td>

                        <td class="text-center">
                            <button class="btn btn-action btn-history"
                                data-bs-toggle="modal"
                                data-bs-target="#historyModal{{ $aspirasi->id }}">
                                Riwayat
                            </button>
                        </td>

                        <td class="text-center">
                            <a href="{{ route('guru.aspirasi.detail', $aspirasi->id_aspirasi) }}"
                                class="btn btn-action btn-detail">
                                Detail
                            </a>
                        </td>

                    </tr>

                    {{-- MODAL --}}
                    <div class="modal fade" id="historyModal{{ $aspirasi->id }}">
                        <div class="modal-dialog">
                            <div class="modal-content">

                                <div class="modal-header bg-primary text-white">
                                    <h5 class="modal-title">
                                        Riwayat Status #{{ $aspirasi->id }}
                                    </h5>
                                    <button class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                                </div>

                                <div class="modal-body">

                                    <div class="timeline">
                                        @forelse($aspirasi->historyStatus as $history)
                                        <div class="timeline-item">

                                            <div class="timeline-dot 
                                                {{ $history->status_baru == 'selesai' ? 'success' : ($history->status_baru == 'proses' ? 'warning' : 'danger') }}">
                                            </div>

                                            <div class="timeline-content">
                                                <strong>
                                                    {{ ucfirst($history->status_lama) }} →
                                                    {{ ucfirst($history->status_baru) }}
                                                </strong><br>

                                                <small class="text-muted">
                                                    {{ $history->created_at->format('d M Y H:i') }}
                                                </small>
                                            </div>

                                        </div>
                                        @empty
                                        <p class="text-muted">Belum ada riwayat</p>
                                        @endforelse
                                    </div>

                                </div>

                                <div class="modal-footer">
                                    <button class="btn btn-secondary" data-bs-dismiss="modal">
                                        Tutup
                                    </button>
                                </div>

                            </div>
                        </div>
                    </div>

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
            {{ $histories->links() }}
        </div>

    </div>

</div>

@endsection