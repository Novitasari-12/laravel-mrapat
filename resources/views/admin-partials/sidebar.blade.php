<nav class="mt-2">
    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
        @if (auth()->user()->level->level == 'adum_fasilitas')
            @include('adum_fasilitas.menu')
        @endif
        @if (auth()->user()->level->level == 'sekretaris_bidang')
            @include('sekretaris_bidang.menu')
        @endif
        @if (auth()->user()->level->level == 'notulen')
            @include('notulen.menu')
        @endif
    </ul>
</nav>