@extends('layouts.siswa')

@section('title', 'Detail Aspirasi')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="page-header">
            <h2 class="pageheader-title">Detail Aspirasi</h2>
            <p class="pageheader-text">Informasi lengkap aspirasi siswa.</p>

            <div class="page-breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="{{ route('siswa.dashboard') }}">Dashboard</a>
                    </li>
                    <li class="breadcrumb-item">
                        <a href="{{ route('siswa.aspirasi.index') }}">Aspirasi</a>
                    </li>
                    <li class="breadcrumb-item active">Detail</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<div class="row">

    {{-- LEFT --}}
    <div class="col-xl-8">

        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Detail Aspirasi #{{ $aspirasi->id }}</h5>
            </div>

            <div class="card-body p-0">
                <table class="table table-bordered">
                    <tr>
                        <th width="30%">Kategori</th>
                        <td>{{ $aspirasi->kategori->nama_kategori ?? '-' }}</td>
                    </tr>
                    <tr>
                        <th>Ruangan</th>
                        <td>{{ $aspirasi->ruangan->nama_ruangan ?? $aspirasi->lokasi }}</td>
                    </tr>
                    <tr>
                        <th>Keterangan</th>
                        <td>{{ $aspirasi->keterangan }}</td>
                    </tr>
                    @if($aspirasi->foto)
                    <tr>
                        <th>Foto Awal</th>
                        <td><img src="{{ asset('storage/' . $aspirasi->foto) }}" width="200" class="img-thumbnail"></td>
                    </tr>
                    @endif

                    <!-- TAMPILKAN FOTO BUKTI SELESAI -->
                    @php
                    $fotoBukti = null;
                    foreach($aspirasi->progres as $progres) {
                    if(str_contains($progres->keterangan_progres, '📎 Foto bukti:')) {
                    preg_match('/📎 Foto bukti: (.*)/', $progres->keterangan_progres, $matches);
                    if(isset($matches[1])) {
                    $fotoBukti = $matches[1];
                    break;
                    }
                    }
                    }
                    @endphp

                    @if($fotoBukti)
                    <tr>
                        <th>Foto Bukti Selesai</th>
                        <td>
                            <img src="{{ $fotoBukti }}" alt="Foto Bukti" width="300" class="img-thumbnail">
                            <br>
                            <small class="text-muted">Foto bukti penanganan setelah selesai</small>
                        </td>
                    </tr>
                    @endif

                    <tr>
                        <th>Status</th>
                        <td>
                            <span class="badge bg-{{ $aspirasi->status == 'Selesai' ? 'success' : ($aspirasi->status == 'Proses' ? 'info' : 'warning') }}">
                                {{ $aspirasi->status }}
                            </span>
                        </td>
                    </tr>
                    <tr>
                        <th>Dibuat Pada</th>
                        <td>{{ $aspirasi->created_at?->format('d/m/Y H:i:s') ?? '-' }}</td>
                    </tr>
                    @if($aspirasi->status == 'Selesai')
                    <tr>
                        <th>Selesai Pada</th>
                        <td>{{ $aspirasi->updated_at?->format('d/m/Y H:i:s') ?? '-' }}</td>
                    </tr>
                    @endif
                </table>

                <div class="mt-3 d-flex justify-content-end">
                    <a href="{{ url()->previous() }}" class="btn btn-secondary">
                        <i class="fa fa-arrow-left"></i> Kembali
                    </a>
                </div>

            </div>
        </div>

    </div>

    {{-- RIGHT --}}
    <div class="col-xl-4">

        {{-- PROGRES --}}
        <div class="card mb-3">
            <div class="card-header">
                <h6>Riwayat Progres</h6>
            </div>

            <div class="card-body">
                @forelse($aspirasi->progres as $p)
                <div class="mb-3 border-start ps-3">

                    <small>
                        {{ optional($p->created_at)->format('d/m/Y H:i') ?? '-' }}
                    </small><br>

                    {{ $p->keterangan ?? 'Update' }} <br>

                    <small class="text-muted">
                        - {{ $p->user->email ?? '-' }}
                    </small>

                </div>
                @empty
                <p class="text-muted">Belum ada progres</p>
                @endforelse
            </div>
        </div>

        {{-- STATUS --}}
        <div class="card">
            <div class="card-header">
                <h6>Riwayat Status</h6>
            </div>

            <div class="card-body">
                @forelse($aspirasi->historyStatus as $h)
                <div class="mb-2">

                    <small>
                        {{ optional($h->created_at)->format('d/m/Y H:i') ?? '-' }}
                    </small><br>

                    Status:
                    <b>{{ $h->status ?? ($h->status_baru ?? '-') }}</b>

                </div>
                @empty
                <p class="text-muted">Belum ada riwayat</p>
                @endforelse
            </div>
        </div>

    </div>

</div>
@endsection