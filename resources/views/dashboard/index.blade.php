@extends('layoutss.app')

@section('content')
<!-- Content Wrapper -->
<div id="content-wrapper" class="d-flex flex-column">
    <!-- Main Content -->
    <div id="content">
        <!-- Begin Page Content -->
        <div class="container-fluid">
<div class="container-fluid px-4">
    <!-- Top Navigation -->
    <div class="d-flex justify-content-between align-items-center py-3 mb-4 border-bottom">
        <h1 class="h3 mb-0 text-primary">
            <i class="fas fa-tachometer-alt me-2"></i>Dashboard Admin
        </h1>
        <button class="btn btn-outline-danger">
            <i class="fas fa-sign-out-alt me-1"></i> Keluar
        </button>
    </div>

    <!-- Filter Card -->
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0"><i class="fas fa-filter me-2"></i> Filter Data</h5>
        </div>
        <div class="card-body">
            <form method="GET" action="{{ route('dashboard') }}">
                <div class="row g-3">
                    <div class="col-md-4">
                        <label class="form-label">Program Studi</label>
                        @php
                            $prodis = ['D4 TI', 'D4 SIB', 'D2 PPLS', 'S2 MRTI'];
                            $selectedProdi = request('program_studi', 'D4 TI');
                        @endphp
                        <select name="program_studi" class="form-select">
                            @foreach ($prodis as $prodi)
                                <option value="{{ $prodi }}" {{ $selectedProdi == $prodi ? 'selected' : '' }}>{{ $prodi }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Tahun Mulai</label>
                        @php
                            $tahunSekarang = date('Y');
                            $tahunAwalDefault = request('tahun_awal', $tahunSekarang - 3);
                        @endphp
                        <input type="number" name="tahun_awal" class="form-control" value="{{ $tahunAwalDefault }}">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Tahun Akhir</label>
                        @php
                            $tahunAkhirDefault = request('tahun_akhir', $tahunSekarang);
                        @endphp
                        <input type="number" name="tahun_akhir" class="form-control" value="{{ $tahunAkhirDefault }}">
                    </div>
                    <div class="col-12 text-end">
                        <button type="submit" class="btn btn-primary px-4">
                            <i class="fas fa-sync-alt me-2"></i> Terapkan
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Info Alert -->
    <div class="alert alert-info mb-4">
        <i class="fas fa-info-circle me-2"></i> 
        Menampilkan data untuk <strong>{{ $selectedProdi }}</strong> tahun <strong>{{ $tahunAwalDefault }} - {{ $tahunAkhirDefault }}</strong>
    </div>

    <!-- Stats Cards -->
    <div class="row g-4 mb-4">
        <div class="col-md-4">
            <div class="card border-0 bg-gradient-secondary text-white shadow-sm">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h6 class="text-uppercase">Total Lulusan</h6>
                            <h2 class="mb-0">834</h2>
                        </div>
                        <i class="fas fa-graduation-cap fa-2x opacity-50"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-0 bg-gradient-success text-white shadow-sm">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h6 class="text-uppercase">Terlacak</h6>
                            <h2 class="mb-0">389</h2>
                        </div>
                        <i class="fas fa-search fa-2x opacity-50"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-0 bg-gradient-info text-white shadow-sm">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h6 class="text-uppercase">Waktu Tunggu</h6>
                            <h2 class="mb-0">4.8 <small>bulan</small></h2>
                        </div>
                        <i class="fas fa-clock fa-2x opacity-50"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Charts -->
    <div class="row g-4 mb-4">
        <!-- Profession Chart -->
        <div class="col-lg-6">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-white border-bottom">
                    <h5 class="mb-0 text-primary"><i class="fas fa-briefcase me-2"></i> Profesi Lulusan</h5>
                </div>
                <div class="card-body">
                    <div class="chart-container position-relative" style="height:300px">
                        <canvas id="professionChart"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <!-- Institution Chart -->
        <div class="col-lg-6">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-white border-bottom">
                    <h5 class="mb-0 text-primary"><i class="fas fa-building me-2"></i> Jenis Instansi</h5>
                </div>
                <div class="card-body">
                    <div class="chart-container position-relative" style="height:300px">
                        <canvas id="institutionChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Workplace Distribution Table -->
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-header bg-white border-bottom">
            <h5 class="mb-0 text-primary"><i class="fas fa-map-marker-alt me-2"></i> Sebaran Lingkup Tempat Kerja</h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead class="table-light">
                        <tr>
                            <th rowspan="2">Tahun</th>
                            <th rowspan="2">Lulusan</th>
                            <th rowspan="2">Terlacak</th>
                            <th colspan="2" class="text-center">Profesi Kerja</th>
                            <th colspan="3" class="text-center">Lingkup Kerja</th>
                        </tr>
                        <tr>
                            <th>Infokom</th>
                            <th>Non-Infokom</th>
                            <th>Internasional</th>
                            <th>Nasional</th>
                            <th>Wirausaha</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>2021</td>
                            <td>213</td>
                            <td>64</td>
                            <td>46</td>
                            <td>18</td>
                            <td>0</td>
                            <td>63</td>
                            <td>1</td>
                        </tr>
                        <tr>
                            <td>2022</td>
                            <td>188</td>
                            <td>115</td>
                            <td>73</td>
                            <td>42</td>
                            <td>4</td>
                            <td>108</td>
                            <td>3</td>
                        </tr>
                        <tr>
                            <td>2023</td>
                            <td>233</td>
                            <td>98</td>
                            <td>70</td>
                            <td>28</td>
                            <td>2</td>
                            <td>90</td>
                            <td>6</td>
                        </tr>
                        <tr>
                            <td>2024</td>
                            <td>200</td>
                            <td>112</td>
                            <td>82</td>
                            <td>30</td>
                            <td>3</td>
                            <td>107</td>
                            <td>2</td>
                        </tr>
                        <tr class="table-active fw-bold">
                            <td>Total</td>
                            <td>834</td>
                            <td>389</td>
                            <td>271</td>
                            <td>118</td>
                            <td>9</td>
                            <td>368</td>
                            <td>12</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Waiting Time Table -->
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-header bg-white border-bottom">
            <h5 class="mb-0 text-primary"><i class="fas fa-clock me-2"></i> Rata-Rata Masa Tunggu</h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead class="table-light">
                        <tr>
                            <th>Tahun</th>
                            <th>Lulusan</th>
                            <th>Terlacak</th>
                            <th>Rata-rata Waktu Tunggu (Bulan)</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>2021</td>
                            <td>213</td>
                            <td>64</td>
                            <td>4.92</td>
                        </tr>
                        <tr>
                            <td>2022</td>
                            <td>188</td>
                            <td>115</td>
                            <td>4.77</td>
                        </tr>
                        <tr>
                            <td>2023</td>
                            <td>233</td>
                            <td>98</td>
                            <td>3.38</td>
                        </tr>
                        <tr>
                            <td>2024</td>
                            <td>200</td>
                            <td>112</td>
                            <td>6.01</td>
                        </tr>
                        <tr class="table-active fw-bold">
                            <td>Total</td>
                            <td>834</td> <!-- Total Lulusan -->
                            <td>389</td> <!-- Total Terlacak -->
                            <td>4.77</td> <!-- Average Waktu Tunggu (per your calculation) -->
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Satisfaction Charts -->
    <div class="row g-4">
        @php
            $satisfactionCharts = [
                ['title' => 'Kerjasama Tim', 'icon' => 'users', 'color' => 'primary'],
                ['title' => 'Keahlian TI', 'icon' => 'laptop-code', 'color' => 'success'],
                ['title' => 'Bahasa Inggris', 'icon' => 'language', 'color' => 'info'],
                ['title' => 'Komunikasi', 'icon' => 'comments', 'color' => 'warning'],
                ['title' => 'Pengembangan Diri', 'icon' => 'user-graduate', 'color' => 'danger'],
                ['title' => 'Kepemimpinan', 'icon' => 'chess-king', 'color' => 'secondary'],
                ['title' => 'Etos Kerja', 'icon' => 'business-time', 'color' => 'dark']
            ];
        @endphp

        @foreach($satisfactionCharts as $index => $chart)
        <div class="col-xl-4 col-lg-4 col-md-6">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-white border-bottom">
                    <h5 class="mb-0 text-{{ $chart['color'] }}">
                        <i class="fas fa-{{ $chart['icon'] }} me-2"></i> {{ $chart['title'] }}
                    </h5>
                </div>
                <div class="card-body">
                    <div class="chart-container" style="height:200px">
                        <canvas id="chart{{ $index }}"></canvas>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>

<!-- Chart JS -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener("DOMContentLoaded", function() {
    // Color system
    const colors = {
        primary: '#4e73df',
        success: '#1cc88a',
        info: '#36b9cc',
        warning: '#f6c23e',
        danger: '#e74a3b',
        secondary: '#858796',
        dark: '#5a5c69'
    };

    // Profession Chart (Pie)
    new Chart(document.getElementById('professionChart'), {
        type: 'pie',
        data: {
            labels: ['Software Engineer', 'Staff IT', 'Administrator', 'Pengajar', 'Teknisi', 'Product QA', 'Customer Service', 'Data Analyst', 'Marketing', 'Pemilik Usaha', 'Lainnya'],
            datasets: [{
                data: [31,16.6,6.2,4.1,2.1,3.4,2.1,2.1,3.4,3.4,25.5],
                backgroundColor: [
                    colors.primary, colors.success, colors.info, colors.warning, colors.danger,
                    colors.secondary, colors.dark, '#f8f9fc', '#2e59d9', '#17a673', '#2c9faf'
                ],
                borderWidth: 1,
                borderColor: '#fff'
            }]
        },
        options: {
            plugins: {
                legend: { display: false },
                tooltip: {
                    callbacks: {
                        label: ctx => `${ctx.label}: ${ctx.raw}%`
                    }
                }
            }
        }
    });

    // Institution Chart (Pie)
    new Chart(document.getElementById('institutionChart'), {
        type: 'pie',
        data: {
            labels: ['Pendidikan Tinggi', 'Instansi Pemerintah', 'Perusahaan Swasta', 'BUMN'],
            datasets: [{
                data: [10, 20, 60, 10],
                backgroundColor: [
                    colors.primary, colors.success, colors.info, colors.warning
                ],
                borderWidth: 1,
                borderColor: '#fff'
            }]
        },
        options: {
            plugins: {
                legend: { display: false },
                tooltip: {
                    callbacks: {
                        label: ctx => `${ctx.label}: ${ctx.raw}%`
                    }
                }
            }
        }
    });

    // Satisfaction Charts (All Pie)
    const satisfactionData = [
        [36.32, 51.58, 9.47, 2.63],
        [41.05, 49.47, 7.37, 2.11],
        [25.79, 55.79, 12.11, 6.32],
        [57.37, 35.26, 4.74, 2.63],
        [40.53, 46.32, 9.47, 3.68],
        [43.68, 45.26, 7.89, 3.16],
        [34.21, 57.37, 6.32, 2.11]
    ];

    satisfactionData.forEach((data, i) => {
        new Chart(document.getElementById(`chart${i}`), {
            type: 'pie',
            data: {
                labels: ['Sangat Baik', 'Baik', 'Cukup', 'Kurang'],
                datasets: [{
                    data: data,
                    backgroundColor: [
                        colors.primary, colors.success, colors.warning, colors.danger
                    ],
                    borderWidth: 1,
                    borderColor: '#fff'
                }]
            },
            options: {
                plugins: {
                    legend: { display: false },
                    tooltip: {
                        callbacks: {
                            label: ctx => `${ctx.label}: ${ctx.raw}%`
                        }
                    }
                }
            }
        });
    });
});
</script>
@endsection