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


            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex justify-content-between align-items-center">
                    <h6 class="m-0 font-weight-bold text-primary">Data Profesi</h6>
                    <a href="{{ route('profesi.create') }}" class="btn btn-primary btn-sm">+ Tambah Profesi</a>
                </div>

    
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Profesi</th>
                        <th>Kategori</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($profesis as $index => $profesi)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $profesi->nama_profesi }}</td>
                            <td>{{ $profesi->kategori }}</td>
                            <td>
                                <a href="{{ route('profesi.edit', $profesi->id) }}" class="btn btn-sm btn-warning">Edit</a>
                                <form action="{{ route('profesi.destroy', $profesi->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus data ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                    @if ($profesis->isEmpty())
                        <tr>
                            <td colspan="4" class="text-center">Tidak ada data profesi.</td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
