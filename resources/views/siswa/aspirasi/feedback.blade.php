@extends('layouts.admin')
@section('title', 'Feedback Aspirasi')
@section('content')
<div class="row">
    <div class="col-xl-12">
        <div class="page-header">
            <h2 class="pageheader-title">Feedback Aspirasi</h2>
            <p class="pageheader-text">Berikan penilaian terhadap tanggapan yang telah diberikan.</p>
            <div class="page-breadcrumb">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('siswa.dashboard') }}" class="breadcrumb-link">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('siswa.aspirasi.index') }}" class="breadcrumb-link">Aspirasi</a></li>
                        <li class="breadcrumb-item active">Feedback</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</div>

<div class="row justify-content-center">
    <div class="col-xl-7 col-lg-8 col-md-12">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Form Feedback</h5>
            </div>
            <div class="card-body">
                {{-- Aspirasi Summary --}}
                <div class="p-3 bg-light rounded mb-4">
                    <h6 class="font-weight-bold">{{ $aspirasi->judul }}</h6>
                    <p class="text-muted small mb-1">Kategori: {{ $aspirasi->kategori->nama ?? '-' }}</p>
                    @if($aspirasi->tanggapan)
                    <p class="mb-0 small"><strong>Tanggapan guru:</strong> {{ Str::limit($aspirasi->tanggapan, 120) }}</p>
                    @endif
                </div>

                <form action="{{ route('siswa.aspirasi.feedback.store', $aspirasi->id) }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label class="font-weight-bold">Rating Kepuasan</label>
                        <div class="d-flex mt-2" id="rating-group">
                            @for($i = 1; $i <= 5; $i++)
                            <div class="mr-3 text-center">
                                <input type="radio" name="rating" id="rating{{ $i }}" value="{{ $i }}"
                                    class="d-none" {{ old('rating') == $i ? 'checked' : '' }} required>
                                <label for="rating{{ $i }}" class="fa fa-star fa-2x text-muted cursor-pointer rating-star"
                                    data-value="{{ $i }}" style="cursor:pointer;"></label>
                                <p class="small text-muted mt-1">{{ $i }}</p>
                            </div>
                            @endfor
                        </div>
                        @error('rating')<div class="text-danger small">{{ $message }}</div>@enderror
                    </div>

                    <div class="form-group">
                        <label for="komentar" class="font-weight-bold">Komentar (opsional)</label>
                        <textarea class="form-control @error('komentar') is-invalid @enderror"
                            id="komentar" name="komentar" rows="4"
                            placeholder="Tuliskan pendapat Anda tentang penanganan aspirasi ini...">{{ old('komentar') }}</textarea>
                        @error('komentar')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="d-flex justify-content-between">
                        <a href="{{ route('siswa.aspirasi.show', $aspirasi->id) }}" class="btn btn-secondary">
                            <i class="fa fa-arrow-left mr-2"></i>Kembali
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="fa fa-paper-plane mr-2"></i>Kirim Feedback
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
    const stars = document.querySelectorAll('.rating-star');
    stars.forEach(star => {
        star.addEventListener('click', function() {
            const val = parseInt(this.dataset.value);
            document.getElementById('rating' + val).checked = true;
            stars.forEach((s, i) => {
                s.classList.toggle('text-warning', i < val);
                s.classList.toggle('text-muted', i >= val);
            });
        });
        star.addEventListener('mouseover', function() {
            const val = parseInt(this.dataset.value);
            stars.forEach((s, i) => {
                s.classList.toggle('text-warning', i < val);
                s.classList.toggle('text-muted', i >= val);
            });
        });
    });
</script>
@endpush