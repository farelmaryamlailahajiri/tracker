<form action="{{ url('/login') }}" method="POST" id="form-login">
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

<script>
    $(document).ready(function () {
        $("#form-login").on("submit", function (e) {
            e.preventDefault();
            let form = this;
    
            $.ajax({
                url: $(form).attr('action'),
                type: $(form).attr('method'),
                data: $(form).serialize(),
                success: function (response) {
                    if (response.status) {
                        $('#loginModal').modal('hide');
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil Login',
                            text: response.message,
                            timer: 1500,
                            showConfirmButton: false
                        }).then(() => {
                            window.location.reload(); // atau redirect sesuai kebutuhan
                        });
                    } else {
                        $('.form-text.text-danger').text('');
                        $.each(response.msgField || {}, function (field, message) {
                            $('#error-' + field).text(message[0]);
                        });
    
                        Swal.fire({
                            icon: 'error',
                            title: 'Login Gagal',
                            text: response.message
                        });
                    }
                },
                error: function () {
                    Swal.fire({
                        icon: 'error',
                        title: 'Server Error',
                        text: 'Terjadi kesalahan saat memproses login.'
                    });
                }
            });
        });
    });
    </script>
    