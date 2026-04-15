@extends('layouts.guru')

@section('title', 'Dashboard Guru')

@section('content')
<style>
    .stat-card {
        background: #f8f9fa;
        border-radius: 12px;
        padding: 1rem 1.25rem;
        display: flex;
        align-items: center;
        justify-content: space-between;
        border: none;
    }

    .stat-label {
        font-size: 12px;
        color: #6c757d;
        margin-bottom: 4px;
    }

    .stat-value {
        font-size: 26px;
        font-weight: 500;
        color: #1a1a1a;
        line-height: 1;
    }

    .stat-icon {
        width: 42px;
        height: 42px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }

    .card-table thead th {
        font-size: 12px;
        color: #6c757d;
        font-weight: 400;
        padding: 10px 14px;
        background: #f8f9fa;
        border-bottom: 1px solid #f0f0f0;
    }

    .card-table tbody tr {
        border-bottom: 1px solid #f8f9fa;
        transition: background 0.15s;
    }

    .card-table tbody tr:last-child {
        border-bottom: none;
    }

    .card-table tbody tr:hover {
        background: #f8f9fa;
    }

    .card-table tbody td {
        font-size: 13px;
        padding: 11px 14px;
        vertical-align: middle;
    }

    .id-cell {
        font-size: 12px;
        color: #6c757d;
        font-weight: 500;
    }

    .sender-name {
        font-weight: 500;
        font-size: 13px;
    }

    .sender-sub {
        font-size: 11px;
        color: #6c757d;
        margin-top: 2px;
    }

    .badge-status {
        display: inline-block;
        font-size: 11px;
        padding: 3px 10px;
        border-radius: 20px;
        font-weight: 400;
    }

    .badge-menunggu {
        background: #fff8e1;
        color: #b45309;
    }

    .badge-proses {
        background: #e0f2fe;
        color: #0369a1;
    }

    .badge-selesai {
        background: #dcfce7;
        color: #166534;
    }

    .btn-icon {
        width: 30px;
        height: 30px;
        border-radius: 50%;
        border: 1px solid #e5e7eb;
        background: transparent;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        margin: 0 auto;
        transition: background 0.15s;
    }

    .btn-icon:hover {
        background: #f3f4f6;
    }

    .avatar-circle {
        width: 44px;
        height: 44px;
        border-radius: 50%;
        background: #dbeafe;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 15px;
        font-weight: 500;
        color: #1d4ed8;
        flex-shrink: 0;
    }

    .info-table td {
        padding: 10px 1.25rem;
        font-size: 13px;
        border-bottom: 1px solid #f3f4f6;
    }

    .info-table tr:last-child td {
        border-bottom: none;
    }

    .info-table td:first-child {
        color: #6c757d;
        width: 80px;
    }

    .progress-bar-track {
        height: 5px;
        background: #f3f4f6;
        border-radius: 4px;
        overflow: hidden;
        margin-top: 4px;
    }

    .sidebar-section-header {
        padding: 12px 1.25rem;
        background: #eff6ff;
        border-bottom: 1px solid #dbeafe;
        font-size: 13px;
        font-weight: 500;
        color: #1d4ed8;
    }

    html,
    body {
        height: 100%;
    }

    .dashboard-main-wrapper {
        min-height: 100vh;
        display: flex;
        flex-direction: column;
    }

    .dashboard-wrapper {
        flex: 1;
        display: flex;
        flex-direction: column;
    }

    .dashboard-content {
        flex: 1;
    }
</style>

