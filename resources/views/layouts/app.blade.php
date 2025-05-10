@include('layouts.header')

@yield('content')

@include('layouts.footer')

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>@yield('title', 'Dashboard')</title>

  {{-- Favicon (pindahkan logo Anda ke public/images jika diperlukan) --}}
  <link rel="icon" href="{{ asset('images/logo.png') }}" type="image/png">

  {{-- Remix Icon CDN (jika Anda menggunakan Remix Icons) --}}
  <link href="https://cdn.jsdelivr.net/npm/remixicon/fonts/remixicon.css" rel="stylesheet">

  {{-- CSS hasil salinan dari React --}}
  <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body class="bg-[#E3F2FD] font-sans">

  {{-- Sidebar --}}
  @include('partials.sidebar')

  {{-- Header / Topbar --}}
  @include('partials.header')

  {{-- Konten Utama --}}
  <main class="p-6">
    @yield('content')
  </main>

  {{-- JS jika ada --}}
  <script src="{{ asset('js/app.js') }}"></script>
</body>
</html>
