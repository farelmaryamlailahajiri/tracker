@extends('layoutss.app')

@section('content')
<!-- DataTales Example -->
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
