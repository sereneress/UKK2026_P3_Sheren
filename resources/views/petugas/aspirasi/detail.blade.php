@extends('layouts.petugas')

@section('title', 'Detail Aspirasi')

@section('content')

<style>
    .page-header-custom {
        background: linear-gradient(135deg, #1e3a5f 0%, #2d6a9f 100%);
        border-radius: 12px;
        padding: 24px 28px;
        margin-bottom: 24px;
    }

    .page-header-custom h4 {
        color: #fff;
        margin: 0;
    }

    .page-header-custom p {
        color: rgba(255, 255, 255, 0.7);
        margin: 0;
        font-size: 13px;
    }

    .card-custom {
        border: none;
        border-radius: 12px;
        box-shadow: 0 2px 12px rgba(0, 0, 0, 0.06);
    }

    .detail-table th {
        font-size: 13px;
        color: #6c757d;
        font-weight: 500;
        width: 30%;
        background: #f8fafc;
        padding: 12px 16px;
    }

    .detail-table td {
        font-size: 13px;
        padding: 12px 16px;
        vertical-align: middle;
    }

    .badge-status {
        display: inline-block;
        font-size: 11px;
        padding: 4px 12px;
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

    .section-title {
        font-size: 13px;
        font-weight: 500;
        padding: 12px 1.25rem;
        background: #eff6ff;
        border-bottom: 1px solid #dbeafe;
        color: #1d4ed8;
        border-radius: 12px 12px 0 0;
    }

    .timeline-item {
        border-left: 2px solid #e5e7eb;
        padding-left: 14px;
        margin-bottom: 16px;
        position: relative;
    }

    .timeline-item::before {
        content: '';
        position: absolute;
        left: -5px;
        top: 5px;
        width: 8px;
        height: 8px;
        border-radius: 50%;
        background: #1d4ed8;
    }

    .form-label-custom {
        font-size: 12px;
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
        box-shadow: 0 0 0 2px rgba(45, 106, 159, 0.1);
    }

    .btn-submit {
        background: linear-gradient(135deg, #1e3a5f, #2d6a9f);
        color: #fff;
        border: none;
        border-radius: 8px;
        padding: 9px 18px;
        font-weight: 600;
        font-size: 13px;
    }

    .btn-submit-warning {
        background: linear-gradient(135deg, #b45309, #d97706);
        color: #fff;
        border: none;
        border-radius: 8px;
        padding: 9px 18px;
        font-weight: 600;
        font-size: 13px;
        width: 100%;
    }
</style>

<div class="container-fluid">

    {{-- HEADER --}}
    <div class="page-header-custom">
        <h4>Detail Aspirasi #{{ $aspirasi->id_aspirasi }}</h4>
        <p>Informasi lengkap aspirasi dan kelola tindak lanjut</p>
    </div>

    <div class="row g-3">

        {{-- KIRI: DETAIL + FORM --}}
        <div class="col-xl-8">

            {{-- DETAIL CARD --}}
            <div class="card card-custom mb-3">
                <div class="section-title">Informasi Aspirasi</div>
                <table class="table detail-table mb-0">
                    <tr>
                        <th>Kategori</th>
                        <td>{{ $aspirasi->kategori->nama_kategori ?? '-' }}</td>
                    </tr>
                    <tr>
                        <th>Ruangan</th>
                        <td>{{ $aspirasi->ruangan->nama_ruangan ?? $aspirasi->lokasi }}</td>
                    </tr>
                    <tr>
                        <th>Pengirim</th>
                        <td>
                            @php $pengirim = $aspirasi->user->siswa ?? $aspirasi->user->guru; @endphp
                            <div style="font-weight:500;">{{ $pengirim->nama ?? $aspirasi->user->email }}</div>
                            <div style="font-size:11px; color:#6c757d;">{{ $pengirim->kelas ?? $pengirim->jabatan ?? '-' }}</div>
                        </td>
                    </tr>
                    <tr>
                        <th>Keterangan</th>
                        <td>{{ $aspirasi->keterangan }}</td>
                    </tr>
                    @if($aspirasi->foto)
                    <tr>
                        <th>Foto Awal</th>
                        <td><img src="{{ asset('storage/' . $aspirasi->foto) }}" width="200" class="img-thumbnail" style="border-radius:8px;"></td>
                    </tr>
                    @endif

                    @php
                    $fotoBukti = null;
                    $fotoBuktiKeterangan = null;
                    foreach($aspirasi->progres as $progres) {
                    if(str_contains($progres->keterangan_progres, '📎 Foto bukti:')) {
                    preg_match('/📎 Foto bukti: (.*)/', $progres->keterangan_progres, $matches);
                    if(isset($matches[1])) {
                    $fotoBukti = $matches[1];
                    $fotoBuktiKeterangan = $progres->keterangan_progres;
                    break;
                    }
                    }
                    }
                    @endphp

                    @if($fotoBukti)
                    <tr>
                        <th>Foto Bukti Selesai</th>
                        <td>
                            <img src="{{ $fotoBukti }}" alt="Foto Bukti" width="300" class="img-thumbnail" style="border-radius:8px;">
                            <br><small class="text-muted">Foto bukti penanganan setelah selesai</small>
                            @if($fotoBuktiKeterangan)
                            <br><small class="text-muted">Keterangan: {{ Str::limit(str_replace('📎 Foto bukti: ' . $fotoBukti, '', $fotoBuktiKeterangan), 100) }}</small>
                            @endif
                        </td>
                    </tr>
                    @endif

                    <tr>
                        <th>Status</th>
                        <td>
                            @php
                            $badgeClass = match($aspirasi->status) {
                            'Selesai' => 'badge-selesai',
                            'Proses' => 'badge-proses',
                            default => 'badge-menunggu',
                            };
                            @endphp
                            <span class="badge-status {{ $badgeClass }}">{{ $aspirasi->status }}</span>
                        </td>
                    </tr>
                    <tr>
                        <th>Dibuat Pada</th>
                        <td>{{ $aspirasi->created_at->format('d/m/Y H:i:s') }}</td>
                    </tr>
                    @if($aspirasi->status == 'Selesai')
                    <tr>
                        <th>Selesai Pada</th>
                        <td>{{ $aspirasi->updated_at->format('d/m/Y H:i:s') }}</td>
                    </tr>
                    @endif
                </table>
                <div class="p-3 d-flex justify-content-end">
                    <a href="{{ url()->previous() }}" class="btn btn-sm"
                        style="background:#f1f5f9; color:#334155; border:none; border-radius:8px; font-size:13px; padding:7px 16px;">
                        ← Kembali
                    </a>
                </div>
            </div>

            {{-- FORM KELOLA --}}
            <div class="card card-custom">
                <div class="section-title">Kelola Aspirasi</div>
                <div class="p-4">

                    {{-- FEEDBACK --}}
                    <form action="{{ route('petugas.aspirasi.feedback', $aspirasi->id_aspirasi) }}" method="POST" class="mb-4">
                        @csrf
                        <label class="form-label-custom mb-1 d-block">Feedback untuk Pengirim</label>
                        <textarea name="feedback" class="form-control-custom mb-2" rows="2"
                            placeholder="Tulis feedback untuk pengirim..."></textarea>
                        <button type="submit" class="btn-submit">
                            <i class="fa fa-paper-plane mr-1"></i> Kirim Feedback
                        </button>
                    </form>

                    <hr style="border-color:#f3f4f6;">

                    {{-- UPDATE PROGRES --}}
                    <form action="{{ route('petugas.aspirasi.progres', $aspirasi->id_aspirasi) }}" method="POST" class="mb-4">
                        @csrf
                        <label class="form-label-custom mb-1 d-block">Update Progres Penanganan</label>
                        <textarea name="keterangan_progres" class="form-control-custom mb-2" rows="2"
                            placeholder="Update progres penanganan..."></textarea>
                        <button type="submit" class="btn-submit">
                            <i class="fa fa-sync mr-1"></i> Update Progres
                        </button>
                    </form>

                    <hr style="border-color:#f3f4f6;">

                    {{-- UPDATE STATUS --}}
                    <form action="{{ route('petugas.aspirasi.status', $aspirasi->id_aspirasi) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <label class="form-label-custom mb-1 d-block">Ubah Status <span class="text-danger">*</span></label>
                                <select name="status" class="form-control-custom" id="statusSelect" required>
                                    <option value="Menunggu" {{ $aspirasi->status == 'Menunggu' ? 'selected' : '' }}>Menunggu</option>
                                    <option value="Proses" {{ $aspirasi->status == 'Proses'   ? 'selected' : '' }}>Diproses</option>
                                    <option value="Selesai" {{ $aspirasi->status == 'Selesai'  ? 'selected' : '' }}>Selesai</option>
                                </select>
                            </div>
                            <div class="col-md-12 mb-3">
                                <label class="form-label-custom mb-1 d-block">
                                    Keterangan Penanganan <span class="text-danger" id="keteranganRequired">*</span>
                                </label>
                                <textarea name="keterangan_progres" class="form-control-custom" rows="3"
                                    id="keteranganText"
                                    placeholder="Jelaskan tindakan yang telah dilakukan..."></textarea>
                                <small class="text-muted" style="font-size:11px;">Isikan keterangan detail tentang penanganan aspirasi</small>
                            </div>
                            <div class="col-md-12 mb-3">
                                <label class="form-label-custom mb-1 d-block">
                                    Foto Bukti Penanganan <span class="text-danger" id="fotoRequired">*</span>
                                </label>
                                <input type="file" name="foto_bukti" class="form-control-custom" id="fotoBukti"
                                    accept="image/jpeg,image/png,image/jpg">
                                <small class="text-muted" style="font-size:11px;">Upload foto bukti setelah selesai menangani (max 2MB)</small>
                                <div id="fotoPreview" class="mt-2" style="display:none;">
                                    <img id="previewImg" src="#" alt="Preview"
                                        style="max-width:100%; border-radius:8px;">
                                </div>
                            </div>
                        </div>

                        <div class="alert alert-warning" id="warningAlert" style="display:none; border-radius:8px; font-size:13px;">
                            <strong>Perhatian!</strong> Mengubah status menjadi <strong>Selesai</strong> akan memindahkan aspirasi ini ke History.
                            Pastikan Anda mengisi keterangan dan upload foto bukti penanganan.
                        </div>

                        <button type="submit" class="btn-submit-warning" id="submitBtn">
                            Update Status
                        </button>
                    </form>

                </div>
            </div>

        </div>

        {{-- KANAN: RIWAYAT --}}
        <div class="col-xl-4">

            {{-- RIWAYAT PROGRES --}}
            <div class="card card-custom mb-3">
                <div class="section-title">Riwayat Progres</div>
                <div class="p-3" style="max-height: 320px; overflow-y: auto;">
                    @forelse($aspirasi->progres as $progres)
                    <div class="timeline-item">
                        <small class="text-muted">{{ $progres->created_at->format('d/m/Y H:i') }}</small>
                        <p class="mb-0" style="font-size:13px;">
                            {!! nl2br(e($progres->keterangan_progres)) !!}
                        </p>
                        <small class="text-muted">
                            — {{ $progres->user?->petugas?->nama 
                    ?? $progres->user?->guru?->nama 
                    ?? $progres->user?->email 
                    ?? '-' }}
                        </small>
                    </div>
                    @empty
                    <p class="text-muted text-center" style="font-size:13px;">Belum ada progres</p>
                    @endforelse
                </div>
            </div>


            {{-- RIWAYAT STATUS --}}
            <div class="card card-custom">
                <div class="section-title">Riwayat Status</div>
                <div class="p-3" style="max-height: 320px; overflow-y: auto;">
                    @forelse($aspirasi->historyStatus as $history)
                    <div class="timeline-item">
                        <small class="text-muted">
                            {{ $history->created_at->format('d/m/Y H:i') }}
                        </small>

                        <p class="mb-0" style="font-size:13px;">
                            {{ $history->status_lama }} →
                            <strong>{{ $history->status_baru }}</strong>
                        </p>

                        <small class="text-muted">
                            — {{ $history->pengubah?->petugas?->nama 
                    ?? $history->pengubah?->guru?->nama 
                    ?? $history->pengubah?->email 
                    ?? '-' }}
                        </small>
                    </div>
                    @empty
                    <p class="text-muted text-center" style="font-size:13px;">Belum ada riwayat</p>
                    @endforelse
                </div>
            </div>

            {{-- RIWAYAT STATUS --}}
            <div class="card card-custom">
                <div class="section-title">Riwayat Status</div>
                <div class="p-3" style="max-height: 320px; overflow-y: auto;">
                    @forelse($aspirasi->historyStatus as $history)
                    <div class="timeline-item">
                        <small class="text-muted">{{ $history->created_at->format('d/m/Y H:i') }}</small>
                        <p class="mb-0" style="font-size:13px;">
                            {{ $history->status_lama }} → <strong>{{ $history->status_baru }}</strong>
                        </p>
                        <small class="text-muted">
                            — {{ $history->pengubah?->petugas?->nama 
    ?? $history->pengubah?->guru?->nama 
    ?? $history->pengubah?->email 
    ?? '-' }}
                        </small>
                    </div>
                    @empty
                    <p class="text-muted text-center" style="font-size:13px;">Belum ada riwayat</p>
                    @endforelse
                </div>
            </div>

        </div>

    </div>
</div>

@push('scripts')
<script>
    // Preview foto
    document.getElementById('fotoBukti').addEventListener('change', function() {
        const preview = document.getElementById('fotoPreview');
        const img = document.getElementById('previewImg');
        if (this.files && this.files[0]) {
            const reader = new FileReader();
            reader.onload = e => {
                img.src = e.target.result;
                preview.style.display = 'block';
            };
            reader.readAsDataURL(this.files[0]);
        } else {
            preview.style.display = 'none';
        }
    });

    const statusSelect = document.getElementById('statusSelect');
    const warningAlert = document.getElementById('warningAlert');
    const keteranganRequired = document.getElementById('keteranganRequired');
    const fotoRequired = document.getElementById('fotoRequired');
    const keteranganText = document.getElementById('keteranganText');
    const fotoBukti = document.getElementById('fotoBukti');
    const submitBtn = document.getElementById('submitBtn');

    function checkStatus() {
        const isSelesai = statusSelect.value === 'Selesai';
        warningAlert.style.display = isSelesai ? 'block' : 'none';
        keteranganText.required = isSelesai;
        fotoBukti.required = isSelesai;
        keteranganRequired.style.display = isSelesai ? 'inline' : 'none';
        fotoRequired.style.display = isSelesai ? 'inline' : 'none';
        if (!isSelesai) {
            keteranganText.classList.remove('is-invalid');
            fotoBukti.classList.remove('is-invalid');
        }
    }

    statusSelect.addEventListener('change', checkStatus);

    submitBtn.addEventListener('click', function(e) {
        if (statusSelect.value === 'Selesai') {
            if (!keteranganText.value.trim()) {
                e.preventDefault();
                keteranganText.classList.add('is-invalid');
                alert('Harap isi keterangan penanganan!');
                return false;
            }
            if (!fotoBukti.files.length) {
                e.preventDefault();
                fotoBukti.classList.add('is-invalid');
                alert('Harap upload foto bukti penanganan!');
                return false;
            }
        }
    });

    checkStatus();
</script>
@endpush

@endsection