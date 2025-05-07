@extends('layouts.app')

@section('title', 'JTI Tracker')

@section('content')

    <!-- ***** Preloader Start ***** -->
    <div id="js-preloader" class="js-preloader">
        <div class="preloader-inner">
            <span class="dot"></span>
            <div class="dots">
                <span></span>
                <span></span>
                <span></span>
            </div>
        </div>
    </div>
    <!-- ***** Preloader End ***** -->

    <!-- ***** Header Area Start ***** -->
    <header class="header-area header-sticky wow slideInDown" data-wow-duration="0.75s" data-wow-delay="0s">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <nav class="main-nav">
                        <a href="{{ url('/') }}" class="logo">
                            <img src="{{ asset('templandingpage/assets/images/logo.png') }}" alt="Logo"
                                style="height: 40px;">
                        </a>

                        <ul class="nav">
                            <li class="scroll-to-section"><a href="#top" class="active">Beranda</a></li>
                            <li class="scroll-to-section"><a href="#abouts">About</a></li>
                            <li class="scroll-to-section"><a href="#">Survei</a></li>
                            <li class="scroll-to-section"><a href="#">Kepuasan</a></li>
                            <li class="scroll-to-section">
                                <div class="main-red-button"><a href="#">Login</a></div>
                            </li>
                        </ul>
                        <a class='menu-trigger'><span>Menu</span></a>
                    </nav>
                </div>
            </div>
        </div>
    </header>
    <!-- ***** Header Area End ***** -->

    <!-- Main banner -->
    <div class="main-banner wow fadeIn" id="top" data-wow-duration="1s" data-wow-delay="0.5s">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="row">
                        <div class="col-lg-6 align-self-center">
                            <div class="left-content header-text wow fadeInLeft" data-wow-duration="1s" data-wow-delay="1s">
                                <h6>Selamat Datang di Website</h6>
                                <h2><em>Tracer Study</em> Jurusan Teknologi Informasi</h2>
                                <p>Website ini digunakan untuk mendukung pelacakan alumni dan pengumpulan data penting yang
                                    berkaitan dengan lulusan Jurusan Teknologi Informasi Politeknik Negeri Malang.</p>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="right-image wow fadeInRight" data-wow-duration="1s" data-wow-delay="0.5s">
                                <img src="{{ asset('templandingpage/assets/images/bg.png') }}">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- abouts Section -->
    <div id="abouts" class="our-abouts section">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 align-self-center wow fadeInLeft" data-wow-duration="1s" data-wow-delay="0.2s">
                    <div class="left-image">
                        <img src="{{ asset('templandingpage/assets/images/search.jpg') }}" alt="">
                    </div>
                </div>
                <div class="col-lg-6 wow fadeInRight" data-wow-duration="1s" data-wow-delay="0.2s">
                    <div class="section-heading">
                        <h2>Apa itu <em>Tracer Study</em>?</h2>
                        <p>
                            Tracer Study Jurusan Teknologi Informasi (JTI) Politeknik Negeri Malang adalah kegiatan
                            pelacakan alumni yang bertujuan untuk mengetahui jejak lulusan setelah menyelesaikan studi,
                            serta mendapatkan masukan dari pengguna lulusan (user tracer), seperti perusahaan atau instansi
                            tempat alumni bekerja. Kegiatan ini dilaksanakan secara online melalui sistem yang telah
                            disediakan, sehingga memudahkan alumni dan pengguna lulusan untuk mengisi kuesioner kapan pun
                            dan di mana pun. Tracer study menjadi bagian dari upaya evaluasi dan pengembangan mutu
                            pendidikan, serta sebagai dasar pengambilan keputusan strategis, khususnya dalam penyusunan
                            kurikulum yang lebih relevan dengan kebutuhan dunia kerja dan industri.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- About Section -->
    <div id="about" class="about-us section">
        <div class="container">
            <div class="row">
                <div class="col-lg-4">
                    <div class="left-image wow fadeIn" data-wow-duration="1s" data-wow-delay="0.2s">
                        <img src="{{ asset('templandingpage/assets/images/about-left-image.png') }}" alt="person graphic">
                    </div>
                </div>
                <div class="col-lg-8 align-self-center">
                    <div class="abouts">
                        <div class="row">
                            @foreach ([['icon' => 'service-icon-01.png', 'title' => 'Data Analysis'], ['icon' => 'service-icon-02.png', 'title' => 'Data Reporting'], ['icon' => 'service-icon-03.png', 'title' => 'Web Analytics'], ['icon' => 'service-icon-04.png', 'title' => 'SEO Suggestions']] as $item)
                                <div class="col-lg-6">
                                    <div class="item wow fadeIn" data-wow-duration="1s">
                                        <div class="icon">
                                            <img src="{{ asset('templandingpage/assets/images/' . $item['icon']) }}"
                                                alt="">
                                        </div>
                                        <div class="right-text">
                                            <h4>{{ $item['title'] }}</h4>
                                            <p>Lorem ipsum dolor sit amet, ctetur aoi adipiscing eliter</p>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Portfolio Section -->
    <div id="portfolio" class="our-portfolio section">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 offset-lg-3">
                    <div class="section-heading wow bounceIn" data-wow-duration="1s" data-wow-delay="0.2s">
                        <h2>Team of <em>TRACKER</em></h2>
                    </div>
                </div>
            </div>
            <div class="row">
                @php
                    $team = [
                        'Ketua' => 'Farel Maryam Laila Hajiri',
                        'Anggota 1' => 'Dwi Septa Satria Agung',
                        'Anggota 2' => 'Jaden Natha Kautsar',
                        'Anggota 3' => 'Aidatul Rosida',
                    ];
                @endphp

                @foreach ($team as $title => $name)
                    <div class="col-lg-3 col-sm-6">
                        <a href="#">
                            <div class="item wow bounceInUp" data-wow-duration="1s"
                                data-wow-delay="0.{{ $loop->index + 3 }}s">
                                <div class="hidden-content">
                                    <h4>{{ $title }}</h4>
                                    <p>{{ $name }}</p>
                                </div>
                                <div class="showed-content">
                                    <img src="{{ asset('templandingpage/assets/images/portfolio-image.png') }}"
                                        alt="">
                                </div>
                            </div>
                        </a>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

@endsection
