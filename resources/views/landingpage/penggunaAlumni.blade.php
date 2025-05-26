@extends('layouts.app')

@section('content')
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
    <div class="container">
        <form action="{{ route('pengguna-alumni.store') }}" method="POST" class="alumni-form">
            @csrf
            <div class="section-heading text-center">
                <h2>Form <em>Pengguna Alumni</em></h2>
                <p>Silakan lengkapi data berikut sebagai salah satu indikator JTI dalam evaluasi dan perbaikan</p>
            </div>

            <input type="hidden" name="pengguna_id" id="pengguna_id" value="{{ $penggunaId }}">
            <input type="hidden" name="tracer_id" id="tracer_id" value="{{ $tracerId }}">

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