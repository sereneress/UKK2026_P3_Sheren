@extends('layouts.guru')

@section('title', 'Buat Aspirasi')

@section('content')

<style>
    .form-header {
        background: linear-gradient(135deg, #1e3a5f 0%, #2d6a9f 100%);
        border-radius: 12px;
        padding: 24px 28px;
        margin-bottom: 24px;
    }

    .form-header h4 {
        color: #fff;
        margin: 0;
    }

    .form-header p {
        color: rgba(255,255,255,0.7);
        margin: 0;
    }

    .card-form {
        border: none;
        border-radius: 12px;
        box-shadow: 0 2px 12px rgba(0,0,0,0.06);
    }

    .form-label {
        font-size: 0.8rem;
        font-weight: 600;
        color: #64748b;
    }

    .form-control-custom {
        border-radius: 8px;
        border: 1.5px solid #e2e8f0;
        padding: 10px 12px;
        font-size: 13px;
        width: 100%;
    }

    .form-control-custom:focus {
        border-color: #2d6a9f;
        outline: none;
        box-shadow: 0 0 0 2px rgba(45,106,159,0.1);
    }

    .btn-submit {
        background: linear-gradient(135deg, #1e3a5f, #2d6a9f);
        color: #fff;
        border: none;
        border-radius: 8px;
        padding: 10px 18px;
        font-weight: 600;
    }

    .preview-img {
        max-width: 220px;
        border-radius: 8px;
        margin-top: 10px;
    }

    .kategori-info {
        font-size: 12px;
        color: #64748b;
        margin-top: 5px;
    }

    .sidebar-card {
        border: none;
        border-radius: 12px;
        box-shadow: 0 2px 12px rgba(0,0,0,0.06);
    }

    .avatar {
        width: 45px;
        height: 45px;
        border-radius: 50%;
        background: #dbeafe;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 600;
        color: #1d4ed8;
    }
</style>

<div class="container-fluid">

    {{-- HEADER --}}
    <div class="form-header">
        <h4>Buat Aspirasi Baru</h4>
        <p>Sampaikan aspirasi terkait sarana sekolah</p>
    </div>

    {{-- ALERT --}}
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach($errors->all() as $e)
                    <li>{{ $e }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="row">

        {{-- FORM KIRI --}}
        <div class="col-xl-8">

            <div class="card card-form p-4">

                <form method="POST" action="{{ route('guru.aspirasi.store') }}" enctype="multipart/form-data">
                    @csrf

                    <div class="row">

                        {{-- KATEGORI --}}
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Kategori</label>
                            <select name="id_kategori" id="kategoriSelect" class="form-control-custom" required>
                                <option value="">-- Pilih Kategori --</option>
                                @foreach($kategoris as $k)
                                <option value="{{ $k->id_kategori }}"
                                    data-deskripsi="{{ $k->deskripsi }}">
                                    {{ $k->nama_kategori }}
                                </option>
                                @endforeach
                            </select>
                            <div id="kategoriDeskripsi" class="kategori-info"></div>
                        </div>

                        {{-- RUANGAN --}}
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Ruangan</label>
                            <select name="id_ruangan" class="form-control-custom" required>
                                <option value="">-- Pilih Ruangan --</option>
                                @foreach($ruangans as $r)
                                <option value="{{ $r->id_ruangan }}">
                                    {{ $r->nama_ruangan }}
                                </option>
                                @endforeach
                            </select>
                        </div>

                    </div>

                    {{-- KETERANGAN --}}
                    <div class="mb-3">
                        <label class="form-label">Keterangan</label>
                        <textarea name="keterangan"
                            class="form-control-custom"
                            rows="4"
                            placeholder="Jelaskan masalah atau aspirasi..."
                            required></textarea>
                    </div>

                    {{-- FOTO --}}
                    <div class="mb-3">
                        <label class="form-label">Upload Foto (Opsional)</label>
                        <input type="file" name="foto" id="fotoInput" class="form-control-custom">
                        <img id="previewImg" class="preview-img d-none">
                    </div>

                    <div class="text-end">
                        <button type="submit" class="btn-submit">
                            <i class="fa fa-paper-plane"></i> Kirim Aspirasi
                        </button>
                    </div>

                </form>

            </div>

        </div>

        {{-- SIDEBAR KANAN --}}
        <div class="col-xl-4">

            {{-- INFO USER --}}
            <div class="card sidebar-card mb-3">
                <div class="d-flex align-items-center p-3 border-bottom">
                    <div class="avatar me-3">
                        {{ strtoupper(substr(Auth::user()->name,0,2)) }}
                    </div>
                    <div>
                        <div style="font-weight:500;">{{ Auth::user()->name }}</div>
                        <div style="font-size:12px; color:#6c757d;">
                            {{ Auth::user()->email }}
                        </div>
                    </div>
                </div>

                <div class="p-3">
                    <table class="table table-sm mb-0">
                        <tr>
                            <td>Role</td>
                            <td>{{ ucfirst(Auth::user()->role) }}</td>
                        </tr>
                        <tr>
                            <td>Bergabung</td>
                            <td>{{ Auth::user()->created_at->format('d M Y') }}</td>
                        </tr>
                    </table>
                </div>
            </div>

            {{-- INFO NOTE --}}
            <div class="card sidebar-card p-3">
                <h6 style="font-weight:600;">Tips Mengisi</h6>
                <ul style="font-size:12px; color:#6c757d; padding-left:18px;">
                    <li>Pilih kategori sesuai masalah</li>
                    <li>Pilih ruangan yang benar</li>
                    <li>Isi keterangan dengan jelas</li>
                    <li>Tambahkan foto jika ada</li>
                </ul>
            </div>

        </div>

    </div>

</div>

@endsection


@push('scripts')
<script>
    // PREVIEW FOTO
    document.getElementById('fotoInput').addEventListener('change', function() {
        const img = document.getElementById('previewImg');

        if (this.files && this.files[0]) {
            const reader = new FileReader();

            reader.onload = function(e) {
                img.src = e.target.result;
                img.classList.remove('d-none');
            }

            reader.readAsDataURL(this.files[0]);
        } else {
            img.classList.add('d-none');
        }
    });

    // DESKRIPSI KATEGORI
    const kategoriSelect = document.getElementById('kategoriSelect');
    const kategoriDeskripsi = document.getElementById('kategoriDeskripsi');

    kategoriSelect.addEventListener('change', function() {
        const selected = this.options[this.selectedIndex];
        const deskripsi = selected.getAttribute('data-deskripsi');

        kategoriDeskripsi.innerText = deskripsi ?? '';
    });
</script>
@endpush