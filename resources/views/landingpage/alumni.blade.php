@extends('layouts.app')
@section('content')
    <div class="container">

        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif

        @if($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('alumni.store') }}" method="POST" class="alumni-form">
            @csrf
            <div class="section-heading text-center">
                <h2>Form <em>Alumni</em></h2>
                <p>Silakan lengkapi data berikut sebagai bagian dari tracer study alumni</p>
            </div>

            <div class="row">
                <div class="form-group col-12">
                    <label for="alumni_id">Silahkan Cari nama Anda</label>
                    <select name="alumni_id" id="alumni_id" class="form-control" required></select>
                </div>

                <div class="form-group col-md-12">
                    <label for="token">Masukkan token yang telah diberikan</label>
                    <input type="password" name="token" id="token" class="form-control" required>
                </div>

                <div class="form-group col-12 text-center">
                    <button type="button" id="btn-verifikasi" class="btn btn-primary mt-2">Verifikasi</button>
                </div>

                <div class="row" id="form-lanjutan" style="display: none;">
                    <div class="form-group col-md-6">
                        <label>Prodi</label>
                        <input type="text" id="prodi" class="form-control" readonly>
                    </div>

                    <div class="form-group col-md-6">
                        <label>Tahun Lulus</label>
                        <input type="text" id="tahun_lulus" class="form-control" readonly>
                    </div>

                    <div class="form-group col-md-6">
                        <label for="no_hp">No. HP</label>
                        <input type="text" name="no_hp" id="no_hp" class="form-control" required>
                    </div>

                    <div class="form-group col-md-6">
                        <label for="email">Email</label>
                        <input type="email" name="email" id="email" class="form-control" required>
                    </div>
                    
                    <div class="form-group col-md-12">
                        <label for="kategori_profesi">Kategori Profesi</label>
                        <select name="kategori_profesi" id="kategori_profesi" class="form-control">
                            <option value="">-- Pilih Kategori --</option>
                            <!-- Options akan diisi oleh JavaScript -->
                        </select>
                    </div>

                    <div class="form-group col-md-12">
                        <label for="profesi">Profesi</label>
                        <select name="profesi" id="profesi" class="form-control" disabled>
                            <option value="">-- Pilih Profesi --</option>
                            <!-- Options akan diisi setelah kategori dipilih -->
                        </select>
                    </div>
                    
                    <div class="form-group col-md-6">
                        <label for="tgl_pertama_kerja">Tanggal Pertama Kerja</label>
                        <input type="date" name="tgl_pertama_kerja" id="tgl_pertama_kerja" class="form-control">
                    </div>

                    <div class="form-group col-md-6">
                        <label for="tgl_mulai_instansi">Tanggal Mulai di Instansi Saat Ini</label>
                        <input type="date" name="tgl_mulai_instansi" id="tgl_mulai_instansi" class="form-control">
                    </div>

                    <div class="form-group col-md-6">
                        <label for="jenis_instansi">Jenis Instansi</label>
                        <select name="jenis_instansi" id="jenis_instansi" class="form-control">
                            <option value="">-- Pilih --</option>
                            <option value="BUMN">BUMN</option>
                            <option value="Wiraswasta">Wiraswasta</option>
                        </select>
                    </div>

                    <div class="form-group col-md-6">
                        <label for="nama_instansi">Nama Instansi</label>
                        <input type="text" name="nama_instansi" id="nama_instansi" class="form-control">
                    </div>

                    <div class="form-group col-md-6">
                        <label for="skala_instansi">Skala Instansi</label>
                        <select name="skala_instansi" id="skala_instansi" class="form-control">
                            <option value="">-- Pilih --</option>
                            <option value="Nasional">Nasional</option>
                            <option value="Internasional">Internasional</option>
                        </select>
                    </div>

                    <div class="form-group col-md-6">
                        <label for="lokasi_instansi">Lokasi Instansi</label>
                        <input type="text" name="lokasi_instansi" id="lokasi_instansi" class="form-control">
                    </div>


                    <div class="form-group col-md-6">
                        <label for="nama_atasan">Nama Atasan Langsung</label>
                        <input type="text" name="nama_atasan" id="nama_atasan" class="form-control">
                    </div>

                    <div class="form-group col-md-6">
                        <label for="jabatan_atasan">Jabatan Atasan Langsung</label>
                        <input type="text" name="jabatan_atasan" id="jabatan_atasan" class="form-control">
                    </div>

                    <div class="form-group col-md-6">
                        <label for="no_hp_atasan">No. HP Atasan</label>
                        <input type="text" name="no_hp_atasan" id="no_hp_atasan" class="form-control">
                    </div>

                    <div class="form-group col-md-6">
                        <label for="email_atasan">Email Atasan</label>
                        <input type="email" name="email_atasan" id="email_atasan" class="form-control">
                    </div>

                    <div class="form-group col-12 text-center">
                        <button type="submit" class="btn btn-kirim mt-3">Kirim Data</button>
                    </div>

                    <div class="form-group col-12 text-center">
                        <a href="{{ url('/') }}" class="btn btn-kembali mt-3">
                            &larr; Kembali
                        </a>
                    </div>
                </div>
        </form>
    @push('scripts')

    <script>
        $(document).ready(function () {
            $('#alumni_id').select2({
                placeholder: 'Cari Nama',
                ajax: {
                    url: '{{ route('alumni.search') }}',
                    dataType: 'json',
                    delay: 250,
                    data: function (params) {
                        return {
                            q: params.term
                        };
                    },
                    processResults: function (data) {
                        return {
                            results: data
                        };
                    },
                    cache: true
                }
            });

            $('#alumni_id').on('select2:select', function (e) {
                const id = e.params.data.id;
                $.getJSON(`{{ url('/form-alumni/detail') }}/${id}`, function (res) {
                    $('#prodi').val(res.prodi ?? '');
                    $('#tahun_lulus').val(res.tahun_lulus ?? '');
                });
            });

            $.getJSON('{{ url('/form-alumni/kategori') }}', function(data) {
                const select = $('#kategori_profesi');
                select.empty().append('<option value="">-- Pilih Kategori --</option>');
                
                data.forEach(function(kategori) {
                    select.append(`<option value="${kategori}">${kategori}</option>`);
                });
            });

            // Ketika kategori profesi dipilih
            $('#kategori_profesi').change(function() {
                const kategori = $(this).val();
                const profesiSelect = $('#profesi');
                const isTidakBekerja = kategori === 'Tidak Bekerja';

                // Disable/enable instansi fields
                $('#jenis_instansi, #nama_instansi, #skala_instansi, #lokasi_instansi, #tgl_pertama_kerja, #tgl_mulai_instansi')
                    .prop('disabled', isTidakBekerja)
                    .val('');

                // Disable/enable atasan fields
                $('#nama_atasan, #jabatan_atasan, #no_hp_atasan, #email_atasan')
                    .prop('disabled', isTidakBekerja)
                    .val('');

                if (isTidakBekerja) {
                    profesiSelect.empty()
                        .append('<option value="Tidak Bekerja" selected>Tidak Bekerja</option>')
                        .prop('disabled', true);
                } else if (kategori) {
                    profesiSelect.empty().append('<option value="">Memuat data...</option>');
                    profesiSelect.prop('disabled', true);

                    // Ambil profesi berdasarkan kategori
                    $.getJSON('{{ url('/form-alumni/by-kategori') }}', { kategori: kategori }, function(data) {
                        profesiSelect.empty().append('<option value="">-- Pilih Profesi --</option>');
                        data.forEach(function(profesi) {
                            profesiSelect.append(`<option value="${profesi.nama_profesi}">${profesi.nama_profesi}</option>`);
                        });
                        profesiSelect.prop('disabled', false);
                    });
                } else {
                    profesiSelect.empty().append('<option value="">-- Pilih Profesi --</option>');
                    profesiSelect.prop('disabled', true);
                }
            }).trigger('change');

            $('#btn-verifikasi').click(function () {
                const alumniId = $('#alumni_id').val();
                const token = $('#token').val();

                if (!alumniId || !token) {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Data Belum Lengkap',
                        text: 'Silakan pilih nama dan masukkan token.',
                        confirmButtonText: 'OK'
                    });
                    return;
                }

                $.getJSON('{{ url('/form-alumni/verifikasi') }}', {
                    alumni_id: alumniId,
                    token: token
                }, function (res) {
                    if (res.status === 'success') {
                        $('#form-lanjutan').slideDown();
                        $('#alumni_id, #token').prop('readonly', true);
                        $('#btn-verifikasi').prop('disabled', true).text('Terverifikasi');
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Verifikasi Gagal',
                            text: res.message || 'Nama atau token salah. Silakan coba lagi.',
                            confirmButtonText: 'Coba Lagi'
                        });
                    }
                });
            });
        });
    </script>
    @endpush
</div>
@endsection