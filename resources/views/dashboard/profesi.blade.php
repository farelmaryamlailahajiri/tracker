@extends('layoutss.app')

@section('content')
    <div id="content-wrapper" class="d-flex flex-column">
        <div id="content">
            <div class="container-fluid">

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
                                                    data-id="{{ $profesi->id }}">
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

                {{-- Include the createProfesi modal partial --}}
                @include('dashboard.createProfesi')
                @include('dashboard.editProfesi')
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        $(document).ready(function() {

            // Setup Ajax to include CSRF token in request header
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            });

            // Event delegation for delete button - use on() with document
            $(document).on('click', '.btnHapus', function() {
                const id = $(this).data('id');
                console.log('Tombol hapus diklik untuk ID:', id);

                if (confirm('Yakin ingin menghapus data ini?')) {
                    $.ajax({
                        url: '/profesi/' + id,
                        type: 'POST', // Use POST with _method spoofing
                        data: {
                            _method: 'DELETE'
                        },
                        success: function(response) {
                            alert(response.message); // Display message from controller
                            location.reload(); // Reload page to reflect changes
                        },
                        error: function(xhr) {
                            console.error("AJAX error:", xhr.responseText);
                            let errorMessage = 'Gagal menghapus data!';
                            if (xhr.responseJSON && xhr.responseJSON.message) {
                                errorMessage = xhr.responseJSON.message;
                            }
                            alert(errorMessage);
                        }
                    });
                }
            });
        });
    </script>
@endsection