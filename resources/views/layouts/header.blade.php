<nav class="navbar navbar-main navbar-expand-lg px-0 mx-4 shadow-none border-radius-xl" id="navbarBlur" data-scroll="false">
    <div class="container-fluid py-1 px-3">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb bg-transparent mb-0 pb-0 pt-1 px-0 me-sm-6 me-5">
                <li class="breadcrumb-item text-sm">
                    <a class="opacity-5 text-white" 
                    href="{{ 
                        Route::currentRouteName() == 'dashboard.index' ? route('dashboard.index') : 
                        (Route::currentRouteName() == 'jadwalsholat.index' ? route('jadwalsholat.index') : 
                        (Route::currentRouteName() == 'jadwalsholat.edit' ? route('jadwalsholat.index') : 
                        (Route::currentRouteName() == 'jadwalkajian.index' ? route('jadwalkajian.index') : 
                        (Route::currentRouteName() == 'jadwalkajian.edit' ? route('jadwalkajian.index') : 
                        (Route::currentRouteName() == 'jadwalkajian.create' ? route('jadwalkajian.index') : 
                        (Route::currentRouteName() == 'ulama.index' ? route('ulama.index') : 
                        (Route::currentRouteName() == 'ulama.edit' ? route('ulama.index') : 
                        (Route::currentRouteName() == 'ulama.create' ? route('ulama.index') :
                        (Route::currentRouteName() == 'muharram.index' ? route('muharram.index') : 
                        (Route::currentRouteName() == 'muharram.edit' ? route('muharram.index') :
                        (Route::currentRouteName() == 'audio.index' ? route('audio.index') : 
                        (Route::currentRouteName() == 'audio.create' ? route('audio.index') : 'javascript:void(0);')))))))))))) 
                    }}">
                    @if(Route::currentRouteName() == 'dashboard.index')
                        
                    @elseif(Route::currentRouteName() == 'jadwalsholat.index')
                        
                    @elseif(Route::currentRouteName() == 'jadwalsholat.edit')
                        Jadwal Sholat
                    @elseif(Route::currentRouteName() == 'jadwalkajian.index')
                        
                    @elseif(Route::currentRouteName() == 'jadwalkajian.edit')
                        Jadwal Kajian
                    @elseif(Route::currentRouteName() == 'jadwalkajian.create')
                        Jadwal Kajian
                    @elseif(Route::currentRouteName() == 'ulama.index')
                        
                    @elseif(Route::currentRouteName() == 'ulama.edit')
                        Ulama
                    @elseif(Route::currentRouteName() == 'ulama.create')
                        Ulama
                    @elseif(Route::currentRouteName() == 'muharram.index')
                        
                    @elseif(Route::currentRouteName() == 'muharram.edit')
                        Muharram
                    @elseif(Route::currentRouteName() == 'audio.index')
                        
                    @elseif(Route::currentRouteName() == 'audio.create')
                        Audio
                    @else
                        Unknown Page
                    @endif
                 </a>
                 
                 <li class="breadcrumb-item text-sm text-white active" aria-current="page">
                     @if(Route::currentRouteName() == 'dashboard.index')
                         Dashboard
                     @elseif(Route::currentRouteName() == 'jadwalsholat.index')
                         Jadwal Sholat
                     @elseif(Route::currentRouteName() == 'jadwalsholat.edit')
                         Edit Jadwal Sholat
                     @elseif(Route::currentRouteName() == 'jadwalkajian.index')
                         Jadwal Kajian
                     @elseif(Route::currentRouteName() == 'jadwalkajian.edit')
                         Edit Jadwal Kajian
                     @elseif(Route::currentRouteName() == 'jadwalkajian.create')
                         Tambah Jadwal Kajian
                     @elseif(Route::currentRouteName() == 'ulama.index')
                         Ulama
                     @elseif(Route::currentRouteName() == 'ulama.edit')
                         Edit Ulama
                     @elseif(Route::currentRouteName() == 'ulama.create')
                         Tambah Ulama
                     @elseif(Route::currentRouteName() == 'muharram.index')
                         Muharram
                     @elseif(Route::currentRouteName() == 'muharram.edit')
                         Edit Tahun Hijriyah
                     @elseif(Route::currentRouteName() == 'audio.index')
                         Audio
                     @elseif(Route::currentRouteName() == 'audio.create')
                         Tambah File Audio
                     @else
                         Unknown Page
                     @endif
                 </li>                 
            </ol>
            <h6 class="font-weight-bolder text-white mb-0">
                @if(Route::currentRouteName() == 'dashboard.index')
                    Dashboard
                @elseif(Route::currentRouteName() == 'jadwalsholat.index')
                    Jadwal Sholat
                    @elseif(Route::currentRouteName() == 'jadwalsholat.edit')
                    Edit Jadwal Sholat
                @elseif(Route::currentRouteName() == 'jadwalkajian.index')
                    Jadwal Kajian
                @elseif(Route::currentRouteName() == 'jadwalkajian.edit')
                    Edit Jadwal Kajian
                @elseif(Route::currentRouteName() == 'jadwalkajian.create')
                    Tambah Jadwal Kajian
                @elseif(Route::currentRouteName() == 'ulama.index')
                    Ulama
                @elseif(Route::currentRouteName() == 'ulama.edit')
                    Edit ulama
                @elseif(Route::currentRouteName() == 'ulama.create')
                    Tambah ulama
                @elseif(Route::currentRouteName() == 'muharram.index')
                    Muharram
                @elseif(Route::currentRouteName() == 'muharram.edit')
                    Edit Tahun Hijriyah
                @elseif(Route::currentRouteName() == 'audio.index')
                    Audio
                @elseif(Route::currentRouteName() == 'audio.create')
                    Tambah File Audio
                @else
                    Unknown Page
                @endif
            </h6>
        </nav>
        <div class="collapse navbar-collapse mt-sm-0 mt-2 me-md-0 me-sm-4" id="navbar">
            <div class="ms-md-auto pe-md-3 d-flex align-items-center">
                <!-- Menampilkan Tanggal -->
                <span class="text-white me-3">
                    {{ \Carbon\Carbon::now()->toFormattedDateString() }}
                </span>
            </div>
            <ul class="navbar-nav justify-content-end">
                <li class="nav-item dropdown d-flex align-items-center">
                    <a class="nav-link text-white font-weight-bold px-0 dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="fa fa-user me-sm-1"></i>
                        <span class="d-sm-inline d-none">{{ Auth::user()->name }}</span>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuLink">
                        <li>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="dropdown-item">
                                    <i class="fa fa-sign-out-alt me-2"></i> Logout
                                </button>
                            </form>
                        </li>
                    </ul>                
                </li>
                <li class="nav-item d-xl-none ps-3 d-flex align-items-center">
                    <a href="javascript:;" class="nav-link text-white p-0" id="iconNavbarSidenav">
                      <div class="sidenav-toggler-inner">
                        <i class="sidenav-toggler-line bg-white"></i>
                        <i class="sidenav-toggler-line bg-white"></i>
                        <i class="sidenav-toggler-line bg-white"></i>
                      </div>
                    </a>
                  </li>
            </ul>
            
        </div>
    </div>
</nav>
