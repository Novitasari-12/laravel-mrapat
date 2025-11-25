@extends('welcome')
@section('title')

@endsection
@section('content-title')
    Login
@endsection
@section('content')
<div class="container">
    <div class="card" style="background-image: url({{asset('images/kerja_bg.jpg')}}) ; background-size: cover ;">
        <div class="card-body">
            <div class="col d-flex justify-content-center">
                <div class="card" style="opacity: 0.9;" >
                    <div class="card-body login-card-body">
                    <p class="login-box-msg">Masuk untuk memulai sesi Anda</p>
                    <form action=" {{route('login')}} " method="POST" id="loginForm">
                        {{ csrf_field() }}
                        <div class="row">
                            <div class="form-group col-lg-12">
                                <label class="block clearfix" >E-Mail</label>
                                <input type="email" name='email' value="{{old('email')}}" class="form-control {{ $errors->has('email') ? 'is-invalid' : '' }} form-control-sm" id="exampleInputEmail1" placeholder="example@mail.com">
                                <sub><span class="help-block text-danger">{{ $errors->first('email') }}</span></sub>
                            </div>
                            <div class="form-group col-lg-12">
                                <label>Password</label>
                                <input type="password" name='password' value="{{old('password')}}" class="form-control {{ $errors->has('password') ? 'is-invalid' : '' }} form-control-sm" id="exampleInputEmail1" placeholder="******">
                                <sub><span class="help-block text-danger">{{ $errors->first('password') }}</span></sub>
                            </div>
                        </div>
                        <button class="btn btn-success btn-sm col-md-12" type="submit">Login</button>
                        {{-- <a href=" {{route('register.index', ['sekretaris_bidang'])}} " class="btn btn-success btn-xs col-md-12" >Register</a> --}}
                        <p class="mb-1">
                            <a href="{{route('reset_password.index')}}">Pulihkan kata sandi</a>
                        </p>
                    </form>

                    <!-- /.social-auth-links -->
                    <hr/>
                    {{-- <a href=" {{asset('android_app/MRAPAT.apk')}} " class="btn btn-xs btn-info col-md-12"> DOWNLOAD APLIKASI ABSENSI DISINI </a> --}}
                    </div>
                    <!-- /.login-card-body -->
                </div>
            </div>
        </div>
    </div>
</div>


@endsection
