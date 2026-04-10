@extends('layouts.admin')

@section('title', 'Data Aspirasi Aktif')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">

            <div class="card-header">
                <h5>Data Aspirasi Aktif</h5>
                <small class="text-muted">Aspirasi yang belum selesai</small>
            </div>

            <div class="card-body">

                {{-- FILTER --}}
                <form method="GET" class="mb-4">
                    <div class="row g-3">

                        <div class="col-md-3">
                            <label>Status</label>
                            <select name="status" class="form-select">
                                <option value="">Semua</option>
                                <option value="Menunggu" {{ request('status')=='Menunggu'?'selected':'' }}>Menunggu</option>
                                <option value="Proses" {{ request('status')=='Proses'?'selected':'' }}>Proses</option>
                            </select>
                        </div>

                        <div class="col-md-3">
                            <label>Kategori</label>
                            <select name="kategori" class="form-select">
                                <option value="">Semua</option>
                                @foreach($kategoris as $kategori)
                                <option value="{{ $kategori->id_kategori }}"
                                    {{ request('kategori')==$kategori->id_kategori?'selected':'' }}>
                                    {{ $kategori->nama_kategori }}
                                </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-4">
                            <label>Cari</label>
                            <input type="text" name="search" class="form-control"
                                placeholder="Cari lokasi..."
                                value="{{ request('search') }}">
                        </div>

                        <div class="col-md-2">
                            <label>&nbsp;</label>
                            <button class="btn btn-primary w-100">Filter</button>
                        </div>

                    </div>
                </form>

                {{-- TABLE --}}
                <div class="table-responsive">
                    <table class="table table-bordered table-hover">

                        <thead class="table-light">
                            <tr>
                                <th>No</th>
                                <th>Tanggal</th>
                                <th>Siswa</th>
                                <th>Kategori</th>
                                <th>Lokasi</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>

                        <tbody>
                            @forelse($aspirasi as $index => $item)
                            <tr>

                                <td>{{ $index + $aspirasi->firstItem() }}</td>

                                <td>{{ $item->created_at->format('d/m/Y H:i') }}</td>

                                <td>
                                    <strong>{{ $item->user->siswa->nama ?? '-' }}</strong><br>
                                    <small>NIS: {{ $item->user->siswa->nis ?? '-' }}</small>
                                </td>

                                <td>{{ $item->kategori->nama_kategori ?? '-' }}</td>

                                <td>{{ Str::limit($item->lokasi, 30) }}</td>

                                <td>
                                    @if($item->status == 'Menunggu')
                                    <span class="badge bg-warning text-dark">Menunggu</span>
                                    @else
                                    <span class="badge bg-info">Proses</span>
                                    @endif
                                </td>

                                <td>
                                    <a href="{{ route('guru.aspirasi.detail', $item->id_aspirasi) }}"
                                        class="btn btn-info btn-sm">
                                        Detail
                                    </a>

                                    @if($item->status == 'Proses')
                                    <button class="btn btn-success btn-sm"
                                        data-toggle="modal"
                                        data-bs-target="#selesai{{ $item->id_aspirasi }}">
                                        Selesai
                                    </button>
                                    @endif

                                    <button class="btn btn-danger btn-sm"
                                        data-toggle="modal"
                                        data-bs-target="#delete{{ $item->id_aspirasi }}">
                                        Hapus
                                    </button>
                                </td>

                            </tr>

                            {{-- MODAL SELESAI --}}
                            @if($item->status == 'Proses')
                            <div class="modal fade" id="selesai{{ $item->id_aspirasi }}">
                                <div class="modal-dialog">
                                    <div class="modal-content">

                                        <div class="modal-header bg-success text-white">
                                            <h5>Selesaikan Aspirasi</h5>
                                        </div>

                                        <div class="modal-body">
                                            Yakin ingin menyelesaikan?
                                            <br>
                                            <strong>{{ $item->lokasi }}</strong>
                                        </div>

                                        <div class="modal-footer">
                                            <button class="btn btn-secondary"
                                                data-bs-dismiss="modal">Batal</button>

                                            <a href="{{ route('guru.aspirasi.selesai',$item->id_aspirasi) }}"
                                                class="btn btn-success">
                                                Ya, Selesai
                                            </a>
                                        </div>

                                    </div>
                                </div>
                            </div>
                            @endif

                            {{-- MODAL DELETE --}}
                            <div class="modal fade" id="delete{{ $item->id_aspirasi }}">
                                <div class="modal-dialog">
                                    <div class="modal-content">

                                        <div class="modal-header bg-danger text-white">
                                            <h5>Hapus Aspirasi</h5>
                                        </div>

                                        <div class="modal-body text-center">
                                            Yakin hapus?
                                            <br>
                                            <strong>{{ $item->lokasi }}</strong>
                                        </div>

                                        <div class="modal-footer">
                                            <button class="btn btn-secondary"
                                                data-bs-dismiss="modal">Batal</button>

                                            <form action="{{ route('guru.aspirasi.destroy',$item->id_aspirasi) }}"
                                                method="POST">
                                                @csrf
                                                @method('DELETE')

                                                <button class="btn btn-danger">
                                                    Hapus
                                                </button>
                                            </form>
                                        </div>

                                    </div>
                                </div>
                            </div>

                            @empty
                            <tr>
                                <td colspan="7" class="text-center">
                                    Semua aspirasi sudah selesai
                                </td>
                            </tr>
                            @endforelse
                        </tbody>

                    </table>
                </div>

                {{-- PAGINATION --}}
                <div class="mt-3 d-flex justify-content-center">
                    {{ $aspirasi->links() }}
                </div>

            </div>
        </div>
    </div>
</div>
@endsection