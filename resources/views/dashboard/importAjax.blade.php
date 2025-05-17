@extends('layoutss.app')

@section('content')
<div id="content-wrapper" class="d-flex flex-column">
    <div id="content">
        <div class="container-fluid">
            <div class="row">

                <!-- Modal Import Ajak -->
                <form action="{{ url('/ajak/import_ajax') }}" method="POST" id="form-import-ajak" enctype="multipart/form-data">
                    @csrf
                    <div id="modal-ajak" class="modal-dialog modal-lg" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Import Data Ajak</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <div class="form-group">
                                    <label>Download Template</label>
                                    <a href="{{ asset('template_ajak.xlsx') }}" class="btn btn-info btn-sm" download>
                                        <i class="fa fa-file-excel"></i> Download Template
                                    </a>
                                    <small id="error-template" class="error-text form-text text-danger"></small>
                                </div>
                                <div class="form-group">
                                    <label>Pilih File</label>
                                    <input type="file" name="file_ajak" id="file_ajak" class="form-control" required>
                                    <small id="error-file_ajak" class="error-text form-text text-danger"></small>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" data-dismiss="modal" class="btn btn-warning">Batal</button>
                                <button type="submit" class="btn btn-primary">Upload</button>
                            </div>
                        </div>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function () {
        $("#form-import-ajak").validate({
            rules: {
                file_ajak: { required: true, extension: "xlsx" },
            },
            submitHandler: function (form) {
                var formData = new FormData(form);
                $.ajax({
                    url: form.action,
                    type: form.method,
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function (response) {
                        if (response.status) {
                            $('#modal-ajak').modal('hide');
                            Swal.fire({
                                icon: 'success',
                                title: 'Berhasil',
                                text: response.message
                            });
                            // Refresh datatable if necessary
                        } else {
                            $('.error-text').text('');
                            $.each(response.msgField ?? {}, function (prefix, val) {
                                $('#error-' + prefix).text(val[0]);
                            });
                            Swal.fire({
                                icon: 'error',
                                title: 'Terjadi Kesalahan',
                                text: response.message
                            });
                        }
                    }
                });
                return false;
            },
            errorElement: 'span',
            errorPlacement: function (error, element) {
                error.addClass('invalid-feedback');
                element.closest('.form-group').append(error);
            },
            highlight: function (element) {
                $(element).addClass('is-invalid');
            },
            unhighlight: function (element) {
                $(element).removeClass('is-invalid');
            }
        });
    });
</script>
@endsection