<div class="container-fluid py-2">

    {{-- HEADER --}}
    <div class="mb-4">
        <h2 style="font-size: 20px; font-weight: 500;">Dashboard Guru</h2>
        <p class="text-muted mb-0" style="font-size: 14px;">
            Selamat datang, <strong>{{ Auth::user()->name }}</strong>
        </p>
    </div>

    {{-- STATISTIK --}}
    <div class="row g-3 mb-4">
        @php
        $cards = [
        [
        'label' => 'Total Aspirasi',
        'value' => $statistik['total'],
        'bg' => '#dbeafe',
        'icon' => '<svg width="18" height="18" fill="none" stroke="#1d4ed8" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
            <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z" />
        </svg>',
        ],
        [
        'label' => 'Menunggu',
        'value' => $statistik['menunggu'],
        'bg' => '#fef9c3',
        'icon' => '<svg width="18" height="18" fill="none" stroke="#b45309" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
            <circle cx="12" cy="12" r="10" />
            <polyline points="12 6 12 12 16 14" />
        </svg>',
        ],
        [
        'label' => 'Diproses',
        'value' => $statistik['proses'],
        'bg' => '#e0f2fe',
        'icon' => '<svg width="18" height="18" fill="none" stroke="#0369a1" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
            <path d="M12 2v4M12 18v4M4.93 4.93l2.83 2.83M16.24 16.24l2.83 2.83M2 12h4M18 12h4M4.93 19.07l2.83-2.83M16.24 7.76l2.83-2.83" />
        </svg>',
        ],
        [
        'label' => 'Selesai',
        'value' => $statistik['selesai'],
        'bg' => '#dcfce7',
        'icon' => '<svg width="18" height="18" fill="none" stroke="#166534" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
            <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14" />
            <polyline points="22 4 12 14.01 9 11.01" />
        </svg>',
        ],
        ];
        @endphp

        @foreach($cards as $card)
        <div class="col-xl-3 col-md-6">
            <div class="stat-card shadow-sm">
                <div>
                    <div class="stat-label">{{ $card['label'] }}</div>
                    <div class="stat-value">{{ $card['value'] }}</div>
                </div>
                <div class="stat-icon" style="background: {{ $card['bg'] }};">
                    {!! $card['icon'] !!}
                </div>
            </div>
        </div>
        @endforeach
    </div>

    {{-- MAIN CONTENT --}}
    <div class="row g-3">

        {{-- TABEL --}}
        <div class="col-xl-8">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-white d-flex justify-content-between align-items-center"
                    style="border-bottom: 1px solid #f3f4f6; padding: 14px 1.25rem;">
                    <span style="font-size: 14px; font-weight: 500;">Aspirasi Terbaru</span>
                    <a href="{{ route('guru.aspirasi.index') }}"
                        class="btn btn-sm"
                        style="font-size: 12px; background: #eff6ff; color: #1d4ed8; border: none; border-radius: 20px; padding: 5px 14px;">
                        Lihat Semua
                    </a>
                </div>

                <div class="table-responsive">
                    <table class="table card-table mb-0">
                        <thead>
                            <tr>
                                <th>ID</th>
                                @if(!$guru->canCreateAspirasi())
                                <th>Pengirim</th>
                                @endif
                                <th>Kategori</th>
                                <th>Ruangan</th>
                                <th>Status</th>
                                <th>Tanggal</th>
                                <th class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($aspirasiTerbaru as $a)
                            <tr>
                                <td class="id-cell">#{{ $a->id_aspirasi }}</td>

                                @if(!$guru->canCreateAspirasi())
                                <td>
                                    @php $pengirim = $a->user->siswa ?? $a->user->guru; @endphp
                                    <div class="sender-name">{{ $pengirim->nama ?? $a->user->email }}</div>
                                    <div class="sender-sub">{{ $pengirim->kelas ?? $pengirim->jabatan ?? '-' }}</div>
                                </td>
                                @endif

                                <td>{{ $a->kategori->nama_kategori ?? '-' }}</td>
                                <td>{{ $a->ruangan->nama_ruangan ?? $a->lokasi }}</td>

                                <td>
                                    @php
                                    $badgeClass = match($a->status) {
                                    'Selesai' => 'badge-selesai',
                                    'Proses' => 'badge-proses',
                                    default => 'badge-menunggu',
                                    };
                                    @endphp
                                    <span class="badge-status {{ $badgeClass }}">{{ $a->status }}</span>
                                </td>

                                <td style="color: #6c757d; font-size: 12px;">
                                    {{ $a->created_at->format('d M Y') }}
                                </td>

                                <td class="text-center">
                                    <a href="{{ route('guru.aspirasi.detail', $a->id_aspirasi) }}"
                                        class="btn-icon d-inline-flex">
                                        <svg width="14" height="14" fill="none" stroke="#6c757d" stroke-width="1.8"
                                            stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                                            <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z" />
                                            <circle cx="12" cy="12" r="3" />
                                        </svg>
                                    </a>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="{{ $guru->canCreateAspirasi() ? 6 : 7 }}"
                                    class="text-center text-muted py-4" style="font-size: 13px;">
                                    Tidak ada data aspirasi
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        {{-- SIDEBAR --}}
        <div class="col-xl-4">
            <div class="d-flex flex-column gap-3">

                {{-- KARTU AKUN --}}
                <div class="card border-0 shadow-sm">
                    {{-- Avatar row --}}
                    <div class="d-flex align-items-center gap-3 p-3"
                        style="border-bottom: 1px solid #f3f4f6;">
                        <div class="avatar-circle">
                            {{ strtoupper(substr($guru->nama, 0, 2)) }}
                        </div>
                        <div>
                            <div style="font-size: 15px; font-weight: 500;">{{ $guru->nama }}</div>
                            <div style="font-size: 12px; color: #6c757d; margin-top: 2px;">
                                {{ $guru->mata_pelajaran ?? $guru->jabatan ?? '-' }}
                            </div>
                        </div>
                    </div>

                    <div class="sidebar-section-header">Informasi Akun</div>

                    <table class="info-table w-100">
                        <tr>
                            <td>Nama</td>
                            <td>{{ $guru->nama }}</td>
                        </tr>
                        <tr>
                            <td>Jabatan</td>
                            <td>
                                <span style="display:inline-block; font-size:11px; padding:3px 10px;
                                             border-radius:20px; background:#f3f4f6; color:#374151;
                                             border: 1px solid #e5e7eb;">
                                    {{ $guru->jabatan }}
                                </span>
                            </td>
                        </tr>
                        <tr>
                            <td>NIP</td>
                            <td>{{ $guru->nip ?? '-' }}</td>
                        </tr>
                        <tr>
                            <td>Mapel</td>
                            <td>{{ $guru->mata_pelajaran ?? '-' }}</td>
                        </tr>
                    </table>
                </div>

                {{-- DISTRIBUSI STATUS --}}
                <div class="card border-0 shadow-sm p-3">
                    <div style="font-size: 13px; font-weight: 500; margin-bottom: 14px;">
                        Distribusi Status
                    </div>

                    @php
                    $total = max($statistik['total'], 1);
                    $bars = [
                    ['label' => 'Menunggu', 'value' => $statistik['menunggu'], 'color' => '#f59e0b'],
                    ['label' => 'Diproses', 'value' => $statistik['proses'], 'color' => '#0ea5e9'],
                    ['label' => 'Selesai', 'value' => $statistik['selesai'], 'color' => '#22c55e'],
                    ];
                    @endphp

                    @foreach($bars as $bar)
                    <div class="mb-2">
                        <div class="d-flex justify-content-between"
                            style="font-size: 12px; color: #6c757d;">
                            <span>{{ $bar['label'] }}</span>
                            <span>{{ $bar['value'] }}</span>
                        </div>
                        <div class="progress-bar-track">
                            <div style="height: 100%;
                                        width: {{ round(($bar['value'] / $total) * 100) }}%;
                                        background: {{ $bar['color'] }};
                                        border-radius: 4px;">
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
        <!-- FOOTER -->
        <div class="footer" style="
    background: #fff;
    border-top: 1px solid #e5e7eb;
    padding: 12px 20px;
    font-size: 13px;
    color: #6c757d;
    margin-top: 20px;
">
            <div class="d-flex justify-content-between align-items-center">
                <span>
                    © {{ date('Y') }} Guru Pengaduan Sarana Sekolah
                </span>
                <span>
                    Dibuat dengan ❤️ oleh {{ auth()->user()->name ?? 'Syeren' }}
                </span>
            </div>
        </div>
    </div>
</div>
@endsection