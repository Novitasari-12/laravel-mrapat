<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0 text-dark">@yield('content-title')</h1>
      </div><!-- /.col -->
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          {!!getBreadCrumb()!!}
        </ol>
      </div><!-- /.col -->
    </div><!-- /.row -->
  </div><!-- /.container-fluid -->
</div>

    
@php
  function getBreadCrumb(){
    $url = explode('/', url()->full()) ;
    $num_url = count($url);
    $path = '' ;
    $result = '' ;
    for($i=3; $i<$num_url; $i++){
      $path .= "/".$url[$i] ;
      $link = url($path);
      $result .= "<li class=\"breadcrumb-item\"><a href=\"{$link}\">".ucwords(str_replace('_', ' ', $url[$i]))."</a></li>";
    }
    return $result;
  }
@endphp