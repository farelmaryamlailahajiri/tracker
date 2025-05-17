@extends('layoutss.app')

@section('content')
    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">
        <!-- Main Content -->
        <div id="content">
            <!-- Begin Page Content -->
            <div class="container-fluid">

            <!-- INI FILTERNYA YA WKWK -->
            <div class="mb-4">
            <form method="GET" action="{{ route('dashboard') }}">
                <div class="row g-1 align-items-center">
                    {{-- Label Program Studi --}}
                    <div class="col-auto">
                        <label for="program_studi" class="col-form-label">Program Studi:</label>
                    </div>
                    {{-- Select Program Studi --}}
                    <div class="col-md-2">
                        <select name="program_studi" id="program_studi" class="form-control">
                            @php
                                $prodis = ['D4 TI', 'D4 SIB', 'D2 PPLS', 'S2 MRTI'];
                                $selectedProdi = request('program_studi', 'D4 TI');
                            @endphp
                            @foreach ($prodis as $prodi)
                                <option value="{{ $prodi }}" {{ $selectedProdi == $prodi ? 'selected' : '' }}>{{ $prodi }}</option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Label Tahun --}}
                    <div class="col-auto">
                        <label for="tahun_awal" class="col-form-label">Tahun:</label>
                    </div>
                    {{-- Tahun Awal --}}
                    <div class="col-md-2">
                        @php
                            $tahunSekarang = date('Y');
                            $tahunAwalDefault = request('tahun_awal', $tahunSekarang - 3);
                            $tahunAkhirDefault = request('tahun_akhir', $tahunSekarang);
                        @endphp
                        <input type="number" name="tahun_awal" id="tahun_awal" class="form-control" value="{{ $tahunAwalDefault }}" min="2000" max="{{ $tahunSekarang }}">
                    </div>
                    {{-- Teks s.d --}}
                    <div class="col-auto">
                        <span class="form-text">s.d</span>
                    </div>
                    {{-- Tahun Akhir --}}
                    <div class="col-md-2">
                        <input type="number" name="tahun_akhir" class="form-control" value="{{ $tahunAkhirDefault }}" min="2000" max="{{ $tahunSekarang }}">
                    </div>

                    {{-- Tombol Terapkan --}}
                    <div class="col-auto">
                        <button type="submit" class="btn btn-primary">Terapkan</button>
                    </div>
                </div>
            </form>
        </div>



                <!-- Content Row -->
                <div class="row">
                    @php
                        $charts = [
                            ['title' => 'Revenue Sources', 'labels' => ['Direct', 'Referral', 'Social']],
                            ['title' => 'Sales Breakdown', 'labels' => ['Sales', 'Marketing', 'Operations']],
                            ['title' => 'Product Distribution', 'labels' => ['Product A', 'Product B', 'Product C']],
                            ['title' => 'Regional Spread', 'labels' => ['North', 'South', 'East', 'West']],
                            ['title' => 'Sales Channels', 'labels' => ['Online', 'Offline', 'Hybrid']],
                            ['title' => 'Customer Demographics', 'labels' => ['Youth', 'Adult', 'Senior']],
                            ['title' => 'Market Segments', 'labels' => ['Segment A', 'Segment B', 'Segment C']],
                            ['title' => 'Distribution Channels', 'labels' => ['Channel 1', 'Channel 2', 'Channel 3']],
                            [
                                'title' => 'Regional Performance',
                                'labels' => ['Region 1', 'Region 2', 'Region 3', 'Region 4'],
                            ],
                        ];
                    @endphp

                    @foreach ($charts as $index => $chart)
                        <div class="col-xl-4 col-lg-5 mb-4">
                            <div class="card shadow">
                                <!-- Card Header -->
                                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                    <h6 class="m-0 font-weight-bold text-primary">{{ $chart['title'] }}</h6>
                                    <div class="dropdown no-arrow">
                                        <a class="dropdown-toggle" href="#" role="button"
                                            id="dropdownMenuLink{{ $index }}" data-toggle="dropdown"
                                            aria-haspopup="true" aria-expanded="false">
                                            <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in"
                                            aria-labelledby="dropdownMenuLink{{ $index }}">
                                            <div class="dropdown-header">Chart Options:</div>
                                            <a class="dropdown-item" href="#">View Details</a>
                                            <a class="dropdown-item" href="#">Export</a>
                                        </div>
                                    </div>
                                </div>
                                <!-- Card Body -->
                                <div class="card-body">
                                    <div class="chart-pie pt-4 pb-2">
                                        <canvas id="pieChart{{ $index + 1 }}"></canvas>
                                    </div>
                                    <div class="mt-4 text-center small">
                                        @foreach ($chart['labels'] as $key => $label)
                                            <span class="mr-2">
                                                <i class="fas fa-circle"
                                                    style="color: {{ ['#4e73df', '#1cc88a', '#36b9cc', '#ff6384', '#36a2eb', '#ffce56', '#ff9f40', '#4bc0c0', '#9966ff'][$key] }}"></i>
                                                {{ $label }}
                                            </span>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                
                @php
                    $filteredProdi = request('program_studi', 'D4 TI');
                    $tahunAwal = request('tahun_awal', date('Y') - 3);
                    $tahunAkhir = request('tahun_akhir', date('Y'));
                @endphp

                {{-- Contoh penggunaan --}}
                <p>Menampilkan data untuk Program Studi <strong>{{ $filteredProdi }}</strong> dari tahun <strong>{{ $tahunAwal }}</strong> sampai <strong>{{ $tahunAkhir }}</strong>.</p>


                <!-- DataTales Example -->
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Data Lulusan</h6>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th>Tahun Lulus</th>
                                        <th>Jumlah Lulusan</th>
                                        <th>Jumlah Lulusan Teracak</th>
                                        <th>Rata-rata Waktu Tunggu</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>2020</td>
                                        <td>150</td>
                                        <td>30</td>
                                        <td>3.2 bulan</td>
                                    </tr>
                                    <tr>
                                        <td>2021</td>
                                        <td>165</td>
                                        <td>35</td>
                                        <td>2.8 bulan</td>
                                    </tr>
                                    <tr>
                                        <td>2022</td>
                                        <td>172</td>
                                        <td>40</td>
                                        <td>2.4 bulan</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- /.container-fluid -->
    </div>
    <!-- End of Main Content -->
@endsection
 
