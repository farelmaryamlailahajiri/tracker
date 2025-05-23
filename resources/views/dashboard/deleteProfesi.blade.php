<div class="modal fade" id="modalDeleteProfesi" tabindex="-1" aria-labelledby="modalDeleteProfesiLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalDeleteProfesiLabel">Hapus Profesi</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Apakah Anda yakin ingin menghapus profesi <strong id="profesiName"></strong>?</p>
            </div>
            <div class="modal-footer">
                <form id="deleteProfesiForm" method="POST" action="">
                    @csrf
                    @method('DELETE')
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-danger">Hapus</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    document.querySelectorAll('.btnHapus').forEach(button => {
        button.addEventListener('click', function() {
            const profesiId = this.getAttribute('data-id');
            const profesiName = this.closest('tr').querySelector('td:nth-child(2)').innerText;

            const form = document.getElementById('deleteProfesiForm');
            form.action = `/profesi/${profesiId}`;

            document.getElementById('profesiName').innerText = profesiName;

            var modal = new bootstrap.Modal(document.getElementById('modalDeleteProfesi'));
            modal.show();
        });
    });
</script>