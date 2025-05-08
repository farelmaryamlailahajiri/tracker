@extends('layouts.app')

@section('title', 'JTI Tracker')

@section('content')
    <!-- Alumni Form Section -->
    <div id="alumni-form" class="section">
        <div class="container">
            <div class="section-heading text-center">
                <h2>Form <em>Alumni</em></h2>
                <p>Silakan lengkapi data berikut sebagai bagian dari tracer study alumni</p>
            </div>
            <form action="{{ route('alumni.store') }}" method="POST">
                @csrf
                <div class="row">

                    <div class="col-md-6 mb-3">
                        <label for="program_studi">Program Studi</label>
                        <select name="program_studi" id="program_studi" class="form-control" required>
                            <option value="">-- Pilih --</option>
                            <option value="D4 SIB">D4 SIB</option>
                            <option value="D4 TI">D4 TI</option>
                            <option value="D2 PPLS">D2 PPLS</option>
                            <option value="S2 MMR-TI">S2 MMR-TI</option>
                        </select>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="tahun_lulus">Tahun Lulus</label>
                        <select name="tahun_lulus" id="tahun_lulus" class="form-control" required>
                            <option value="">-- Pilih --</option>
                            @for ($year = date('Y'); $year >= 2000; $year--)
                                <option value="{{ $year }}">{{ $year }}</option>
                            @endfor
                        </select>
                    </div>

                    <div class="col-md-12 mb-3">
                        <label for="nama">Nama (NIM - Nama)</label>
                        <input type="text" name="nama" id="nama" class="form-control"
                            placeholder="Cari berdasarkan NIM atau Nama" required>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="no_hp">No. HP</label>
                        <input type="text" name="no_hp" id="no_hp" class="form-control" required>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="email">Email</label>
                        <input type="email" name="email" id="email" class="form-control" required>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="tgl_pertama_kerja">Tanggal Pertama Kerja</label>
                        <input type="date" name="tgl_pertama_kerja" id="tgl_pertama_kerja" class="form-control">
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="tgl_mulai_instansi">Tanggal Mulai di Instansi Saat Ini</label>
                        <input type="date" name="tgl_mulai_instansi" id="tgl_mulai_instansi" class="form-control">
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="jenis_instansi">Jenis Instansi</label>
                        <select name="jenis_instansi" id="jenis_instansi" class="form-control" required>
                            <option value="">-- Pilih --</option>
                            <option value="BUMN">BUMN</option>
                            <option value="Wiraswasta">Wiraswasta</option>
                        </select>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="nama_instansi">Nama Instansi</label>
                        <input type="text" name="nama_instansi" id="nama_instansi" class="form-control">
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="skala_instansi">Skala Instansi</label>
                        <select name="skala_instansi" id="skala_instansi" class="form-control">
                            <option value="">-- Pilih --</option>
                            <option value="Nasional">Nasional</option>
                            <option value="Internasional">Internasional</option>
                        </select>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="lokasi_instansi">Lokasi Instansi</label>
                        <input type="text" name="lokasi_instansi" id="lokasi_instansi" class="form-control">
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="kategori_profesi">Kategori Profesi</label>
                        <select name="kategori_profesi" id="kategori_profesi" class="form-control">
                            <option value="">-- Pilih --</option>
                            <option value="Infokom">Infokom</option>
                            <option value="Non-Infokom">Non-Infokom</option>
                            <option value="Tidak Bekerja">Tidak Bekerja</option>
                        </select>
                    </div>

                    <div class="col-md-6 mb-3">
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

                    <div class="col-md-6 mb-3">
                        <label for="nama_atasan">Nama Atasan Langsung</label>
                        <input type="text" name="nama_atasan" id="nama_atasan" class="form-control">
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="jabatan_atasan">Jabatan Atasan Langsung</label>
                        <input type="text" name="jabatan_atasan" id="jabatan_atasan" class="form-control">
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="no_hp_atasan">No. HP Atasan</label>
                        <input type="text" name="no_hp_atasan" id="no_hp_atasan" class="form-control">
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="email_atasan">Email Atasan</label>
                        <input type="email" name="email_atasan" id="email_atasan" class="form-control">
                    </div>

                    <div class="col-md-12 text-center">
                        <button type="submit" class="btn btn-kirim mt-3">Kirim Data</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
