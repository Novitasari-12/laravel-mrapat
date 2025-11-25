@extends('admin-partials.welcome')
@section('content-title')
    Ruangan
@endsection
@section('content')
    
    <div class="card">
        <div class="card-header">
            <form action=" {{route('ad_fasilitas_rapat.store')}} " method="post">
                {{ csrf_field() }}
                <div class="form-group {{ $errors->has('fasilitas') ? 'has-error' : '' }}">
                    <label class="block clearfix" >Fasiltias Rapat</label>
                    <input type="text" name='fasilitas' value="{{old('fasilitas')}}" class="form-control form-control-sm" id="fasilitas" placeholder="Fasiltias Rapat">
                    <sub><span class="help-block text-danger">{{ $errors->first('fasilitas') }}</span></sub>
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
                        <th> fasiltias </th>
                        <th>  </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($fasilitas as $item)
                        <tr>
                            <td style="widtd:1%;"> {{$no++}} </td>
                            <td> {{$item->fasilitas}} </td>
                            <td> 
                                <form id='{{$item->id}}' action="{{route('ad_fasilitas_rapat.destroy',$item->id)}}" style="display:none;" method="post">
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
    <hr>
    
    
@endsection