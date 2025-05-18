@extends('layouts.app')
@section('content')
    <div class="container">

        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
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
                <div class="form-group col-md-12">
                    <label for="alumni_id">Silahkan Cari nama Anda</label>
                    <select name="alumni_id" id="alumni_id" class="form-control" required></select>
                </div>

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
                    <select name="jenis_instansi" id="jenis_instansi" class="form-control" required>
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
                    <label for="kategori_profesi">Kategori Profesi</label>
                    <select name="kategori_profesi" id="kategori_profesi" class="form-control">
                        <option value="">-- Pilih --</option>
                        <option value="Infokom">Infokom</option>
                        <option value="Non-Infokom">Non-Infokom</option>
                        <option value="Tidak Bekerja">Tidak Bekerja</option>
                    </select>
                </div>

                <div class="form-group col-md-6">
                    <label for="profesi">Profesi</label>
                    <select name="profesi" id="profesi" class="form-control">
                        <option value="">-- Pilih --</option>
                        <option value="Web Developer">Web Developer</option>
                        <option value="App Developer">App Developer</option>
                        <option value="Data Analyst">Data Analyst</option>
                        <option value="UI/UX Designer">UI/UX Designer</option>
                        <option value="Network Engineer">Network Engineer</option>
                        <option value="IT Support">IT Support</option>
                        <option value="Project Manager">Project Manager</option>
                        <option value="Digital Marketer">Digital Marketer</option>
                        <option value="Freelancer">Freelancer</option>
                        <option value="Lainnya">Lainnya</option>
                    </select>
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
        });
    </script>
    @endpush
</div>
@endsection