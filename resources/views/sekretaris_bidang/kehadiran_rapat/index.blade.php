@extends('admin-partials.welcome')
@section('content-title')
    Kehadiran Rapat
@endsection
@section('content')
<div class="card">
    <div class="card-body">
         <?php $no = 1 ; ?>
        <table class="table"> 
            <thead>
                <tr>
                    <th style="width:1%;">#</th>
                    <th> Nama</th>
                    <th> Ruangan</th>
                    <th> Waktu Rapat</th>
                    <th> Jumlah Peserta</th>
                    <th> Kehadiran </th>
                </tr>
            </thead>
            <tbody>
                @foreach ($raker as $item)
                    <tr>
                        <td> {{$no++}} </td>
                        <td> {{$item->nama_raker}} </td>
                        <td> {{$item->ruangan->nama_ruangan }} </td>
                        <td> {{$item->tanggal_jam_masuk_raker}} -{{$item->tanggal_jam_keluar_raker}} </td>
                        <td> {{$item->jumlah_peserta_raker}} </td>
                        <td>
                            <a href=" {{route('sb_kehadiran_rapat.show', $item->id)}} " class="btn btn-xs btn-success"> <b class="fa fa-print"></b> </a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
   
@endsection