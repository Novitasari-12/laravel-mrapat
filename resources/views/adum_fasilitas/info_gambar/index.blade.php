@extends('admin-partials.welcome')
@section('content-title')
    Informasi Gambar 
@endsection
@section('content')
    <div class="card">
        <div class="card-header">
            <a href=" {{route('informasi_gambar.create')}} " class="btn btn-xs btn-success"> <i class="fa fa-plus"></i> Buat Informasi Gambar </a>
        </div>
        <div class="card-body">
            <table class="table">
                <thead>
                    <th> # </th>
                    <th> Nama </th>
                    <th> Gambar </th>
                    <th> Waktu Ditampilkan </th>
                    <th> Waktu Selesai Ditampilkan </th>
                    <th> </th>
                </thead>
                <tbody>
                    @php
                        $index = 1 ;
                    @endphp
                    @foreach ($igambar as $item)
                        <tr>
                            <td> {{$index++}} </td>
                            <td> {{$item->nama}} </td>
                            <td>
                                <button data-toggle="modal" data-target="#item-{{$item->id}}" class="btn btn-sm btn-default">
                                        <img src="{{$item->gambar}}" width="75px" alt="{{$item->nama}}-gambar" />
                                        </button>
                                        <div class="modal fade" id="item-{{$item->id}}">
                                            <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                <h4 class="modal-title"> {{$item->nama}}</h4>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                                </div>
                                                <div class="modal-body">
                                                    <p>
                                                        {{$item->informasi_gambar}}
                                                    </p>
                                                    <img src="{{$item->gambar}}" width="100%" alt="{{$item->nama}}-gambar" />
                                                </div>
                                                <div class="modal-footer justify-content-between">
                                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                                </div>
                                            </div>
                                            <!-- /.modal-content -->
                                            </div>
                                            <!-- /.modal-dialog -->
                                        </div>
                                        <!-- /.modal -->
                            </td>
                            <td> {{$item->waktu_mulai_ditampilkan}} </td>
                            <td> {{$item->waktu_selesai_ditampilkan}} </td>
                            <td> 

                                <a href=" {{route('informasi_gambar.edit', [$item->id])}} " class="btn btn-primary btn-xs">
                                    <span class="fa fa-edit"></span>
                                </a>
                                <button data-toggle="modal" data-target="#delete-{{$item->id}}"  class="btn btn-danger btn-xs">
                                    <span class="fa fa-times"></span>
                                </button>
                                <div class="modal fade" id="delete-{{$item->id}}">
                                <div class="modal-dialog">
                                    <div class="modal-content bg-danger">
                                        <div class="modal-header">
                                        <h4 class="modal-title">Hapus data informasi gambar</h4>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                        </div>
                                        <div class="modal-body">
                                        <form action="{{route('informasi_gambar.destroy', [$item->id])}}" method="post">
                                            {{ csrf_field() }}
                                            {{method_field('DELETE')}}
                                            <button type="submit" class="btn btn-default btn-sm col-md-12 col-sm-12"> Hapus </button>
                                        </form>
                                        </div>
                                    </div>
                                </div>

                            </td>
                        </tr>                        
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection