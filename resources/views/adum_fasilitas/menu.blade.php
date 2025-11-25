
<?php 
    function menu($route, $name, $arr=[]){
        $url = route($route, $arr) ;
        $status = $url == url()->full() ? 'active' : '' ;
        return [
            'url' => $url,
            'status' => $status,
            'name' => $name,
        ];
    }

    $menu = [
        menu('adum_fasilitas.index', 'Home'),
        menu('informasi_gambar.index', 'Informasi Gambar'),
        menu('ad_persetujuan_rapat.index', 'Persetujuan Rapat'),
        menu('ad_ruangan_rapat.index', 'Ruang Rapat'),
        menu('ad_fasilitas_rapat.index', 'Fasilitas Rapat'),
        menu('ad_sekretaris_bidang.index', 'Sekretaris Bidang'),
        menu('ad_pegawai_perusahaan.index', 'Pegawai Perusahaan'),
    ];
?>

@foreach ($menu as $item)
    <li class="nav-item">
        <a href="{{$item['url']}}" class="nav-link {{$item['status']}}">
            <i class="far fa-circle nav-icon"></i>
            <p> {{$item['name']}}  </p>
        </a>
    </li>
@endforeach
