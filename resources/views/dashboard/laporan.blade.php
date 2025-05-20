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

                    <!-- INI FILTERNYA YA WKWK -->
                    <div class="mb-4">
                    <form method="GET" action="{{ route('profesi.index') }}">
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


                    <!-- Halaman Laporan Rekap Tracer & Kepuasan (Export Excel Only) -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h5 class="m-0 font-weight-bold text-primary">Laporan Rekap Data</h5>
                            <p class="text-muted mb-0">Laporan hanya
                                 dalam bentuk file Excel.</p>
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
