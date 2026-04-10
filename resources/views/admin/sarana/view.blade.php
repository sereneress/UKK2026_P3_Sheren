@extends('layouts.admin')

@section('title', 'Detail Sarana')

@section('content')
<div class="row">
    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
        <div class="page-header">
            <h2 class="pageheader-title">Detail Sarana</h2>
            <p class="pageheader-text">Informasi lengkap mengenai sarana ini.</p>
            <div class="page-breadcrumb">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}" class="breadcrumb-link">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('admin.sarana.index') }}" class="breadcrumb-link">Sarana</a></li>
                        <li class="breadcrumb-item active">Detail</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-xl-8 col-lg-8 col-md-12 col-sm-12 col-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">{{ $sarana->nama }}</h5>
                <span class="badge badge-{{ $sarana->kondisi == 'baik' ? 'success' : ($sarana->kondisi == 'rusak' ? 'danger' : 'warning') }} badge-pill px-3 py-2">
                    {{ ucfirst($sarana->kondisi) }}
                </span>
            </div>
            <div class="card-body">
                @if($sarana->foto)
                <div class="text-center mb-4">
                    <img src="{{ asset('storage/' . $sarana->foto) }}" alt="Foto Sarana"
                        class="img-fluid rounded" style="max-height: 300px;">
                </div>
                @endif

                <table class="table table-borderless">
                    <tbody>
                        <tr>
                            <th style="width:35%">Nama Sarana</th>
                            <td>{{ $sarana->nama }}</td>
                        </tr>
                        <tr>
                            <th>Lokasi</th>
                            <td>{{ $sarana->lokasi ?? '-' }}</td>
                        </tr>
                        <tr>
                            <th>Kondisi</th>
                            <td>
                                <span class="badge badge-{{ $sarana->kondisi == 'baik' ? 'success' : ($sarana->kondisi == 'rusak' ? 'danger' : 'warning') }}">
                                    {{ ucfirst($sarana->kondisi) }}
                                </span>
                            </td>
                        </tr>
                        <tr>
                            <th>Keterangan</th>
                            <td>{{ $sarana->keterangan ?? '-' }}</td>
                        </tr>
                        <tr>
                            <th>Ditambahkan</th>
                            <td>{{ $sarana->created_at->format('d M Y, H:i') }}</td>
                        </tr>
                        <tr>
                            <th>Terakhir Diupdate</th>
                            <td>{{ $sarana->updated_at->format('d M Y, H:i') }}</td>
                        </tr>
                    </tbody>
                </table>

                <div class="d-flex justify-content-between mt-3">
                    <a href="{{ route('admin.sarana.index') }}" class="btn btn-secondary">
                        <i class="fa fa-arrow-left mr-2"></i>Kembali
                    </a>
                    <div>
                        <a href="{{ route('admin.sarana.edit', $sarana->id) }}" class="btn btn-primary mr-2">
                            <i class="fa fa-edit mr-2"></i>Edit
                        </a>
                        <form action="{{ route('admin.sarana.destroy', $sarana->id) }}" method="POST" class="d-inline"
                            onsubmit="return confirm('Yakin ingin menghapus sarana ini?')">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn btn-danger">
                                <i class="fa fa-trash mr-2"></i>Hapus
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection