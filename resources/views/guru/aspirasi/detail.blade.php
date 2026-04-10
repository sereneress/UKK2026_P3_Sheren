@extends('layouts.admin')

@section('title', 'Detail Aspirasi')

@section('content')
<div class="row">
    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
        <div class="page-header">
            <h2 class="pageheader-title">Detail Aspirasi</h2>
            <p class="pageheader-text">Informasi lengkap aspirasi siswa dan berikan tanggapan.</p>
            <div class="page-breadcrumb">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('guru.dashboard') }}" class="breadcrumb-link">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('guru.aspirasi.index') }}" class="breadcrumb-link">Aspirasi</a></li>
                        <li class="breadcrumb-item active">Detail</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-xl-8 col-lg-8 col-md-12 col-sm-12 col-12">
        {{-- Aspirasi Info --}}
        <div class="card mb-4">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">{{ $aspirasi->judul }}</h5>
                @php
                    $badgeClass = match($aspirasi->status) {
                        'selesai' => 'success', 'proses' => 'warning',
                        'ditolak' => 'danger',  default  => 'secondary',
                    };
                @endphp
                <span class="badge badge-{{ $badgeClass }} badge-pill px-3 py-2">{{ ucfirst($aspirasi->status) }}</span>
            </div>
            <div class="card-body">
                <div class="row mb-3">
                    <div class="col-md-6">
                        <small class="text-muted">Pengirim</small>
                        <p class="font-weight-bold mb-0">{{ $aspirasi->user->name ?? '-' }}</p>
                    </div>
                    <div class="col-md-6">
                        <small class="text-muted">Kategori</small>
                        <p class="font-weight-bold mb-0">{{ $aspirasi->kategori->nama ?? '-' }}</p>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-6">
                        <small class="text-muted">Tanggal Masuk</small>
                        <p class="font-weight-bold mb-0">{{ $aspirasi->created_at->format('d M Y, H:i') }}</p>
                    </div>
                    <div class="col-md-6">
                        <small class="text-muted">Terakhir Diupdate</small>
                        <p class="font-weight-bold mb-0">{{ $aspirasi->updated_at->format('d M Y, H:i') }}</p>
                    </div>
                </div>
                <hr>
                <h6 class="font-weight-bold">Isi Aspirasi:</h6>
                <div class="p-3 bg-light rounded">
                    <p class="mb-0">{{ $aspirasi->isi }}</p>
                </div>

                @if($aspirasi->lampiran)
                <div class="mt-3">
                    <h6 class="font-weight-bold">Lampiran:</h6>
                    <a href="{{ asset('storage/' . $aspirasi->lampiran) }}" target="_blank" class="btn btn-sm btn-outline-info">
                        <i class="fa fa-paperclip mr-1"></i>Lihat Lampiran
                    </a>
                </div>
                @endif
            </div>
        </div>

        {{-- Update Status --}}
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="mb-0">Update Status & Tanggapan</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('guru.aspirasi.update', $aspirasi->id) }}" method="POST">
                    @csrf @method('PUT')
                    <div class="form-group">
                        <label for="status">Status Aspirasi</label>
                        <select class="form-control" id="status" name="status" required>
                            <option value="pending" {{ $aspirasi->status == 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="proses" {{ $aspirasi->status == 'proses' ? 'selected' : '' }}>Sedang Diproses</option>
                            <option value="selesai" {{ $aspirasi->status == 'selesai' ? 'selected' : '' }}>Selesai</option>
                            <option value="ditolak" {{ $aspirasi->status == 'ditolak' ? 'selected' : '' }}>Ditolak</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="tanggapan">Tanggapan / Catatan</label>
                        <textarea class="form-control" id="tanggapan" name="tanggapan" rows="4"
                            placeholder="Tulis tanggapan Anda terhadap aspirasi ini...">{{ $aspirasi->tanggapan }}</textarea>
                    </div>
                    <div class="d-flex justify-content-between">
                        <a href="{{ route('guru.aspirasi.index') }}" class="btn btn-secondary">
                            <i class="fa fa-arrow-left mr-2"></i>Kembali
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="fa fa-save mr-2"></i>Simpan Tanggapan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- History Status --}}
    <div class="col-xl-4 col-lg-4 col-md-12 col-sm-12 col-12">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Riwayat Status</h5>
            </div>
            <div class="card-body p-0">
                <ul class="list-group list-group-flush">
                    @forelse($aspirasi->historyStatuses ?? [] as $history)
                    <li class="list-group-item">
                        <div class="d-flex justify-content-between">
                            <span class="badge badge-{{ $history->status == 'selesai' ? 'success' : ($history->status == 'proses' ? 'warning' : 'secondary') }}">
                                {{ ucfirst($history->status) }}
                            </span>
                            <small class="text-muted">{{ $history->created_at->format('d M Y') }}</small>
                        </div>
                        @if($history->catatan)
                        <p class="small text-muted mt-1 mb-0">{{ $history->catatan }}</p>
                        @endif
                    </li>
                    @empty
                    <li class="list-group-item text-center text-muted py-3">Belum ada riwayat.</li>
                    @endforelse
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection