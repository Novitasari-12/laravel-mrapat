@extends('admin-partials.welcome')
@section('content-title')
    Sekretaris Bidang
@endsection
@section('content')


<div class="card">
    <div class="card-header">
        <a href="{{route('ad_sekretaris_bidang.create')}}" class="btn btn-xs btn-success"> <b class="fa fa-plus"></b> Buat Akun Sekretaris Bidang </a>
    </div>
    <div class="card-body">
        <table class="table">
        <thead>
            <tr>
                <th>#</th>
                <th>Nama </th>
                <th>Email </th>
                <th>Bidang</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            <?php $no=1; ?> 
            @foreach ($sekretaris as $item)
                <tr>
                    <th> {{$no++}} </th>
                    <th> {{$item->nama_sekretaris}} </th>
                    <th> {{$item->user->email}} </th>
                    <th> {{$item->bidang_sekretaris}} </th>
                    <th>
                        <a href="{{route('ad_sekretaris_bidang.edit',$item->id)}}" class="btn btn-info btn-sm"> Show / Edit </a>
                        <form id='{{$item->id}}' action="{{route('ad_sekretaris_bidang.destroy',$item->id)}}" style="display:none;" method="post">
                        {{ csrf_field() }} {{method_field('DELETE')}}
                        </form> 
                        <a href="" class="btn btn-danger btn-sm" onclick="
                            var cfm = confirm('Yakin Akan Menghapus ?');
                            if(cfm){
                                event.preventDefault();
                                document.getElementById('{{$item->id}}').submit();
                            }
                        "> <i class="fa fa-times"></i> Delete</a>
                        </div>
                    </th>
                </tr>
            @endforeach
        </tbody>
    </table>
    </div>
</div>


@endsection