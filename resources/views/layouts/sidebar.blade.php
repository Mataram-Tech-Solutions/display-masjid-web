<aside class="sidenav bg-white navbar navbar-vertical navbar-expand-xs border-0 border-radius-xl my-3 fixed-start ms-4 " id="sidenav-main">
  <div class="sidenav-header">
    <i class="fas fa-times p-3 cursor-pointer text-secondary opacity-5 position-absolute end-0 top-0 d-none d-xl-none" aria-hidden="true" id="iconSidenav"></i>
    <a class="navbar-brand m-0" href=" https://demos.creative-tim.com/argon-dashboard/pages/dashboard.html " target="_blank">
      <img src="../assets/img/logo-ct-dark.png" width="26px" height="26px" class="navbar-brand-img h-100" alt="main_logo">
      <span class="ms-1 font-weight-bold">Creative Tim</span>
    </a>
  </div>
  <hr class="horizontal dark mt-0">
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link {{ Route::currentRouteName() == 'dashboard.index' ? 'active' : '' }}" href="{{ route('dashboard.index') }}">
          <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
            <i class="ni ni-tv-2 text-dark text-sm opacity-10"></i>
          </div>
          <span class="nav-link-text ms-1">Dashboard</span>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link {{ in_array(Route::currentRouteName(), ['jadwalsholat.index', 'jadwalsholat.edit']) ? 'active' : '' }}" href="{{ route('jadwalsholat.index') }}">
                 <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
            <i class="ni ni-calendar-grid-58 text-dark text-sm opacity-10"></i>
          </div>
          <span class="nav-link-text ms-1">Jadwal Sholat</span>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link {{ in_array(Route::currentRouteName(), ['jadwalkajian.index', 'jadwalkajian.edit', 'jadwalkajian.create']) ? 'active' : '' }}" href="{{ route('jadwalkajian.index') }}">
          <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
            <i class="ni ni-credit-card text-dark text-sm opacity-10"></i>
          </div>
          <span class="nav-link-text ms-1">Jadwal Kajian</span>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link {{ in_array(Route::currentRouteName(), ['ulama.index', 'ulama.edit', 'ulama.create']) ? 'active' : '' }}" href="{{ route('ulama.index') }}">
          <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
            <i class="ni ni-app text-dark text-sm opacity-10"></i>
          </div>
          <span class="nav-link-text ms-1">Ulama</span>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link {{ in_array(Route::currentRouteName(), ['muharram.index', 'muharram.edit']) ? 'active' : '' }}" href="{{ route('muharram.index') }}">
          <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
            <i class="ni ni-world-2 text-dark text-sm opacity-10"></i>
          </div>
          <span class="nav-link-text ms-1">Muharram</span>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link {{ in_array(Route::currentRouteName(), ['audio.index', 'audio.create']) ? 'active' : '' }}" href="{{ route('audio.index') }}">
          <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
            <i class="ni ni-world-2 text-dark text-sm opacity-10"></i>
          </div>
          <span class="nav-link-text ms-1">Audio</span>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link {{ in_array(Route::currentRouteName(), ['primarydisplay.index', 'primarydisplay.create']) ? 'active' : '' }}" href="{{ route('primarydisplay.index') }}">
          <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
            <i class="ni ni-world-2 text-dark text-sm opacity-10"></i>
          </div>
          <span class="nav-link-text ms-1">Gambar & Vidio</span>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link {{ in_array(Route::currentRouteName(), ['centxt.index', 'centxt.edit', 'centxt.create']) ? 'active' : '' }}" href="{{ route('centxt.index') }}">
          <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
            <i class="ni ni-world-2 text-dark text-sm opacity-10"></i>
          </div>
          <span class="nav-link-text ms-1">Konten Display Hadist</span>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link {{ in_array(Route::currentRouteName(), ['runtxt.index', 'runtxt.edit', 'runtxt.create']) ? 'active' : '' }}" href="{{ route('runtxt.index') }}">
          <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
            <i class="ni ni-world-2 text-dark text-sm opacity-10"></i>
          </div>
          <span class="nav-link-text ms-1">Konten Running Text</span>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link {{ in_array(Route::currentRouteName(), ['masjid.index', 'masjid.edit']) ? 'active' : '' }}" href="{{ route('masjid.index') }}">
          <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
            <i class="ni ni-world-2 text-dark text-sm opacity-10"></i>
          </div>
          <span class="nav-link-text ms-1">Profile Masjid</span>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link {{ in_array(Route::currentRouteName(), ['astronomis.index', 'astronomis.edit']) ? 'active' : '' }}" href="{{ route('astronomis.index') }}">
          <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
            <i class="ni ni-world-2 text-dark text-sm opacity-10"></i>
          </div>
          <span class="nav-link-text ms-1">Astronomis</span>
        </a>
      </li>
      
    </ul>


</aside>