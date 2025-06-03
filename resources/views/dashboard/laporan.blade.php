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
                        <i class="fas fa-fw fa-file-alt"></i>Laporan
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
                            <form method="GET" action="{{ route('laporan.index') }}">
                                <div class="row g-3">
                                    <div class="col-md-4">
                                        <label class="form-label">Program Studi</label>
                                        @php
                                            $prodis = \App\Models\ProgramStudi::all();
                                            $selectedProdi = request('program_studi', $prodis->first()->id ?? 1);
                                        @endphp
                                        <select name="program_studi" class="form-select">
                                            @foreach ($prodis as $prodi)
                                                <option value="{{ $prodi->id }}" {{ $selectedProdi == $prodi->id ? 'selected' : '' }}>
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

                    <!-- Info Alert -->
                    <div class="alert alert-info mb-4">
                        <i class="fas fa-info-circle me-2"></i> 
                        Menampilkan data untuk <strong>{{ \App\Models\ProgramStudi::find($selectedProdi)->nama ?? 'Semua Program Studi' }}</strong> 
                        tahun <strong>{{ $tahunAwalDefault }} - {{ $tahunAkhirDefault }}</strong>
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
                                    {{-- Menjadi ini: --}}
                                    <a href="{{ route('laporan.export.tracer-alumni', [
                                        'program_studi' => $selectedProdi,
                                        'tahun_awal' => $tahunAwalDefault,
                                        'tahun_akhir' => $tahunAkhirDefault
                                    ]) }}" class="btn btn-sm btn-outline-success">
                                        <i class="fas fa-file-excel"></i> Download Excel
                                    </a>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    Rekap hasil survei kepuasan pengguna lulusan
                                    {{-- Menjadi ini: --}}
                                    <a href="{{ route('laporan.export.survey-pengguna', [
                                        'program_studi' => $selectedProdi,
                                        'tahun_awal' => $tahunAwalDefault,
                                        'tahun_akhir' => $tahunAkhirDefault
                                    ]) }}" class="btn btn-sm btn-outline-success">
                                        <i class="fas fa-file-excel"></i> Download Excel
                                    </a>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    Daftar lulusan yang belum mengisi tracer study
                                    {{-- Menjadi ini: --}}
                                    <a href="{{ route('laporan.export.alumni-belum-ts', [
                                        'program_studi' => $selectedProdi,
                                        'tahun_awal' => $tahunAwalDefault,
                                        'tahun_akhir' => $tahunAkhirDefault
                                    ]) }}" class="btn btn-sm btn-outline-success">
                                        <i class="fas fa-file-excel"></i> Download Excel
                                    </a>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    Daftar pengguna lulusan yang belum mengisi survei kepuasan
                                    {{-- Menjadi ini: --}}
                                    <a href="{{ route('laporan.export.pengguna-belum-survey', [
                                        'program_studi' => $selectedProdi,
                                        'tahun_awal' => $tahunAwalDefault,
                                        'tahun_akhir' => $tahunAkhirDefault
                                    ]) }}" class="btn btn-sm btn-outline-success">
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
