@extends('layouts.admin')

@section('title', 'Edit Sarana')

@section('content')
<div class="row">
    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
        <div class="page-header">
            <h2 class="pageheader-title">Edit Sarana</h2>
            <p class="pageheader-text">Ubah data sarana dan prasarana.</p>
            <div class="page-breadcrumb">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}" class="breadcrumb-link">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('admin.sarana.index') }}" class="breadcrumb-link">Sarana</a></li>
                        <li class="breadcrumb-item active">Edit</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-xl-8 col-lg-8 col-md-12 col-sm-12 col-12">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Form Edit Sarana</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.sarana.update', $sarana->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf @method('PUT')

                    <div class="form-group">
                        <label for="nama">Nama Sarana <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('nama') is-invalid @enderror"
                            id="nama" name="nama" value="{{ old('nama', $sarana->nama) }}" required>
                        @error('nama')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="form-group">
                        <label for="lokasi">Lokasi</label>
                        <input type="text" class="form-control @error('lokasi') is-invalid @enderror"
                            id="lokasi" name="lokasi" value="{{ old('lokasi', $sarana->lokasi) }}">
                        @error('lokasi')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="form-group">
                        <label for="kondisi">Kondisi <span class="text-danger">*</span></label>
                        <select class="form-control @error('kondisi') is-invalid @enderror"
                            id="kondisi" name="kondisi" required>
                            <option value="">-- Pilih Kondisi --</option>
                            <option value="baik" {{ old('kondisi', $sarana->kondisi) == 'baik' ? 'selected' : '' }}>Baik</option>
                            <option value="sedang" {{ old('kondisi', $sarana->kondisi) == 'sedang' ? 'selected' : '' }}>Sedang</option>
                            <option value="rusak" {{ old('kondisi', $sarana->kondisi) == 'rusak' ? 'selected' : '' }}>Rusak</option>
                        </select>
                        @error('kondisi')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="form-group">
                        <label for="keterangan">Keterangan</label>
                        <textarea class="form-control @error('keterangan') is-invalid @enderror"
                            id="keterangan" name="keterangan" rows="4">{{ old('keterangan', $sarana->keterangan) }}</textarea>
                        @error('keterangan')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    @if($sarana->foto)
                    <div class="form-group">
                        <label>Foto Saat Ini</label>
                        <div>
                            <img src="{{ asset('storage/' . $sarana->foto) }}" alt="Foto Sarana"
                                class="img-thumbnail" style="max-height: 150px;">
                        </div>
                    </div>
                    @endif

                    <div class="form-group">
                        <label for="foto">Ganti Foto (opsional)</label>
                        <div class="custom-file">
                            <input type="file" class="custom-file-input @error('foto') is-invalid @enderror"
                                id="foto" name="foto" accept="image/*">
                            <label class="custom-file-label" for="foto">Pilih file baru...</label>
                        </div>
                        @error('foto')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                    </div>

                    <div class="d-flex justify-content-between">
                        <a href="{{ route('admin.sarana.index') }}" class="btn btn-secondary">
                            <i class="fa fa-arrow-left mr-2"></i>Kembali
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="fa fa-save mr-2"></i>Update
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.querySelector('.custom-file-input').addEventListener('change', function(e) {
        var fileName = e.target.files[0].name;
        e.target.nextElementSibling.innerText = fileName;
    });
</script>
@endpush