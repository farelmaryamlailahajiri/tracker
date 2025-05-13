@extends('layoutss.app')

@section('content')
    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">
        <!-- Main Content -->
        <div id="content">
            <!-- Begin Page Content -->
            <div class="container-fluid">
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
 
