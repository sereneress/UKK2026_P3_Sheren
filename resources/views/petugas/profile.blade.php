@extends('layouts.petugas')

@section('title', 'Profile Petugas')

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

    .avatar-circle {
        width: 80px;
        height: 80px;
        border-radius: 50%;
        background: #dbeafe;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 28px;
        font-weight: 600;
        color: #1d4ed8;
        margin: 0 auto 12px;
    }

    .section-title {
        font-size: 13px;
        font-weight: 500;
        padding: 12px 1.25rem;
        background: #eff6ff;
        border-bottom: 1px solid #dbeafe;
        color: #1d4ed8;
        border-radius: 12px 12px 0 0;
    }

    .info-table td {
        padding: 12px 1.25rem;
        font-size: 13px;
        border-bottom: 1px solid #f3f4f6;
        vertical-align: middle;
    }

    .info-table tr:last-child td { border-bottom: none; }

    .info-table td:first-child {
        color: #6c757d;
        font-weight: 500;
        width: 35%;
    }
</style>

<div class="container-fluid">

    {{-- HEADER --}}
    <div class="page-header-custom">
        <h4>Profile Petugas</h4>
        <p>Informasi detail akun petugas</p>
    </div>

    <div class="row g-3">

        {{-- KARTU FOTO --}}
        <div class="col-xl-4">
            <div class="card card-custom text-center p-4">
                @if($petugas->foto)
                    <img src="{{ asset('storage/' . $petugas->foto) }}" alt="Foto"
                        width="120" height="120"
                        class="rounded-circle img-thumbnail mx-auto d-block mb-3"
                        style="object-fit:cover; border:none; box-shadow:0 2px 8px rgba(0,0,0,0.1);">
                @else
                    <div class="avatar-circle">
                        {{ strtoupper(substr($petugas->nama, 0, 2)) }}
                    </div>
                @endif
                <h5 style="font-size:16px; font-weight:500; margin-bottom:4px;">{{ $petugas->nama }}</h5>
                <p class="text-muted" style="font-size:12px; margin-bottom:8px;">{{ $petugas->nip ?? '-' }}</p>
                <span style="display:inline-block; font-size:11px; padding:4px 14px; border-radius:20px;
                              background:#dcfce7; color:#166534;">
                    {{ $petugas->status }}
                </span>
            </div>
        </div>

        {{-- DETAIL INFO --}}
        <div class="col-xl-8">
            <div class="card card-custom">
                <div class="section-title">Informasi Petugas</div>
                <table class="info-table w-100">
                    <tr>
                        <td>Nama</td>
                        <td>{{ $petugas->nama }}</td>
                    </tr>
                    <tr>
                        <td>NIP</td>
                        <td>{{ $petugas->nip ?? '-' }}</td>
                    </tr>
                    <tr>
                        <td>Jenis Kelamin</td>
                        <td>{{ $petugas->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan' }}</td>
                    </tr>
                    <tr>
                        <td>Tanggal Lahir</td>
                        <td>{{ $petugas->tanggal_lahir ? date('d/m/Y', strtotime($petugas->tanggal_lahir)) : '-' }}</td>
                    </tr>
                    <tr>
                        <td>No HP</td>
                        <td>{{ $petugas->no_hp ?? '-' }}</td>
                    </tr>
                    <tr>
                        <td>Email</td>
                        <td>{{ $petugas->user->email }}</td>
                    </tr>
                    <tr>
                        <td>Alamat</td>
                        <td>{{ $petugas->alamat ?? '-' }}</td>
                    </tr>
                    <tr>
                        <td>Status</td>
                        <td>
                            <span style="display:inline-block; font-size:11px; padding:3px 12px;
                                          border-radius:20px; background:#f3f4f6; color:#374151;
                                          border:1px solid #e5e7eb;">
                                {{ $petugas->status }}
                            </span>
                        </td>
                    </tr>
                    <tr>
                        <td>Bergabung</td>
                        <td>{{ $petugas->created_at->format('d/m/Y H:i') }}</td>
                    </tr>
                </table>
            </div>
        </div>

    </div>
</div>

@endsection
