<div class="modal fade" id="modalEditProfesi" tabindex="-1" aria-labelledby="modalEditProfesiLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form id="formEditProfesi" class="modal-content" method="POST">
            @csrf
            @method('PUT')

            <div class="modal-header">
                <h5 class="modal-title" id="modalEditProfesiLabel">Edit Profesi</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
                <input type="hidden" id="edit_id" name="id">
                <div class="form-group mb-3">
                    <label for="edit_nama_profesi">Nama Profesi</label>
                    <input type="text" name="nama_profesi" id="edit_nama_profesi" class="form-control" required>
                    <div class="invalid-feedback" id="edit_nama_profesi_error"></div>
                </div>
                <div class="form-group mb-3">
                    <label for="edit_kategori">Kategori</label>
                    <select name="kategori" id="edit_kategori" class="form-control" required>
                        <option value="">Pilih Kategori</option>
                        <option value="Infokom">Infokom</option>
                        <option value="Non-Infokom">Non-Infokom</option>
                        <option value="Tidak Bekerja">Tidak Bekerja</option>
                    </select>
                    <div class="invalid-feedback" id="edit_kategori_error"></div>
                </div>
            </div>

            <div class="modal-footer">
                <button type="submit" class="btn btn-success" id="btnUpdateProfesi">
                    <span class="spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"></span>
                    Simpan
                </button>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
            </div>
        </form>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Handle Edit Button Click to populate modal
    $(document).on('click', '.btnEditProfesi', function() { // Menggunakan event delegation untuk tombol yang dinamis
        const id = $(this).data('id');
        const nama = $(this).data('nama');
        const kategori = $(this).data('kategori');
        
        // Set form values
        $('#edit_id').val(id);
        $('#edit_nama_profesi').val(nama);
        $('#edit_kategori').val(kategori);
        
        // Clear previous errors
        clearFormErrors();
        
        // Modal akan otomatis terbuka karena data-bs-toggle="modal" dan data-bs-target="#modalEditProfesi" di tombol
    });

    // Handle Form Submit for Edit
    $('#formEditProfesi').submit(function(e) { // Menggunakan jQuery
        e.preventDefault();
        
        const id = $('#edit_id').val();
        const formData = $(this).serialize(); // Menggunakan jQuery serialize()
        const submitBtn = $('#btnUpdateProfesi');
        const spinner = submitBtn.find('.spinner-border');
        
        // Tampilkan status loading
        submitBtn.prop('disabled', true);
        spinner.removeClass('d-none');
        
        // Clear previous errors
        clearFormErrors();
        
        $.ajax({
            url: `/profesi/${id}`, // URL ke route update
            method: 'POST', // Gunakan POST untuk method override
            data: formData,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                'X-HTTP-Method-Override': 'PUT' // Override ke PUT
            },
            success: function(response) {
                if (response.status === 'success') {
                    $('#modalEditProfesi').modal('hide');
                    showAlert('success', response.message);
                    setTimeout(() => {
                        location.reload();
                    }, 1500);
                } else {
                    if (response.errors) { // Tangani error validasi dari server
                        $.each(response.errors, function(field, messages) {
                            $(`#edit_${field}`).addClass('is-invalid');
                            $(`#edit_${field}_error`).text(messages[0]);
                        });
                    }
                    showAlert('danger', response.message || 'Gagal memperbarui profesi.');
                }
            },
            error: function(xhr) {
                if (xhr.status === 422) { // Error validasi
                    const errors = xhr.responseJSON.errors;
                    $.each(errors, function(field, messages) {
                        $(`#edit_${field}`).addClass('is-invalid');
                        $(`#edit_${field}_error`).text(messages[0]);
                    });
                    showAlert('danger', xhr.responseJSON.message || 'Harap perbaiki kesalahan validasi.');
                } else {
                    showAlert('danger', 'Terjadi kesalahan saat memperbarui profesi.');
                }
                console.error('Error updating profesi:', xhr);
            },
            complete: function() {
                submitBtn.prop('disabled', false);
                spinner.addClass('d-none');
            }
        });
    });
    
    // Fungsi untuk membersihkan pesan error form
    function clearFormErrors() {
        $('#formEditProfesi .invalid-feedback').text('');
        $('#formEditProfesi .form-control').removeClass('is-invalid');
    }
});
</script>
