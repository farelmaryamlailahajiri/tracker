<!-- Form login -->
<form action="{{ route('admin.login.submit') }}" method="POST" id="form-login">
    @csrf
    <div id="loginModal" class="modal fade" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-md" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Login</h5>                
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label>Username</label>
                        <input type="text" name="username" id="username" class="form-control" required>
                        <small id="error-username" class="form-text text-danger"></small>
                    </div>
                    <div class="form-group">
                        <label>Password</label>
                        <input type="password" name="password" id="password" class="form-control" required>
                        <small id="error-password" class="form-text text-danger"></small>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Masuk</button>
                </div>
            </div>
        </div>
    </div>
</form>

<!-- Pastikan SweetAlert2 sudah disertakan -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
$(document).ready(function () {
    $("#form-login").on("submit", function (e) {
        e.preventDefault();  // Mencegah form submit biasa

        let form = this; 

        $.ajax({
            url: $(form).attr('action'),  // Mengambil URL dari action form
            type: $(form).attr('method'),  // Mengambil metode dari form
            data: $(form).serialize(),  // Menyertakan semua data form
            success: function (response) {
                if (response.status) {
                    $('#loginModal').modal('hide');  // Menutup modal setelah login sukses
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil Login',
                        text: response.message,
                        timer: 1500,
                        showConfirmButton: false
                    }).then(() => {
                        window.location.href = "{{ route('admin.dashboard') }}";  // Arahkan ke dashboard
                    });
                } else {
                    // Menampilkan error di bawah input
                    $('.form-text.text-danger').text('');
                    $.each(response.msgField || {}, function (field, message) {
                        $('#error-' + field).text(message[0]);  // Menampilkan pesan error
                    });

                    // Menampilkan notifikasi error dengan SweetAlert2
                    Swal.fire({
                        icon: 'error',
                        title: 'Login Gagal',
                        text: response.message
                    });
                }
            },
            error: function () {
                // Menampilkan notifikasi error jika terjadi kesalahan pada server
                Swal.fire({
                    icon: 'error',
                    title: 'Server Error',
                    text: 'Terjadi kesalahan saat memproses login.'
                });
            }
            error: function(xhr, status, error) {
    console.log("AJAX error: ", xhr.responseText);  // Menampilkan response error dari server
}

        });
    });
});
</script>
