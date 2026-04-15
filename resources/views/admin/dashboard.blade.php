@extends('layouts.admin')

@section('title', 'Dashboard Admin')

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
    }

    .stat-value {
        font-size: 26px;
        font-weight: 500;
    }

    .stat-icon {
        width: 42px;
        height: 42px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
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
        <h2 style="font-size: 20px;">Dashboard Admin</h2>
        <p class="text-muted mb-0">
            Selamat datang, <strong>{{ Auth::user()->name }}</strong>
        </p>
    </div>

    {{-- STATISTIK --}}
    <div class="row g-3 mb-4">

        <div class="col-xl-3 col-md-6">
            <div class="stat-card shadow-sm">
                <div>
                    <div class="stat-label">Total Siswa</div>
                    <div class="stat-value">{{ $totalSiswa }}</div>
                </div>
                <div class="stat-icon" style="background:#dcfce7;">
                    <i class="fa fa-users text-success"></i>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6">
            <div class="stat-card shadow-sm">
                <div>
                    <div class="stat-label">Total Guru</div>
                    <div class="stat-value">{{ $totalGuru }}</div>
                </div>
                <div class="stat-icon" style="background:#dbeafe;">
                    <i class="fa fa-chalkboard-teacher text-primary"></i>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6">
            <div class="stat-card shadow-sm">
                <div>
                    <div class="stat-label">Total Aspirasi</div>
                    <div class="stat-value">{{ $totalAspirasi }}</div>
                </div>
                <div class="stat-icon" style="background:#fef9c3;">
                    <i class="fa fa-comments text-warning"></i>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6">
            <div class="stat-card shadow-sm">
                <div>
                    <div class="stat-label">Total Admin</div>
                    <div class="stat-value">{{ $totalAdmin }}</div>
                </div>
                <div class="stat-icon" style="background:#e0f2fe;">
                    <i class="fa fa-user-shield text-info"></i>
                </div>
            </div>
        </div>

    </div>

    {{-- STATUS + INFO AKUN --}}
    <div class="row">

        <!-- KIRI -->
        <div class="col-xl-6">
            <div class="card border-0 shadow-sm p-3">
                <div style="font-size: 14px; font-weight: 500; margin-bottom: 10px;">
                    Distribusi Status Aspirasi
                </div>

                @php
                $total = max($totalAspirasi, 1);
                $bars = [
                ['label'=>'Menunggu','value'=>$aspirasiMenunggu,'color'=>'#f59e0b'],
                ['label'=>'Diproses','value'=>$aspirasiProses,'color'=>'#0ea5e9'],
                ['label'=>'Selesai','value'=>$aspirasiSelesai,'color'=>'#22c55e'],
                ];
                @endphp

                @foreach($bars as $bar)
                <div class="mb-2">
                    <div class="d-flex justify-content-between text-muted" style="font-size:12px;">
                        <span>{{ $bar['label'] }}</span>
                        <span>{{ $bar['value'] }}</span>
                    </div>
                    <div style="height:5px; background:#f3f4f6; border-radius:4px;">
                        <div style="
                        width: {{ ($bar['value']/$total)*100 }}%;
                        height:100%;
                        background: {{ $bar['color'] }};
                        border-radius:4px;">
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>

        <!-- KANAN -->
        <div class="col-xl-6">
            <div class="card border-0 shadow-sm">

                <!-- HEADER USER -->
                <div class="d-flex align-items-center p-3"
                    style="border-bottom: 1px solid #f3f4f6;">

                    <div style="
                    width: 45px;
                    height: 45px;
                    border-radius: 50%;
                    background: #dbeafe;
                    display:flex;
                    align-items:center;
                    justify-content:center;
                    font-weight:600;
                    color:#1d4ed8;
                    margin-right:12px;">

                        {{ strtoupper(substr(Auth::user()->name, 0, 2)) }}
                    </div>

                    <div>
                        <div style="font-weight:500;">
                            {{ Auth::user()->name }}
                        </div>
                        <div style="font-size:12px; color:#6c757d;">
                            {{ Auth::user()->email }}
                        </div>
                    </div>
                </div>

                <!-- DETAIL -->
                <div style="padding: 1rem;">
                    <table class="table table-sm mb-0">
                        <tr>
                            <td style="width:120px;">Role</td>
                            <td>
                                <span style="
                                padding:3px 10px;
                                border-radius:20px;
                                background:#f3f4f6;
                                font-size:11px;">
                                    {{ ucfirst(Auth::user()->role) }}
                                </span>
                            </td>
                        </tr>
                        <tr>
                            <td>Nama</td>
                            <td>{{ Auth::user()->name }}</td>
                        </tr>
                        <tr>
                            <td>Email</td>
                            <td>{{ Auth::user()->email }}</td>
                        </tr>
                        <tr>
                            <td>Bergabung</td>
                            <td>{{ Auth::user()->created_at->format('d M Y') }}</td>
                        </tr>
                    </table>
                </div>
            </div>



        </div>

        <div class="card border-0 shadow-sm">

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
                    © {{ date('Y') }} Admin Pengaduan Sarana Sekolah
                </span>
                <span>
                    Dibuat dengan ❤️ oleh {{ auth()->user()->name ?? 'Syeren' }}
                </span>
            </div>
        </div>

    </div>
    @endsection