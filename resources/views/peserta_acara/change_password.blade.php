@extends('welcome')
@section('content-title')
    Tukar Password Peserta
@endsection
@section('content')
    <div class="container">
        <div class="card" style="background-image: url({{asset('images/kerja_bg.jpg')}}) ; background-size: cover ;">
            <div class="card-body">
                <form action="{{route('peserta.change_password')}}" class="col-md-6" method="post">
                    {{ csrf_field() }}
                    <hr/>
                    <div class="form-group col-lg-12 {{ $errors->has('nip') ? 'has-error' : '' }}">
                        <label class="block clearfix" >NIP</label>
                        <input type="nip" name='nip' value="{{old('nip')}}" class="form-control form-control-sm" id="nip" placeholder="NIP">
                        <sub><span class="help-block text-danger">{{ $errors->first('nip') }}</span></sub>
                    </div>
                    <div class="form-group col-lg-12 {{ $errors->has('email') ? 'has-error' : '' }}">
                        <label class="block clearfix" >Email</label>
                        <input type="email" name='email' value="{{old('email')}}" class="form-control form-control-sm" id="email" placeholder="Email">
                        <sub><span class="help-block text-danger">{{ $errors->first('email') }}</span></sub>
                    </div>
                    <div class="form-group col-lg-12 {{ $errors->has('password_lama') ? 'has-error' : '' }}">
                        <label class="block clearfix" >PASSOWORD LAMA</label>
                        <input type="password" name='password_lama' value="{{old('password_lama')}}" class="form-control form-control-sm" id="password_lama" placeholder="PASSWORD LAMA">
                        <sub><span class="help-block text-danger">{{ $errors->first('password_lama') }}</span></sub>
                    </div>
                    <div class="form-group col-lg-12 {{ $errors->has('password_baru') ? 'has-error' : '' }}">
                        <label class="block clearfix" >PASSWORD BARU</label>
                        <input type="password" name='password_baru' value="{{old('password_baru')}}" class="form-control form-control-sm" id="password_baru" placeholder="PASSWORD BARU">
                        <sub><span class="help-block text-danger">{{ $errors->first('password_baru') }}</span></sub>
                    </div>
                    <div class="form-group col-lg-12 {{ $errors->has('password_baru_confirmation') ? 'has-error' : '' }}">
                        <label class="block clearfix" >KONFIRMASI PASSWORD</label>
                        <input type="password" name='password_baru_confirmation' value="{{old('password_baru_confirmation')}}" class="form-control form-control-sm" id="password_baru_confirmation" placeholder="KONFIRMASI PASSWORD">
                        <sub><span class="help-block text-danger">{{ $errors->first('password_baru_confirmation') }}</span></sub>
                    </div>
                    <button type="submit" class="btn btn-sm btn-success col-md-12"> TUKAR PASSWORD </button>
                </form>
            </div>
        </div>
    </div>
@endsection