@extends('layouts.admin')

@section('title', 'Buat Aspirasi')

@section('content')
<div class="row">
    <div class="col-xl-12">
        <div class="page-header">
            <h2 class="pageheader-title">Buat Aspirasi Baru</h2>
            <p class="pageheader-text">Sampaikan aspirasi terkait sarana sekolah.</p>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-12">

        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Form Aspirasi</h5>
            </div>

            <div class="card-body">

                {{-- SUCCESS --}}
                @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
                @endif

                {{-- ERROR --}}
                @if($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif

                <form method="POST" action="{{ route('siswa.aspirasi.store') }}" enctype="multipart/form-data">
                    @csrf

                    <div class="form-row">

                        {{-- KATEGORI --}}
                        <div class="form-group col-md-6">
                            <label>Kategori</label>
                            <select name="id_kategori" class="form-control" id="kategoriSelect" required>
                                <option value="">-- Pilih Kategori --</option>
                                @foreach($kategoris as $kategori)
                                <option value="{{ $kategori->id_kategori }}"
                                    data-deskripsi="{{ $kategori->deskripsi }}">
                                    {{ $kategori->nama_kategori }}
                                </option>
                                @endforeach
                            </select>
                        </div>

                        {{-- LOKASI --}}
                        <div class="form-group col-md-6">
                            <label>Lokasi</label>
                            <input type="text" name="lokasi" class="form-control"
                                placeholder="Contoh: Ruang Kelas X IPA 1" required>
                        </div>

                    </div>

                    {{-- DESKRIPSI --}}
                    <div class="form-group">
                        <label>Keterangan</label>
                        <textarea name="keterangan" class="form-control" rows="5" required></textarea>
                    </div>

                    {{-- FOTO --}}
                    <div class="form-group">
                        <label>Foto</label>
                        <input type="file" name="foto" class="form-control" id="fotoInput">

                        <div id="imagePreview" class="mt-2" style="display:none;">
                            <img id="previewImg" style="max-width:300px;">
                        </div>
                    </div>

                    <div class="text-right">
                        <button class="btn btn-primary">Kirim Aspirasi</button>
                    </div>

                </form>

            </div>
        </div>

    </div>
</div>
@endsection


@push('scripts')
<script>
    // PREVIEW FOTO
    document.getElementById('fotoInput').addEventListener('change', function(e) {
        const preview = document.getElementById('imagePreview');
        const img = document.getElementById('previewImg');

        if (this.files && this.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                img.src = e.target.result;
                preview.style.display = 'block';
            }
            reader.readAsDataURL(this.files[0]);
        } else {
            preview.style.display = 'none';
        }
    });

    // DESKRIPSI KATEGORI
    const kategoriSelect = document.getElementById('kategoriSelect');
    const kategoriDeskripsi = document.getElementById('kategoriDeskripsi');

    function showKategoriDeskripsi() {
        const selected = kategoriSelect.options[kategoriSelect.selectedIndex];
        const deskripsi = selected.getAttribute('data-deskripsi');

        if (deskripsi && kategoriSelect.value) {
            kategoriDeskripsi.innerText = deskripsi;
        } else {
            kategoriDeskripsi.innerText = '';
        }
    }

    kategoriSelect.addEventListener('change', showKategoriDeskripsi);
    showKategoriDeskripsi();
</script>
@endpush