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

<div class="card">
    <div class="card-body">
        <table class="table table-condensed">
            <thead>
                <tr>
                    <th>Waktu Rapat</th>
                    <th>Waktu Selesai Rapat</th>
                    <th>Nama Rapat</th>
                    <th>Ruangan Rapat</th>
                    <th>Jumlah Peserta Rapat</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($rakerNow as $item)
                    <tr>
                        <th style="width:20%;"> {{date('d-m-Y | H:i',strtotime($item->tanggal_jam_masuk_raker))}} </th>
                        <th style="width:20%;"> {{date('d-m-Y | H:i',strtotime($item->tanggal_jam_keluar_raker))}} </th>
                        <td> {{$item->nama_raker}} </td>
                        <td> {{$item->ruangan->nama_ruangan}} </td>
                        <td> {{$item->jumlah_peserta_raker}} Orang </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection

