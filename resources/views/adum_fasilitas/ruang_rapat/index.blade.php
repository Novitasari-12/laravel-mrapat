@extends('admin-partials.welcome')
@section('content-title')
    Ruangan
@endsection
@section('content')

    <div class="card">
        <div class="card-header">
            <form action=" {{route('ad_ruangan_rapat.store')}} " method="post">
                {{ csrf_field() }}
                <div class="form-group {{ $errors->has('nama_ruangan') ? 'has-error' : '' }}">
                    <label class="block clearfix" >Nama Ruangan</label>
                    <input type="text" name='nama_ruangan' value="{{old('nama_ruangan')}}" class="form-control form-control-sm" id="nama_ruangan" placeholder="Nama Ruangan">
                    <sub><span class="help-block text-danger">{{ $errors->first('nama_ruangan') }}</span></sub>
                </div>
                <div class="form-group {{ $errors->has('kapasitas_ruangan') ? 'has-error' : '' }}">
                    <label class="block clearfix" >Kapasitas Ruangan</label>
                    <input type="number" name='kapasitas_ruangan' value="{{old('kapasitas_ruangan')}}" class="form-control form-control-sm" id="kapasitas_ruangan" placeholder="Kapasitas Ruangan">
                    <sub><span class="help-block text-danger">{{ $errors->first('kapasitas_ruangan') }}</span></sub>
                </div>
                <span class="input-group-btn">
                    <button class="btn btn-sm btn-default" id="btn_add_bidang" type="submit">
                        <i class="ace-icon fa fa-plus bigger-110"></i>
                        Tambahkan
                    </button>
                </span>
            </form>
        </div>
        <div class="card-body">
            <?php $no=1; ?>
            <table class="table">
                <thead>
                    <tr>
                        <th style="width:1%;">#</th>
                        <th> Ruangan </th>
                        <th> Kapasitas </th>
                        <th>  </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($ruangan as $item)
                        <tr>
                            <td style="widtd:1%;"> {{$no++}} </td>
                            <td> {{$item->nama_ruangan}} </td>
                            <td> {{$item->kapasitas_ruangan}} </td>
                            <td> 
                                <form id='{{$item->id}}' action="{{route('ad_ruangan_rapat.destroy',$item->id)}}" style="display:none;" method="post">
                                {{ csrf_field() }} {{method_field('DELETE')}}
                                </form> 
                                <a href="" class="btn btn-danger btn-sm" onclick="
                                    var cfm = confirm('Yakin Akan Menghapus ?');
                                    if(cfm){
                                    event.preventDefault();
                                    document.getElementById('{{$item->id}}').submit();
                                    }
                                "> <b class="fa fa-times"></b> </a>    
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    
    
@endsection