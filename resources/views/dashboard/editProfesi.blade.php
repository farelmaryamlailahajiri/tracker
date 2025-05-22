<div class="modal fade" id="modalEditProfesi" tabindex="-1" aria-labelledby="modalEditProfesiLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form id="formEditProfesi" class="modal-content" method="POST" action="{{ url('/profesi') }}">
            @csrf

            <div class="modal-header">
                <h5 class="modal-title" id="modalEditProfesiLabel">Edit Profesi</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
                <input type="hidden" id="edit_id" name="id">
                <div class="form-group mb-3">
                    <label for="edit_nama_profesi">Nama Profesi</label>
                    <input type="text" name="nama_profesi" id="edit_nama_profesi" class="form-control" required>
                </div>
                <div class="form-group mb-3">
                    <label for="edit_kategori">Kategori</label>
                    <select name="kategori" id="edit_kategori" class="form-control" required>
                        <option value="Infokom">Infokom</option>
                        <option value="Non-Infokom">Non-Infokom</option>
                    </select>
                </div>
            </div>

            <div class="modal-footer">
                <button type="submit" class="btn btn-success">Simpan</button>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
            </div>
        </form>
    </div>
</div>
<script>
   $('#formEditProfesi').submit(function(e) {
    e.preventDefault();

    let id = $('#edit_id').val(); // Get ID from hidden input
    let actionUrl = '/profesi/' + id; // Construct the URL for the PUT request
    let formData = $(this).serialize(); // Serialize all form data

    $.ajax({
        url: actionUrl,
        method: 'PUT', // Specify the PUT method directly
        data: formData,
        success: function(response) {
            alert('Profesi berhasil diperbarui!');
            $('#modalEditProfesi').modal('hide');
            setTimeout(function() {
                location.reload();
            }, 2000);
        },
        error: function(xhr) {
            // More detailed error handling
            let errorMessage = 'Gagal memperbarui profesi!';
            if (xhr.responseJSON && xhr.responseJSON.message) {
                errorMessage = xhr.responseJSON.message;
            }
            alert(errorMessage);
            console.error("AJAX error:", xhr);
        }
    });
});
</script>