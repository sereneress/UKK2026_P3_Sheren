@extends('layouts.admin')

@section('title', 'Sheren Alivia')

@section('content')
<div class="row">
    <!-- TOTAL SISWA -->
    <div class="col-xl-3 col-lg-6 col-md-6 col-sm-12">
        <div class="card">
            <h5 class="card-header">Total Siswa</h5>
            <div class="card-body">
                <div class="metric-value d-inline-block">
                    <h1 class="mb-1">{{ $totalSiswa }}</h1>
                </div>
                <div class="metric-label d-inline-block float-right text-success font-weight-bold">
                    <span class="icon-circle-small icon-box-xs text-success bg-success-light">
                        <i class="fa fa-users"></i>
                    </span>
                </div>
            </div>
        </div>
    </div>

    <!-- TOTAL GURU -->
    <div class="col-xl-3 col-lg-6 col-md-6 col-sm-12">
        <div class="card">
            <h5 class="card-header">Total Guru</h5>
            <div class="card-body">
                <div class="metric-value d-inline-block">
                    <h1 class="mb-1">{{ $totalGuru }}</h1>
                </div>
                <div class="metric-label d-inline-block float-right text-primary font-weight-bold">
                    <span class="icon-circle-small icon-box-xs text-primary bg-light">
                        <i class="fa fa-chalkboard-teacher"></i>
                    </span>
                </div>
            </div>
        </div>
    </div>

    <!-- TOTAL ASPIRASI -->
    <div class="col-xl-3 col-lg-6 col-md-6 col-sm-12">
        <div class="card">
            <h5 class="card-header">Total Aspirasi</h5>
            <div class="card-body">
                <div class="metric-value d-inline-block">
                    <h1 class="mb-1">{{ $totalAspirasi }}</h1>
                </div>
                <div class="metric-label d-inline-block float-right text-warning font-weight-bold">
                    <span class="icon-circle-small icon-box-xs text-warning bg-light">
                        <i class="fa fa-comments"></i>
                    </span>
                </div>
            </div>
        </div>
    </div>

    <!-- TOTAL ADMIN -->
    <div class="col-xl-3 col-lg-6 col-md-6 col-sm-12">
        <div class="card">
            <h5 class="card-header">Total Admin</h5>
            <div class="card-body">
                <div class="metric-value d-inline-block">
                    <h1 class="mb-1">{{ $totalAdmin }}</h1>
                </div>
                <div class="metric-label d-inline-block float-right text-info font-weight-bold">
                    <span class="icon-circle-small icon-box-xs text-info bg-light">
                        <i class="fa fa-user-shield"></i>
                    </span>
                </div>
            </div>
        </div>
    </div>

</div>
<div class="row">

    <!-- STATUS ASPIRASI -->
    <div class="col-xl-6 col-lg-12 col-md-12 col-sm-12 col-12">
        <div class="card">
            <h5 class="card-header">Status Aspirasi</h5>
            <div class="card-body">

                <!-- MENUNGGU -->
                <div class="d-flex justify-content-between mb-2">
                    <span>Menunggu</span>
                    <span class="badge bg-warning">{{ $aspirasiMenunggu }}</span>
                </div>
                <div class="progress mb-3">
                    <div class="progress-bar bg-warning"
                        style="width: {{ $totalAspirasi > 0 ? ($aspirasiMenunggu/$totalAspirasi)*100 : 0 }}%">
                    </div>
                </div>

                <!-- DIPROSES -->
                <div class="d-flex justify-content-between mb-2">
                    <span>Diproses</span>
                    <span class="badge bg-info">{{ $aspirasiProses }}</span>
                </div>
                <div class="progress mb-3">
                    <div class="progress-bar bg-info"
                        style="width: {{ $totalAspirasi > 0 ? ($aspirasiProses/$totalAspirasi)*100 : 0 }}%">
                    </div>
                </div>

                <!-- SELESAI -->
                <div class="d-flex justify-content-between mb-2">
                    <span>Selesai</span>
                    <span class="badge bg-success">{{ $aspirasiSelesai }}</span>
                </div>
                <div class="progress mb-3">
                    <div class="progress-bar bg-success"
                        style="width: {{ $totalAspirasi > 0 ? ($aspirasiSelesai/$totalAspirasi)*100 : 0 }}%">
                    </div>
                </div>

            </div>
        </div>
    </div>

</div>
                <div class="card">
                    <div class="card-header">
                        <h5>Selamat Datang, {{ Auth::user()->email }}</h5>
                    </div>
                    <div class="card-body">
                        <p>
                            Anda login sebagai 
                            <strong>{{ ucfirst(Auth::user()->role) }}</strong>.
                            Silakan kelola data sesuai menu yang tersedia.
                        </p>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection

<!-- @section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
document.addEventListener("DOMContentLoaded", function () {

    const ctx = document.getElementById('aspirasiChart');

    if (ctx) {
        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: {!! json_encode($bulanLabels ?? []) !!},
                datasets: [{
                    label: 'Jumlah Aspirasi',
                    data: {!! json_encode($bulanData ?? []) !!},
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        display: true
                    }
                }
            }
        });
    }

});
</script> -->
@endsection
