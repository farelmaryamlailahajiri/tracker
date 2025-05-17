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
                <div class="col-12">


                    <!-- Halaman Laporan Rekap Tracer & Kepuasan (Export Excel Only) -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h5 class="m-0 font-weight-bold text-primary">Laporan Rekap Data</h5>
                            <p class="text-muted mb-0">Laporan hanya dalam bentuk file Excel.</p>
                        </div>
                        <div class="card-body">
                            <ul class="list-group list-group-flush mb-3 w-100">
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    Rekap hasil tracer study lulusan
                                    <a href="{{ route('laporan.export.tracer') }}" class="btn btn-sm btn-outline-success">
                                        <i class="fas fa-file-excel"></i> Download Excel
                                    </a>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    Rekap hasil survei kepuasan pengguna lulusan
                                    <a href="{{ route('laporan.export.kepuasan') }}" class="btn btn-sm btn-outline-success">
                                        <i class="fas fa-file-excel"></i> Download Excel
                                    </a>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    Daftar lulusan yang belum mengisi tracer study
                                    <a href="{{ route('laporan.export.tracer.belum') }}" class="btn btn-sm btn-outline-success">
                                        <i class="fas fa-file-excel"></i> Download Excel
                                    </a>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    Daftar pengguna lulusan yang belum mengisi survei kepuasan
                                    <a href="{{ route('laporan.export.kepuasan.belum') }}" class="btn btn-sm btn-outline-success">
                                        <i class="fas fa-file-excel"></i> Download Excel
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div> <!-- /.col-12 -->
            </div> <!-- /.row -->
        </div> <!-- /.container-fluid -->
    </div> <!-- /#content -->
</div> <!-- /#content-wrapper -->
@endsection
