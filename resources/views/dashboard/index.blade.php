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
                        <button id="logoutButton" class="btn btn-outline-danger">
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
                                            $prodis = \App\Models\ProgramStudi::all();
                                            $selectedProdi = request('program_studi', $prodis->first()->id ?? 1);
                                        @endphp
                                        <select name="program_studi" class="form-select">
                                            @foreach ($prodis as $prodi)
                                                <option value="{{ $prodi->id }}"
                                                    {{ $selectedProdi == $prodi->id ? 'selected' : '' }}>
                                                    {{ $prodi->nama }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label">Tahun Mulai</label>
                                        @php
                                            $tahunSekarang = date('Y');
                                            $tahunAwalDefault = request('tahun_awal', $tahunSekarang - 3);
                                        @endphp
                                        <input type="number" name="tahun_awal" class="form-control"
                                            value="{{ $tahunAwalDefault }}">
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label">Tahun Akhir</label>
                                        @php
                                            $tahunAkhirDefault = request('tahun_akhir', $tahunSekarang);
                                        @endphp
                                        <input type="number" name="tahun_akhir" class="form-control"
                                            value="{{ $tahunAkhirDefault }}">
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
                        Menampilkan data untuk
                        <strong>{{ \App\Models\ProgramStudi::find($selectedProdi)->nama ?? 'Semua Program Studi' }}</strong>
                        tahun <strong>{{ $tahunAwalDefault }} - {{ $tahunAkhirDefault }}</strong>
                    </div>

                    @php
                        // Hitung rata-rata masa tunggu keseluruhan dari $waktuTungguData
                        $totalWaktuTunggu = 0;
                        $countTahun = 0;
                        foreach ($waktuTungguData as $item) {
                            $totalWaktuTunggu += $item->rata_waktu_tunggu ?? 0;
                            $countTahun++;
                        }
                        $rataRataKeseluruhan = $countTahun > 0 ? $totalWaktuTunggu / $countTahun : 0;
                    @endphp

                    <!-- Stats Cards -->
                    <div class="row g-4 mb-4">
                        <div class="col-md-4">
                            <div class="card border-0 bg-gradient-secondary text-white shadow-sm">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between">
                                        <div>
                                            <h6 class="text-uppercase">Total Lulusan</h6>
                                            <h2 class="mb-0">{{ $totalLulusan }}</h2>
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
                                            <h2 class="mb-0">{{ $totalTerlacak }}</h2>
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
                                            <h2 class="mb-0">{{ number_format($rataRataKeseluruhan, 1) }}
                                                <small>bulan</small>
                                            </h2>
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
                            <h5 class="mb-0 text-primary"><i class="fas fa-map-marker-alt me-2"></i> Sebaran Lingkup Tempat
                                Kerja</h5>
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
                                            <th>Multinasional</th>
                                            <th>Nasional</th>
                                            <th>Wirausaha</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                            $totalLulusanSum = 0;
                                            $totalTerlacakSum = 0;
                                            $totalInfokomSum = 0;
                                            $totalNonInfokomSum = 0;
                                            $totalInternasionalSum = 0;
                                            $totalNasionalSum = 0;
                                            $totalWirausahaSum = 0;
                                        @endphp

                                        @forelse ($tabelLingkupKerja as $item)
                                            @php
                                                $totalLulusanSum += $item->total_lulusan ?? 0;
                                                $totalTerlacakSum += $item->total_terlacak ?? 0;
                                                $totalInfokomSum += $item->infokom ?? 0;
                                                $totalNonInfokomSum += $item->non_infokom ?? 0;
                                                $totalInternasionalSum += $item->internasional ?? 0;
                                                $totalNasionalSum += $item->nasional ?? 0;
                                                $totalWirausahaSum += $item->wirausaha ?? 0;
                                            @endphp
                                            <tr>
                                                <td>{{ $item->tahun }}</td>
                                                <td>{{ number_format($item->total_lulusan ?? 0) }}</td>
                                                <td>{{ number_format($item->total_terlacak ?? 0) }}</td>
                                                <td>{{ number_format($item->infokom ?? 0) }}</td>
                                                <td>{{ number_format($item->non_infokom ?? 0) }}</td>
                                                <td>{{ number_format($item->internasional ?? 0) }}</td>
                                                <td>{{ number_format($item->nasional ?? 0) }}</td>
                                                <td>{{ number_format($item->wirausaha ?? 0) }}</td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="8" class="text-center text-muted">Tidak ada data tersedia
                                                </td>
                                            </tr>
                                        @endforelse

                                        @if ($tabelLingkupKerja->count() > 0)
                                            <tr class="table-active fw-bold">
                                                <td>Total</td>
                                                <td>{{ number_format($totalLulusanSum) }}</td>
                                                <td>{{ number_format($totalTerlacakSum) }}</td>
                                                <td>{{ number_format($totalInfokomSum) }}</td>
                                                <td>{{ number_format($totalNonInfokomSum) }}</td>
                                                <td>{{ number_format($totalInternasionalSum) }}</td>
                                                <td>{{ number_format($totalNasionalSum) }}</td>
                                                <td>{{ number_format($totalWirausahaSum) }}</td>
                                            </tr>
                                        @endif
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
                                        @php
                                            $totalLulusanWaktu = 0;
                                            $totalTerlacakWaktu = 0;
                                            $totalWaktuTunggu = 0;
                                            $countTahun = 0;
                                        @endphp

                                        @forelse ($waktuTungguData as $item)
                                            @php
                                                $totalLulusanWaktu += $item->total_lulusan ?? 0;
                                                $totalTerlacakWaktu += $item->total_terlacak ?? 0; // Fix: seharusnya menggunakan data terlacak yang sesuai
                                                $waktuTunggu = $item->rata_waktu_tunggu ?? 0;
                                                $totalWaktuTunggu += $waktuTunggu;
                                                $countTahun++;
                                            @endphp
                                            <tr>
                                                <td>{{ $item->tahun }}</td>
                                                <td>{{ number_format($item->total_lulusan ?? 0) }}</td>
                                                <td>{{ number_format($item->total_terlacak ?? 0) }}</td>
                                                <!-- Perbaiki: gunakan $item->total_terlacak -->
                                                <td>{{ number_format($waktuTunggu, 2) }}</td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="5" class="text-center text-muted">Tidak ada data tersedia
                                                </td>
                                            </tr>
                                        @endforelse

                                        @if ($waktuTungguData->count() > 0)
                                            @php
                                                $rataRataKeseluruhan =
                                                    $countTahun > 0 ? $totalWaktuTunggu / $countTahun : 0;
                                            @endphp
                                            <tr class="table-active fw-bold">
                                                <td>Rata-rata</td>
                                                <td>{{ number_format($totalLulusanWaktu) }}</td>
                                                <td>{{ number_format($totalTerlacakWaktu) }}</td>
                                                <td>{{ number_format($rataRataKeseluruhan, 2) }}</td>
                                            </tr>
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <!-- Ganti bagian tabel kepuasan pengguna dengan ini -->
                    <div class="card border-0 shadow-sm mb-4">
                        <div class="card-header bg-white border-bottom">
                            <h5 class="mb-0 text-primary">
                                <i class="fas fa-star me-2"></i> Penilaian Kepuasan Pengguna Lulusan
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-hover table-bordered">
                                    <thead class="table-light">
                                        <tr>
                                            <th rowspan="2" class="align-middle">No</th>
                                            <th rowspan="2" class="align-middle">Jenis Kemampuan</th>
                                            <th colspan="4" class="text-center">Tingkat Kepuasan Pengguna (%)</th>
                                        </tr>
                                        <tr>
                                            <th class="text-center bg-success bg-opacity-10">Sangat Baik</th>
                                            <th class="text-center bg-info bg-opacity-10">Baik</th>
                                            <th class="text-center bg-warning bg-opacity-10">Cukup</th>
                                            <th class="text-center bg-danger bg-opacity-10">Kurang</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                            $kepuasanFields = [
                                                'kerjasama_tim' => 'Kerjasama Tim',
                                                'keahlian_ti' => 'Keahlian di bidang TI',
                                                'bahasa_asing' => 'Kemampuan berbahasa asing (Inggris)',
                                                'komunikasi' => 'Kemampuan berkomunikasi',
                                                'pengembangan_diri' => 'Pengembangan diri',
                                                'kepemimpinan' => 'Kepemimpinan',
                                                'etos_kerja' => 'Etos Kerja',
                                            ];

                                            $totalSangatBaik = 0;
                                            $totalBaik = 0;
                                            $totalCukup = 0;
                                            $totalKurang = 0;
                                            $countFields = 0;

                                            // Hitung total data kepuasan untuk setiap field
                                            $totalResponden = $kepuasanGroupData->count();
                                        @endphp

                                        @foreach ($kepuasanFields as $field => $label)
                                            @php
                                                // Hitung persentase berdasarkan data grup kepuasan
                                                $sangatBaik = 0;
                                                $baik = 0;
                                                $cukup = 0;
                                                $kurang = 0;

                                                if ($totalResponden > 0) {
                                                    foreach ($kepuasanGroupData as $data) {
                                                        switch ($data->$field) {
                                                            case 'Sangat Baik':
                                                                $sangatBaik++;
                                                                break;
                                                            case 'Baik':
                                                                $baik++;
                                                                break;
                                                            case 'Cukup':
                                                                $cukup++;
                                                                break;
                                                            case 'Kurang':
                                                                $kurang++;
                                                                break;
                                                        }
                                                    }

                                                    // Konversi ke persentase
                                                    $sangatBaikPct = ($sangatBaik / $totalResponden) * 100;
                                                    $baikPct = ($baik / $totalResponden) * 100;
                                                    $cukupPct = ($cukup / $totalResponden) * 100;
                                                    $kurangPct = ($kurang / $totalResponden) * 100;
                                                } else {
                                                    $sangatBaikPct = $baikPct = $cukupPct = $kurangPct = 0;
                                                }

                                                // Hitung total untuk rata-rata
                                                $totalSangatBaik += $sangatBaikPct;
                                                $totalBaik += $baikPct;
                                                $totalCukup += $cukupPct;
                                                $totalKurang += $kurangPct;
                                                $countFields++;
                                            @endphp
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $label }}</td>
                                                <td class="text-center">{{ number_format($sangatBaikPct, 1) }}%</td>
                                                <td class="text-center">{{ number_format($baikPct, 1) }}%</td>
                                                <td class="text-center">{{ number_format($cukupPct, 1) }}%</td>
                                                <td class="text-center">{{ number_format($kurangPct, 1) }}%</td>
                                            </tr>
                                        @endforeach
                                        <tr class="table-active fw-bold">
                                            <td colspan="2" class="text-end">Rata-rata</td>
                                            <td class="text-center">
                                                {{ number_format($totalSangatBaik / $countFields, 1) }}%
                                            </td>
                                            <td class="text-center">{{ number_format($totalBaik / $countFields, 1) }}%
                                            </td>
                                            <td class="text-center">{{ number_format($totalCukup / $countFields, 1) }}%
                                            </td>
                                            <td class="text-center">{{ number_format($totalKurang / $countFields, 1) }}%
                                            </td>
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
                                [
                                    'title' => 'Kerjasama Tim',
                                    'icon' => 'users',
                                    'color' => 'primary',
                                    'field' => 'kerjasama_tim',
                                ],
                                [
                                    'title' => 'Keahlian TI',
                                    'icon' => 'laptop-code',
                                    'color' => 'success',
                                    'field' => 'keahlian_ti',
                                ],
                                [
                                    'title' => 'Bahasa Inggris',
                                    'icon' => 'language',
                                    'color' => 'info',
                                    'field' => 'bahasa_asing',
                                ],
                                [
                                    'title' => 'Komunikasi',
                                    'icon' => 'comments',
                                    'color' => 'warning',
                                    'field' => 'komunikasi',
                                ],
                                [
                                    'title' => 'Pengembangan Diri',
                                    'icon' => 'user-graduate',
                                    'color' => 'danger',
                                    'field' => 'pengembangan_diri',
                                ],
                                [
                                    'title' => 'Kepemimpinan',
                                    'icon' => 'chess-king',
                                    'color' => 'secondary',
                                    'field' => 'kepemimpinan',
                                ],
                                [
                                    'title' => 'Etos Kerja',
                                    'icon' => 'business-time',
                                    'color' => 'dark',
                                    'field' => 'etos_kerja',
                                ],
                            ];
                        @endphp

                        @foreach ($satisfactionCharts as $index => $chart)
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
                                        @php
                                            // Hitung data untuk chart individual
                                            $chartData = [
                                                'sangat_baik' => 0,
                                                'baik' => 0,
                                                'cukup' => 0,
                                                'kurang' => 0,
                                            ];

                                            $totalResponden = $kepuasanGroupData->count();

                                            if ($totalResponden > 0) {
                                                foreach ($kepuasanGroupData as $data) {
                                                    switch ($data->{$chart['field']}) {
                                                        case 'Sangat Baik':
                                                            $chartData['sangat_baik']++;
                                                            break;
                                                        case 'Baik':
                                                            $chartData['baik']++;
                                                            break;
                                                        case 'Cukup':
                                                            $chartData['cukup']++;
                                                            break;
                                                        case 'Kurang':
                                                            $chartData['kurang']++;
                                                            break;
                                                    }
                                                }

                                                // Konversi ke persentase
                                                $chartPercentage = [
                                                    'sangat_baik' =>
                                                        ($chartData['sangat_baik'] / $totalResponden) * 100,
                                                    'baik' => ($chartData['baik'] / $totalResponden) * 100,
                                                    'cukup' => ($chartData['cukup'] / $totalResponden) * 100,
                                                    'kurang' => ($chartData['kurang'] / $totalResponden) * 100,
                                                ];
                                            } else {
                                                $chartPercentage = [
                                                    'sangat_baik' => 0,
                                                    'baik' => 0,
                                                    'cukup' => 0,
                                                    'kurang' => 0,
                                                ];
                                            }
                                        @endphp
                                        <script>
                                            document.addEventListener('DOMContentLoaded', function() {
                                                const ctx{{ $index }} = document.getElementById('chart{{ $index }}').getContext('2d');
                                                new Chart(ctx{{ $index }}, {
                                                    type: 'pie',
                                                    data: {
                                                        labels: ['Sangat Baik', 'Baik', 'Cukup', 'Kurang'],
                                                        datasets: [{
                                                            data: [
                                                                {{ number_format($chartPercentage['sangat_baik'], 1) }},
                                                                {{ number_format($chartPercentage['baik'], 1) }},
                                                                {{ number_format($chartPercentage['cukup'], 1) }},
                                                                {{ number_format($chartPercentage['kurang'], 1) }}
                                                            ],
                                                            backgroundColor: [
                                                                '#28a745',
                                                                '#17a2b8',
                                                                '#ffc107',
                                                                '#dc3545'
                                                            ],
                                                            borderWidth: 2,
                                                            borderColor: '#fff'
                                                        }]
                                                    },
                                                    options: {
                                                        responsive: true,
                                                        maintainAspectRatio: false,
                                                        plugins: {
                                                            legend: {
                                                                position: 'bottom',
                                                                labels: {
                                                                    padding: 10,
                                                                    usePointStyle: true,
                                                                    font: {
                                                                        size: 11
                                                                    }
                                                                }
                                                            },
                                                            tooltip: {
                                                                callbacks: {
                                                                    label: function(context) {
                                                                        return context.label + ': ' + context.parsed + '%';
                                                                    }
                                                                }
                                                            }
                                                        }
                                                    }
                                                });
                                            });
                                        </script>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Logout Bootstrap -->
    <div class="modal fade" id="logoutModal" tabindex="-1" aria-labelledby="logoutModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="logoutModalLabel">Konfirmasi Logout</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                </div>
                <div class="modal-body">
                    Apakah Anda yakin akan keluar?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tidak</button>
                    <button type="button" id="confirmLogout" class="btn btn-danger">Ya, Logout</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Chart JS -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // Extended color palette for multiple data entries
            const colorPalette = [
                '#4e73df', '#1cc88a', '#36b9cc', '#f6c23e', '#e74a3b',
                '#858796', '#5a5c69', '#fd7e14', '#6f42c1', '#e83e8c',
                '#20c997', '#ffc107', '#dc3545', '#6c757d', '#343a40',
                '#17a2b8', '#28a745', '#007bff', '#6610f2', '#e91e63',
                '#795548', '#607d8b', '#ff5722', '#9c27b0', '#3f51b5',
                '#2196f3', '#00bcd4', '#009688', '#4caf50', '#8bc34a',
                '#cddc39', '#ffeb3b', '#ff9800', '#ff5722', '#f44336',
                '#e91e63', '#9c27b0', '#673ab7', '#3f51b5', '#2196f3'
            ];

            // Function to generate colors based on data length
            function getColors(dataLength) {
                const colors = [];
                for (let i = 0; i < dataLength; i++) {
                    colors.push(colorPalette[i % colorPalette.length]);
                }
                return colors;
            }

            // Profession Chart (Pie)
            const profesiLabels = @json($profesiData->pluck('nama_profesi'));
            const profesiValues = @json($profesiData->pluck('total'));

            // Convert to percentage
            const profesiTotal = profesiValues.reduce((a, b) => a + b, 0);
            const profesiPercentages = profesiValues.map(value => profesiTotal > 0 ? ((value / profesiTotal) * 100)
                .toFixed(1) : 0);

            new Chart(document.getElementById('professionChart'), {
                type: 'pie',
                data: {
                    labels: profesiLabels,
                    datasets: [{
                        data: profesiPercentages,
                        backgroundColor: getColors(profesiValues.length),
                        borderWidth: 1,
                        borderColor: '#fff'
                    }]
                },
                options: {
                    plugins: {
                        legend: {
                            display: false
                        },
                        tooltip: {
                            callbacks: {
                                label: ctx => {
                                    const label = ctx.label || '';
                                    const percentage = ctx.raw || 0;
                                    return `${label}: ${percentage}%`;
                                }
                            }
                        }
                    }
                }
            });

            // Institution Chart (Pie)
            const institusiLabels = @json($institusiData->pluck('jenis_instansi'));
            const institusiValues = @json($institusiData->pluck('total'));

            // Convert to percentage
            const institusiTotal = institusiValues.reduce((a, b) => a + b, 0);
            const institusiPercentages = institusiValues.map(value => institusiTotal > 0 ? ((value /
                institusiTotal) * 100).toFixed(1) : 0);

            new Chart(document.getElementById('institutionChart'), {
                type: 'pie',
                data: {
                    labels: institusiLabels,
                    datasets: [{
                        data: institusiPercentages,
                        backgroundColor: getColors(institusiValues.length),
                        borderWidth: 1,
                        borderColor: '#fff'
                    }]
                },
                options: {
                    plugins: {
                        legend: {
                            display: false
                        },
                        tooltip: {
                            callbacks: {
                                label: ctx => {
                                    const label = ctx.label || '';
                                    const percentage = ctx.raw || 0;
                                    return `${label}: ${percentage}%`;
                                }
                            }
                        }
                    }
                }
            });
        });
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            document.getElementById('logoutButton').addEventListener('click', function() {
                var myModal = new bootstrap.Modal(document.getElementById('logoutModal'));
                myModal.show();
            });
        });
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            document.getElementById('confirmLogout').addEventListener('click', function() {
                fetch('{{ route('logout') }}', {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'Content-Type': 'application/json'
                        },
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.status) {
                            window.location.href = data.redirect;
                        } else {
                            alert(data.message);
                        }
                    });
            });
        });
    </script>

    <!-- Tambahkan script ini di bagian bawah view atau di layout -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <!-- Script untuk Chart Terpisah -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            @php
                $satisfactionFields = [['title' => 'Kerjasama Tim', 'field' => 'kerjasama_tim'], ['title' => 'Keahlian TI', 'field' => 'keahlian_ti'], ['title' => 'Bahasa Inggris', 'field' => 'bahasa_asing'], ['title' => 'Komunikasi', 'field' => 'komunikasi'], ['title' => 'Pengembangan Diri', 'field' => 'pengembangan_diri'], ['title' => 'Kepemimpinan', 'field' => 'kepemimpinan'], ['title' => 'Etos Kerja', 'field' => 'etos_kerja']];
            @endphp

            @foreach ($satisfactionFields as $index => $chart)
                @php
                    // Hitung data untuk chart individual
                    $chartData = [
                        'sangat_baik' => 0,
                        'baik' => 0,
                        'cukup' => 0,
                        'kurang' => 0,
                    ];

                    $totalResponden = $kepuasanGroupData->count();

                    if ($totalResponden > 0) {
                        foreach ($kepuasanGroupData as $data) {
                            switch ($data->{$chart['field']}) {
                                case 'Sangat Baik':
                                    $chartData['sangat_baik']++;
                                    break;
                                case 'Baik':
                                    $chartData['baik']++;
                                    break;
                                case 'Cukup':
                                    $chartData['cukup']++;
                                    break;
                                case 'Kurang':
                                    $chartData['kurang']++;
                                    break;
                            }
                        }

                        // Konversi ke persentase
                        $chartPercentage = [
                            'sangat_baik' => ($chartData['sangat_baik'] / $totalResponden) * 100,
                            'baik' => ($chartData['baik'] / $totalResponden) * 100,
                            'cukup' => ($chartData['cukup'] / $totalResponden) * 100,
                            'kurang' => ($chartData['kurang'] / $totalResponden) * 100,
                        ];
                    } else {
                        $chartPercentage = [
                            'sangat_baik' => 0,
                            'baik' => 0,
                            'cukup' => 0,
                            'kurang' => 0,
                        ];
                    }
                @endphp

                // Chart untuk {{ $chart['title'] }}
                const ctx{{ $index }} = document.getElementById('chart{{ $index }}');
                if (ctx{{ $index }}) {
                    new Chart(ctx{{ $index }}, {
                        type: 'pie',
                        data: {
                            labels: ['Sangat Baik', 'Baik', 'Cukup', 'Kurang'],
                            datasets: [{
                                data: [
                                    {{ number_format($chartPercentage['sangat_baik'], 1) }},
                                    {{ number_format($chartPercentage['baik'], 1) }},
                                    {{ number_format($chartPercentage['cukup'], 1) }},
                                    {{ number_format($chartPercentage['kurang'], 1) }}
                                ],
                                backgroundColor: [
                                    '#28a745',
                                    '#17a2b8',
                                    '#ffc107',
                                    '#dc3545'
                                ],
                                borderWidth: 2,
                                borderColor: '#fff'
                            }]
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                            plugins: {
                                legend: {
                                    position: 'bottom',
                                    labels: {
                                        padding: 10,
                                        usePointStyle: true,
                                        font: {
                                            size: 11
                                        }
                                    }
                                },
                                tooltip: {
                                    callbacks: {
                                        label: function(context) {
                                            return context.label + ': ' + context.parsed + '%';
                                        }
                                    }
                                }
                            }
                        }
                    });
                }
            @endforeach
        });
    </script>
@endsection
