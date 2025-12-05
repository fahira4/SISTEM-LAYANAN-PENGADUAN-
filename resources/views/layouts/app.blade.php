<!doctype html>
<html lang="id">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1" />
  <title>{{ $title ?? 'Dashboard' }} - Pengaduan Mahasiswa</title>
  
  <link rel="stylesheet" href="{{ asset('css/style.css') }}" />
  
  <meta name="csrf-token" content="{{ csrf_token() }}">
  
  @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body style="background:var(--offwhite); min-height: 100vh; display: flex; flex-direction: column; padding-top: 80px;">

<header style="position: fixed; top: 0; left: 0; right: 0; z-index: 1000; background: white; box-shadow: 0 2px 4px rgba(27, 60, 83, 0.1); padding: 12px 24px; transition: box-shadow 0.3s ease, opacity 0.3s ease; border-radius: 0 0 20px 20px; background: rgba(255, 255, 255, 0.95);">
  <nav class="navbar" role="navigation" aria-label="Main Navigation" class="container" style="display: flex; justify-content: space-between; align-items: center; max-width: 100% !important; margin: 0; padding: 0;">
    <div class="nav-left">
      <img src="{{ asset('build/assets/logo.svg') }}" alt="logo" style="height: 40px;">
      <div style="margin-left: 12px;">
        <div style="font-weight:700; color: #1B3C53; font-size: 16px;">
            @if (Auth::user()->role == 'admin')
                Panel Admin
            @else
                Pengaduan Mahasiswa
            @endif
        </div>
        <div style="font-size:12px; color: #6c757d;">Sistem laporan & pelacakan</div>
      </div>
    </div>
    <div class="nav-right">
        <div class="nav-links" aria-hidden="true">
        @if (Auth::user()->role == 'admin')
            <a href="{{ route('admin.dashboard') }}" class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}" style="text-decoration: none; color: #1B3C53; font-weight: 500; padding: 8px 12px; border-radius: 6px; margin: 0 4px; transition: background-color 0.2s ease;">Dashboard Admin</a>
            <a href="{{ route('admin.statistik') }}" class="{{ request()->routeIs('admin.statistik') ? 'active' : '' }}" style="text-decoration: none; color: #1B3C53; font-weight: 500; padding: 8px 12px; border-radius: 6px; margin: 0 4px; transition: background-color 0.2s ease;">Statistik</a> 
            @else
            <a href="{{ route('dashboard') }}" class="{{ request()->routeIs('dashboard') ? 'active' : '' }}" style="text-decoration: none; color: #1B3C53; font-weight: 500; padding: 8px 12px; border-radius: 6px; margin: 0 4px; transition: background-color 0.2s ease;">Dashboard</a>
            <a href="{{ route('pengaduan.create') }}" class="{{ request()->routeIs('pengaduan.create') ? 'active' : '' }}" style="text-decoration: none; color: #1B3C53; font-weight: 500; padding: 8px 12px; border-radius: 6px; margin: 0 4px; transition: background-color 0.2s ease;">Buat Pengaduan</a> 
            @endif
            <a href="{{ route('profile.edit') }}" class="{{ request()->routeIs('profile.edit') ? 'active' : '' }}" style="text-decoration: none; color: #1B3C53; font-weight: 500; padding: 8px 12px; border-radius: 6px; margin: 0 4px; transition: background-color 0.2s ease;">Profil</a>
        </div>
      <button class="hamburger" id="hamburgerBtn" aria-label="Buka menu" style="background: none; border: none; cursor: pointer; padding: 8px;">
        <svg width="20" height="14" viewBox="0 0 20 14" fill="none" xmlns="http://www.w3.org/2000/svg"><rect width="20" height="2" rx="1" fill="#1B3C53"/><rect y="6" width="20" height="2" rx="1" fill="#1B3C53"/><rect y="12" width="20" height="2" rx="1" fill="#1B3C53"/></svg>
      </button>
      
      <div class="profile-dropdown">
        <button class="avatar" id="avatarBtn" aria-label="Buka menu profil" style="background-color: #1B3C53; color: white; width: 40px; height: 40px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-weight: bold; cursor: pointer; border: none;">
          {{ substr(Auth::user()->name, 0, 1) }}
        </button>
        <div class="dropdown-menu" id="dropdownMenu" >
          <a href="{{ route('profile.edit') }}">Profil Saya</a>
          
          <form method="POST" action="{{ route('logout') }}" style="margin:0;">
            @csrf
            <a href="{{ route('logout') }}" 
               onclick="event.preventDefault(); this.closest('form').submit();"
               style="color: var(--danger);">
              Logout
            </a>
          </form>
        </div>
      </div>
    </div>
  </nav>
