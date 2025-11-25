@extends('admin-partials.welcome')
@section('content-title')
    Edit Akun Sekretaris Bidang
@endsection
@section('content')
<div class="card">
    <div class="card-header">
        <h5 class="card-title">
            <a href="{{route('ad_sekretaris_bidang.index')}}" class="btn btn-xs btn-success"> <i class="fa fa-arrow-left" aria-hidden="true"></i> Kembali </a>
        </h5>
    </div>
    <div class="card-body">
        <form action="{{route('ad_sekretaris_bidang.update', $sekretaris->id)}}" method="post">
            {{ csrf_field() }}
            {{method_field('PUT')}}
            <div class="form-group col-lg-12 {{ $errors->has('bidang') ? 'has-error' : '' }}">
                <label class="block clearfix" >Bidang Sekretaris</label>
                <input type="text" name='bidang' value="{{$sekretaris->bidang_sekretaris}}" class="form-control form-control-sm" id="bidang" placeholder="Bidang Sekretaris">
                <sub><span class="help-block text-danger">{{ $errors->first('bidang') }}</span></sub>
            </div>
            <div class="form-group col-lg-12 {{ $errors->has('nama') ? 'has-error' : '' }}">
                <label class="block clearfix" >Nama Sekretaris Bidang</label>
                <input type="text" name='nama' value="{{$sekretaris->nama_sekretaris}}" class="form-control form-control-sm" id="nama" placeholder="Nama Sekretaris Bidang">
                <sub><span class="help-block text-danger">{{ $errors->first('nama') }}</span></sub>
            </div>
            <div class="form-group col-lg-12 {{ $errors->has('email') ? 'has-error' : '' }}">
                <label class="block clearfix" >Email</label>
                <input type="text" name='email' value="{{$sekretaris->user->email}}" class="form-control form-control-sm" id="email" placeholder="Email">
                <sub><span class="help-block text-danger">{{ $errors->first('email') }}</span></sub>
            </div>
            <div class="form-group col-lg-12 {{ $errors->has('password') ? 'has-error' : '' }}">
                <label class="block clearfix" > Password </label>
                <input type="password" name='password' value="{{old('password')}}" class="form-control form-control-sm" id="password" placeholder="*****">
                <sub><span class="help-block text-danger">{{ $errors->first('password') }}</span></sub>
            </div>
            <div class="form-group col-lg-12 {{ $errors->has('password_confirmation') ? 'has-error' : '' }}">
                <label class="block clearfix" > Password Confirmation </label>
                <input type="password" name='password_confirmation' value="{{old('password_confirmation')}}" class="form-control form-control-sm" id="password_confirmation" placeholder="*****">
                <sub><span class="help-block text-danger">{{ $errors->first('password_confirmation') }}</span></sub>
            </div>
            <button type="submit" class="btn btn-xs btn-primary col-md-12"> Simpan </button>
        </form>
    </div>
</div>
    
@endsection