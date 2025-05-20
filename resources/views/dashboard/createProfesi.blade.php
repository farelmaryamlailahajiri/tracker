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
                    <input type="text" name="nama_profesi" class="form-control" required>
                </div>
                <div class="form-group mb-3">
                    <label for="kategori">Kategori</label>
                    <select name="kategori" class="form-control" required>
                        <option value="">-- Pilih Kategori --</option>
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
    $('#formTambahProfesi').submit(function(e) {
        e.preventDefault();

        $.ajax({
            url: "{{ route('profesi.store') }}",
            method: 'POST',
            data: $(this).serialize(),
            success: function(response) {
                alert('Profesi berhasil ditambahkan!');
                $('#modalTambahProfesi').modal('hide'); // tutup modal
                location.reload(); // reload halaman
            },
            error: function(xhr) {
                alert('Gagal menambah profesi!');
            }
        });
    });
</script>