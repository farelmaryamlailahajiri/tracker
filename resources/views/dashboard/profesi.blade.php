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
                        <i class="fas fa-fw fa-briefcase"></i>Kelola Profesi
                    </h1>
                    <button class="btn btn-outline-danger">
                        <i class="fas fa-sign-out-alt me-1"></i> Keluar
                    </button>
                </div>

                <div class="card shadow mb-4">
                    <div class="card-header py-3 d-flex justify-content-between align-items-center">
                        <h6 class="m-0 font-weight-bold text-primary">Data Profesi</h6>
                        {{-- Button to trigger modal --}}
                        <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#modalTambahProfesi">+
                            Tambah Profesi</button>
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
                                                <button class="btn btn-sm btn-warning btnEditProfesi"
                                                    data-id="{{ $profesi->id }}" data-nama="{{ $profesi->nama_profesi }}"
                                                    data-kategori="{{ $profesi->kategori }}" data-bs-toggle="modal"
                                                    data-bs-target="#modalEditProfesi">
                                                    Edit
                                                </button>

                                                <button type="button" class="btn btn-sm btn-danger btnHapus"
                                                    data-id="{{ $profesi->id }}" data-bs-toggle="modal"
                                                    data-bs-target="#modalDeleteProfesi">
                                                    Hapus
                                                </button>
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
                @include('dashboard.createProfesi')
                @include('dashboard.editProfesi')
                @include('dashboard.deleteProfesi')
            </div>
        </div>
    </div>
@endsection
