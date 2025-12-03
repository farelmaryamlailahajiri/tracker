<div class="modal fade" id="modalDeleteProfesi" tabindex="-1" aria-labelledby="modalDeleteProfesiLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalDeleteProfesiLabel">Hapus Profesi</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="text-center">
                    <i class="fas fa-exclamation-triangle fa-3x text-warning mb-3"></i>
                    <p class="mb-3">Apakah Anda yakin ingin menghapus profesi:</p>
                    <p class="fw-bold text-danger" id="profesiName"></p>
                    <p class="text-muted small">Data yang sudah dihapus tidak dapat dikembalikan!</p>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <form id="deleteProfesiForm" method="POST" action="" style="display: inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger" id="btnDeleteProfesi">
                        <span class="spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"></span>
                        <i class="fas fa-trash me-1"></i>
                        Ya, Hapus
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Handle Delete Button Click to populate modal
    $(document).on('click', '.btnHapus', function() { // Menggunakan event delegation
        const profesiId = $(this).data('id');
        const profesiName = $(this).data('nama') || $(this).closest('tr').find('td:nth-child(2)').text();

        const form = $('#deleteProfesiForm');
        form.attr('action', `/profesi/${profesiId}`); // Set aksi form secara dinamis

        $('#profesiName').text(profesiName);
    });

    // Handle Form Submit for Delete
    $('#deleteProfesiForm').submit(function(e) { // Menggunakan jQuery
        e.preventDefault();
        
        const submitBtn = $('#btnDeleteProfesi');
        const spinner = submitBtn.find('.spinner-border');
        
        // Tampilkan status loading
        submitBtn.prop('disabled', true);
        spinner.removeClass('d-none');
        
        $.ajax({
            url: $(this).attr('action'), // URL sudah diatur oleh click handler
            method: 'POST', // Gunakan POST untuk method override
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                'X-HTTP-Method-Override': 'DELETE' // Override ke DELETE
            },
            success: function(response) {
                try {
                    if (response.status === 'success') {
                        $('#modalDeleteProfesi').modal('hide');
                        showAlert('success', response.message);
                        setTimeout(() => {
                            location.reload();
                        }, 1500);
                    } else {
                        showAlert('danger', response.message || 'Gagal menghapus profesi.');
                    }
                } catch (err) {
                    console.error('Error processing delete success response:', err);
                    showAlert('danger', 'Terjadi kesalahan saat memproses respons penghapusan.');
                }
            },
            error: function(xhr) {
                try {
                    let errorMessage = 'Terjadi kesalahan saat menghapus profesi. Silakan coba lagi.';
                    if (xhr.status === 419) {
                        errorMessage = 'Sesi Anda telah kedaluwarsa atau token keamanan tidak valid. Mohon segarkan halaman dan coba lagi.';
                    } else if (xhr.responseJSON && xhr.responseJSON.message) {
                        errorMessage = xhr.responseJSON.message;
                    }
                    
                    showAlert('danger', errorMessage);
                } catch (err) {
                    console.error('Error processing delete error response:', err);
                    showAlert('danger', 'Terjadi kesalahan saat memproses respons error penghapusan.');
                }
                console.error('AJAX Error deleting profesi:', xhr);
            },
            complete: function() {
                submitBtn.prop('disabled', false);
                spinner.addClass('d-none');
            }
        });
    });
});
</script>
