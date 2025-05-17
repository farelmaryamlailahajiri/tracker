@extends('layoutss.app')

@section('content')
<div id="content-wrapper" class="d-flex flex-column">
    <div id="content">
        <div class="container-fluid">
            <div class="row">

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
                                        <th>NIM</th>
                                        <th>Nama</th>
                                        <th>Tanggal Lulus</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($lulusan as $index => $item)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>{{ $item->program_studi }}</td>
                                        <td>{{ $item->nim }}</td>
                                        <td>{{ $item->nama }}</td>
                                        <td>{{ \Carbon\Carbon::parse($item->tanggal_lulus)->format('d-m-Y') }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                
            </div>
        </div>
    </div>
</div>

<!-- Modal Import -->
<div class="modal fade" id="importModal" tabindex="-1" role="dialog" aria-labelledby="importModalLabel" aria-hidden="true">
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
                    <div id="success-message" class="alert alert-success" style="display: none;"></div>
                    <div id="error-message" class="alert alert-danger" style="display: none;"></div>
                    <button type="submit" class="btn btn-primary">Impor Lulusan</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Script -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
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
                    $('#success-message').text(response.message).show();
                    $('#error-message').hide();
                    $('#import-form')[0].reset();
                    $('#importModal').modal('hide');
                    location.reload(); // reload halaman untuk menampilkan data terbaru
                },
                error: function(jqXHR) {
                    let errMsg = 'Terjadi kesalahan saat mengimpor data.';
                    if (jqXHR.responseJSON && jqXHR.responseJSON.message) {
                        errMsg = jqXHR.responseJSON.message;
                    }
                    $('#error-message').text(errMsg).show();
                    $('#success-message').hide();
                }
            });
        });
    });
</script>
@endsection