@extends('welcome')
@section('content-title')
    Jadwal Rapat
@endsection
@section('content')
<div class="container-fluid wrap">
    <div class="card" style="background-image: url({{asset('images/kerja_bg.jpg')}}) ; background-size: cover ;">
        <div class="card-header">
            <a href=" {{route('jadwal_rapat.layar_penuh')}} " class="btn btn-xs btn-primary"> <span class="fa fa-eye"></span> Lebih Jelas </a>
        </div>
        <div class="card-body">
            <iframe id="frame" style="border: none ; height: 786px;" class="col-md-12" src=" {{route('jadwal_rapat.layar_penuh')}} " title="W3Schools Free Online Web Tutorials"></iframe>
        </div>
    </div>
</div>
@endsection