<!doctype html>
<html lang="id">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1" />
  
  <title>{{ config('app.name', 'Laravel') }}</title>

  <link rel="stylesheet" href="{{ asset('css/style.css') }}" />
  
  <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body>
  <div class="split">
    
    <div class="left-visual">
      <img src="{{ asset('build/assets/logo.svg') }}" alt="logo" class="logo-main"/>
      
      @if (request()->routeIs('register'))
        <h1>Buat akun untuk mulai melapor</h1>
        <p>Daftar cepat dengan email kampus. Akun akan mempermudah pelacakan tiket dan komunikasi dengan admin.</p>
      @else
        <h1>Selamat Datang di Sistem Pengaduan Mahasiswa</h1>
        <p>Laporkan masalah, pantau progres, dan bantu perbaikan fasilitas kampus. Mudah, cepat, dan terpantau.</p>
      @endif
      
      <div class="illust">
        <img src="{{ asset('build/assets/illustration.svg') }}" alt="ilustrasi" style="width:75%; max-width:420px; display:block"/>
      </div>
    </div>

    <div class="right-form">
      <div class="card" role="main">
        
        {{ $slot }}

      </div>
    </div>
  </div>
</body>
</html>