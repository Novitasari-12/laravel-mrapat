<ul class="navbar-nav">
    <li class="nav-item {{active_link('jadwal_rapat.index')}} ">
        <a href=" {{route('jadwal_rapat.index')}} " class="nav-link">Jadwal Rapat</a>
    </li>
    <li class="nav-item {{active_link('jadwal_rapat.info')}} ">
        <a href=" {{route('jadwal_rapat.info')}} " class="nav-link">Informasi</a>
    </li>
    <li class="nav-item {{active_link('absensi.index')}} ">
        <a href=" {{route('absensi.index')}} " class="nav-link">Absensi</a>
    </li>
    <li class="nav-item {{active_link('peserta.change_password.index')}} ">
        <a href=" {{route('peserta.change_password.index')}} " class="nav-link">Peserta</a>
    </li>
    <li class="nav-item {{active_link('login.index')}} ">
        <a href=" {{route('login.index')}} " class="nav-link">Login</a>
    </li>
    <li class="nav-item {{active_link('notulen.index.login')}}">
        <a href=" {{route('notulen.index.login')}} " class="nav-link">Login Notulen</a>
    </li>
    {{-- </li>
        <li class="nav-item dropdown">
            <a id="dropdownSubMenu1" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="nav-link dropdown-toggle">Dropdown</a>
            <ul aria-labelledby="dropdownSubMenu1" class="dropdown-menu border-0 shadow">
                <li><a href="#" class="dropdown-item">Some action </a></li>
                <li><a href="#" class="dropdown-item">Some other action</a></li>

                <li class="dropdown-divider"></li>

                <!-- Level two dropdown-->
                <li class="dropdown-submenu dropdown-hover">
                    <a id="dropdownSubMenu2" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="dropdown-item dropdown-toggle">Hover for action</a>
                    <ul aria-labelledby="dropdownSubMenu2" class="dropdown-menu border-0 shadow">
                        <li>
                        <a tabindex="-1" href="#" class="dropdown-item">level 2</a>
                        </li>

                        <!-- Level three dropdown-->
                        <li class="dropdown-submenu">
                        <a id="dropdownSubMenu3" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="dropdown-item dropdown-toggle">level 2</a>
                        <ul aria-labelledby="dropdownSubMenu3" class="dropdown-menu border-0 shadow">
                            <li><a href="#" class="dropdown-item">3rd level</a></li>
                            <li><a href="#" class="dropdown-item">3rd level</a></li>
                        </ul>
                        </li>
                        <!-- End Level three -->

                        <li><a href="#" class="dropdown-item">level 2</a></li>
                        <li><a href="#" class="dropdown-item">level 2</a></li>
                    </ul>
                </li>
            <!-- End Level two -->
            </ul>
        </li>
    </li> --}}
</ul>

@php
    function active_link($route_url){
        return url()->full() == route($route_url) ? 'active' : '' ;
    }
@endphp