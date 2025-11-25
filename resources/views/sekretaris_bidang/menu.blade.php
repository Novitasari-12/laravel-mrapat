
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
        menu('sekretaris_bidang.index', 'Home'),
        menu('sb_permohonan_rapat.index', 'Permohonan Rapat'),
        // menu('sb_persetujuan_rapat.index', 'Persetujuan Rapat'),
        menu('sb_kesimpulan_rapat.index', 'Kesimpulan Rapat'),
        menu('sb_kehadiran_rapat.index', 'Kehadiran Rapat'),
        
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