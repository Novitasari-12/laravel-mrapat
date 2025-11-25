<ul class="navbar-nav">
    <li class="nav-item">
    <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
    </li>
    @if (auth()->user()->level->level == 'adum_fasilitas')
        @include('adum_fasilitas.nav-left')
    @endif
    @if (auth()->user()->level->level == 'sekretaris_bidang')
        @include('sekretaris_bidang.nav-left')
    @endif
    <li class="nav-item d-none d-sm-inline-block">
        <a href="{{route('logout')}}" class="nav-link">Logout</a>
    </li>
</ul>