<div class="modal fade" id="modalTambahProfesi" tabindex="-1" aria-labelledby="modalTambahProfesiLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form id="formTambahProfesi" class="modal-content" action="{{ route('profesi.store') }}" method="POST">
            @csrf
            <div class="modal-header">
                <h5 class="modal-title" id="modalTambahProfesiLabel">Tambah Profesi</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
                <div class="form-group mb-3">
                    <label for="nama_profesi">Nama Profesi</label>
                    <input type="text" name="nama_profesi" id="nama_profesi" class="form-control" required>
                    <div class="invalid-feedback" id="nama_profesi_error"></div>
                </div>
                <div class="form-group mb-3">
                    <label for="kategori">Kategori</label>
                    <select name="kategori" id="kategori" class="form-control" required>
                        <option value="">-- Pilih Kategori --</option>
                        <option value="Infokom">Infokom</option>
                        <option value="Non-Infokom">Non-Infokom</option>
                        <option value="Tidak Bekerja">Tidak Bekerja</option>
                    </select>
                    <div class="invalid-feedback" id="kategori_error"></div>
                </div>
            </div>

            <div class="modal-footer">
                <button type="submit" class="btn btn-success" id="btnTambahProfesi">
                    <span class="spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"></span>
                    Tambah
                </button>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
            </div>
        </form>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const formTambahProfesi = $('#formTambahProfesi'); // Menggunakan jQuery
    const btnTambahProfesi = $('#btnTambahProfesi'); // Menggunakan jQuery
    const spinnerTambah = btnTambahProfesi.find('.spinner-border');

    formTambahProfesi.submit(function(e) {
        e.preventDefault();

        // Tampilkan status loading
        btnTambahProfesi.prop('disabled', true);
        spinnerTambah.removeClass('d-none');
        clearFormErrors(); // Membersihkan error sebelumnya

        $.ajax({
            url: formTambahProfesi.attr('action'),
            method: 'POST',
            data: formTambahProfesi.serialize(),
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                // Response diharapkan dalam format JSON
                if (response.status === 'success') {
                    $('#modalTambahProfesi').modal('hide');
                    showAlert('success', response.message);
                    setTimeout(() => {
                        location.reload();
                    }, 1500);
                } else {
                    // Jika ada error validasi dari server
                    if (response.errors) {
                        $.each(response.errors, function(field, messages) {
                            $(`#${field}`).addClass('is-invalid');
                            $(`#${field}_error`).text(messages[0]);
                        });
                    }
                    showAlert('danger', response.message || 'Gagal menambahkan profesi.');
                }
            },
            error: function(xhr) {
                // Tangani error HTTP (misalnya 422 Unprocessable Entity untuk validasi)
                if (xhr.status === 422) {
                    const errors = xhr.responseJSON.errors;
                    $.each(errors, function(field, messages) {
                        $(`#${field}`).addClass('is-invalid');
                        $(`#${field}_error`).text(messages[0]);
                    });
                    showAlert('danger', xhr.responseJSON.message || 'Harap perbaiki kesalahan validasi.');
                } else {
                    showAlert('danger', 'Terjadi kesalahan saat menambahkan profesi.');
                }
                console.error('Error adding profesi:', xhr);
            },
            complete: function() {
                // Sembunyikan status loading
                btnTambahProfesi.prop('disabled', false);
                spinnerTambah.addClass('d-none');
            }
        });
    });

    // Helper function to clear form validation errors
    function clearFormErrors() {
        $('#formTambahProfesi .invalid-feedback').text('');
        $('#formTambahProfesi .form-control').removeClass('is-invalid');
    }
});
</script>
