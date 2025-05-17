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


    <!-- Tabel Data Lulusan -->
    <div class="card shadow mb-4">
    <div class="card-header py-3 d-flex justify-content-between align-items-center">
        <h6 class="m-0 font-weight-bold text-primary">Data Lulusan</h6>
        <a href="{{ route('dashboard.importLulusan') }}" class="btn btn-sm btn-success shadow-sm">
            <i class="fas fa-upload fa-sm text-white-50"></i> Import Lulusan
        </a>
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

@endsection