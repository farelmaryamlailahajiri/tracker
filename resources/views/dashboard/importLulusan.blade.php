@extends('layoutss.app')

@section('content')
<div id="content-wrapper" class="d-flex flex-column">
    <div id="content">
        <div class="container-fluid">

            <!-- Tabel Data Lulusan -->
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex justify-content-between align-items-center">
                    <h6 class="m-0 font-weight-bold text-primary">Data Lulusan</h6>
                    <button class="btn btn-sm btn-success shadow-sm" id="importLulusanBtn">
                        <i class="fas fa-upload fa-sm text-white-50"></i> Import Lulusan
                    </button>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered w-100" id="dataTable" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Program Studi</th>
                                    <th>Nama</th>
                                    <th>NIM</th>
                                    <th>Tanggal Lulus</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($alumni as $index)
                                <tr>
                                    <td>{{ $loop->iteration + ($alumni->currentPage() - 1) * $alumni->perPage() }}</td>
                                    <td>{{ $index->programStudi ? $index->programStudi->nama : '-' }}</td>
                                    <td>{{ $index->nama }}</td>
                                    <td>{{ $index->nim }}</td>
                                    <td>{{ $index->tanggal_lulus }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>

                        <!-- Pagination Previous & Next tanpa angka -->
                        <div class="d-flex justify-content-between align-items-center mt-3">
                            <div>
                                Showing {{ $alumni->firstItem() }} to {{ $alumni->lastItem() }} of {{ $alumni->total() }} entries
                            </div>
                            <div>
                                <nav>
                                    <ul class="pagination mb-0">
                                        {{-- Previous --}}
                                        @if ($alumni->onFirstPage())
                                            <li class="page-item disabled"><span class="page-link">Previous</span></li>
                                        @else
                                            <li class="page-item">
                                                <a class="page-link" href="{{ $alumni->previousPageUrl() }}" rel="prev">Previous</a>
                                            </li>
                                        @endif

                                        {{-- Next --}}
                                        @if ($alumni->hasMorePages())
                                            <li class="page-item">
                                                <a class="page-link" href="{{ $alumni->nextPageUrl() }}" rel="next">Next</a>
                                            </li>
                                        @else
                                            <li class="page-item disabled"><span class="page-link">Next</span></li>
                                        @endif
                                    </ul>
                                </nav>
                            </div>
                        </div>
                        
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

<!-- Modal Import -->
<div class="modal fade" id="importModal" tabindex="-1" role="dialog" aria-labelledby="importModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="importModalLabel">Import Data Lulusan</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="import-form" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <label for="file_lulusan">Pilih File XLSX</label>
                        <input type="file" name="file_lulusan" id="file_lulusan" class="form-control" required>
                    </div>
                    <div id="error-message" class="alert alert-danger" style="display: none;"></div>
                    <button type="submit" class="btn btn-primary">Impor Lulusan</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Script -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- SweetAlert2 CDN -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    $(document).ready(function() {
        // Tampilkan modal saat tombol diklik
        $('#importLulusanBtn').click(function() {
            $('#importModal').modal('show');
        });

        // Proses pengiriman form dengan Ajax
        $('#import-form').on('submit', function(e) {
            e.preventDefault();
            var formData = new FormData(this);

            $.ajax({
                url: '{{ route('lulusan.import') }}',
                type: 'POST',
                data: formData,
                contentType: false,
                processData: false,
                success: function(response) {
                    // Tampilkan popup SweetAlert sukses
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil',
                        text: response.message,
                        confirmButtonText: 'OK'
                    }).then(() => {
                        $('#import-form')[0].reset();
                        $('#importModal').modal('hide');
                        location.reload(); // reload halaman untuk menampilkan data terbaru
                    });
                },
                error: function(jqXHR) {
                    let errMsg = 'Terjadi kesalahan saat mengimpor data.';
                    if (jqXHR.responseJSON && jqXHR.responseJSON.message) {
                        errMsg = jqXHR.responseJSON.message;
                    }
                    $('#error-message').text(errMsg).show();
                }
            });
        });
    });
</script>
@endsection
