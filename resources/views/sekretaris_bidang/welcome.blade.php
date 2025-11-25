@extends('admin-partials.welcome')
@section('content-title')
    Home
@endsection
@section('content')
    <div class="card">
        <div class="card-body">
            <iframe id="frame" style="border: none ; height: 786px;" class="col-md-12" src=" {{route('jadwal_rapat.layar_penuh')}} " title="W3Schools Free Online Web Tutorials"></iframe>
        </div>
    </div>
@endsection