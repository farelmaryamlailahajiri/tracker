@extends('layouts.app')

@section('content')
    <div class="container">
        <form action="{{ route('pengguna-alumni.store') }}" method="POST" class="alumni-form">
            @csrf
            <div class="section-heading text-center">
                <h2>Form <em>Pengguna Alumni</em></h2>
                <p>Silakan lengkapi data berikut sebagai salah satu indikator JTI dalam evaluasi dan perbaikan</p>
            </div>

            <div class="form-group">
                <label for="nama">Nama</label>
                <input type="text" name="nama" id="nama" required>
            </div>

            <div class="form-group">
                <label for="instansi">Instansi</label>
                <input type="text" name="instansi" id="instansi" required>
            </div>

            <div class="form-group">
                <label for="jabatan">Jabatan</label>
                <input type="text" name="jabatan" id="jabatan" required>
            </div>

            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" name="email" id="email" required>
            </div>

            <div class="form-group">
                <label for="alumni_info">Nama Alumni, Program Studi, Tahun Lulus</label>
                <input type="text" name="alumni_info" id="alumni_info"
                    placeholder="Contoh: Informatika - 2022 - Budi Santoso" required>
            </div>

            @php
                $aspek = [
                    'kerjasama_tim' => 'Kerjasama Tim',
                    'keahlian_ti' => 'Keahlian di bidang TI',
                    'bahasa_asing' => 'Kemampuan berbahasa asing',
                    'komunikasi' => 'Kemampuan berkomunikasi',
                    'pengembangan_diri' => 'Pengembangan diri',
                    'kepemimpinan' => 'Kepemimpinan',
                    'etos_kerja' => 'Etos Kerja',
                ];
                $pilihan = ['Sangat Baik', 'Baik', 'Cukup', 'Kurang'];
            @endphp

            @foreach ($aspek as $key => $label)
                <div class="form-group">
                    <label for="{{ $key }}">{{ $label }}</label>
                    <select name="{{ $key }}" id="{{ $key }}" required>
                        @foreach ($pilihan as $option)
                            <option value="{{ $option }}">{{ $option }}</option>
                        @endforeach
                    </select>
                </div>
            @endforeach

            <div class="form-group">
                <label for="kompetensi_kurang">Kompetensi yang dibutuhkan tapi belum dapat dipenuhi</label>
                <input type="text" name="kompetensi_kurang" id="kompetensi_kurang">
            </div>

            <div class="form-group">
                <label for="saran_kurikulum">Saran untuk kurikulum program studi</label>
                <textarea name="saran_kurikulum" id="saran_kurikulum" class="form-control" rows="4"></textarea>
            </div>

            <div class="col-md-12 text-center">
                <button type="submit" class="btn btn-kirim mt-3">Kirim Data</button>
            </div>
        </form>
    </div>
@endsection