</header>

<div class="menu-overlay" id="menuOverlay" hidden></div>
<aside class="menu-panel" id="menuPanel" aria-hidden="true">
    <button class="menu-close" id="menuCloseBtn" aria-label="Tutup menu">&times;</button>
    <div style="font-weight:700;font-size:16px;color:var(--primary-dark)">
        @if (Auth::user()->role == 'admin')
            Menu Admin
        @else
            Menu
        @endif
    </div>
    <nav class="menu-links" role="menu">
      @if (Auth::user()->role == 'admin')
          <a href="{{ route('admin.dashboard') }}" role="menuitem">Dashboard Admin</a>
          <a href="{{ route('admin.statistik') }}" role="menuitem">Statistik</a> 
          @else
          <a href="{{ route('dashboard') }}" role="menuitem">Dashboard</a>
          <a href="{{ route('pengaduan.create') }}" role="menuitem">Buat Pengaduan</a>
      @endif

      <a href="{{ route('profile.edit') }}" role="menuitem">Profil</a>
      
      <form method="POST" action="{{ route('logout') }}" style="margin:0;">
        @csrf
        <a href="{{ route('logout') }}" 
           onclick="event.preventDefault(); this.closest('form').submit();" 
           role="menuitem" 
           style="color: var(--danger);">
          Logout
        </a>
      </form>
    </nav>
</aside>

<main class="container" style="margin-top:18px; flex: 1;">
    {{ $slot }}
</main>

<footer class="footer" style="background: #f8f9fa; color: #6c757d; padding: 20px 0; border-top: 1px solid #e9ecef; margin-top: auto;">
    <div class="container" style="display: flex; justify-content: space-between; align-items: center; text-align: center;">
        <div style="font-size: 14px; text-align: left;">
            &copy; {{ date('Y') }} Sistem Layanan Pengaduan Mahasiswa. All rights reserved.
        </div>
        <div style="font-size: 14px; text-align: right;">
            <a href="#" style="color: #6c757d; text-decoration: none; margin: 0 10px;">Tentang Kami</a>
            <a href="#" style="color: #6c757d; text-decoration: none; margin: 0 10px;">Kontak</a>
            <a href="#" style="color: #6c757d; text-decoration: none; margin: 0 10px;">Bantuan</a>
        </div>
    </div>
</footer>
  
<div id="toast" class="toast" aria-hidden="true"></div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Menu Mobile
    const btn = document.getElementById('hamburgerBtn');
    const panel = document.getElementById('menuPanel');
    const overlay = document.getElementById('menuOverlay');
    const closeBtn = document.getElementById('menuCloseBtn');
    
    function openMenu(){ if(panel) { panel.classList.add('open'); overlay.style.display='block'; document.body.style.overflow='hidden'; } }
    function closeMenu(){ if(panel) { panel.classList.remove('open'); overlay.style.display='none'; document.body.style.overflow=''; } }
    
    if(btn) btn.addEventListener('click', openMenu);
    if(closeBtn) closeBtn.addEventListener('click', closeMenu);
    if(overlay) overlay.addEventListener('click', closeMenu);

    // Dropdown Profil
    const avatarBtn = document.getElementById('avatarBtn');
    const dropdownMenu = document.getElementById('dropdownMenu');
    if (avatarBtn && dropdownMenu) {
        avatarBtn.addEventListener('click', (e) => { 
            e.stopPropagation(); 
            let isShowing = !dropdownMenu.hidden;
            dropdownMenu.hidden = isShowing;
        });
        window.addEventListener('click', () => { 
            if (!dropdownMenu.hidden) { 
                dropdownMenu.hidden = true;
            } 
        });
    }

    // Navbar opacity and shadow on scroll
    window.addEventListener('scroll', function() {
        const nav = document.querySelector('header');
        if (window.scrollY > 10) {
            nav.style.boxShadow = '0 4px 12px rgba(27, 60, 83, 0.15)';
            nav.style.opacity = '0.9';
        } else {
            nav.style.boxShadow = '0 2px 4px rgba(27, 60, 83, 0.1)';
            nav.style.opacity = '1';
        }
    });
});
</script>

@stack('scripts') </body>
</html>
