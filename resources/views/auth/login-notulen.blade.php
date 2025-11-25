@extends('welcome')
@section('content-title')
    Notulen Login
@endsection
@section('content')
<div class="container">
    <div class="card" style="background-image: url({{asset('images/kerja_bg.jpg')}}) ; background-size: cover ;">
        <div class="card-body">
            <div class="col d-flex justify-content-center">
                <div class="card" style="opacity: 0.9;" >
                    <div class="card-body">
                        <form action="  " method="POST" id="loginForm">
                            {{ csrf_field() }}
                            <div class="row">
                                <div class="form-group col-lg-12 {{ $errors->has('username') ? 'has-error' : '' }}">
                                    <label class="block clearfix" >Username</label>
                                    <input type="username" name='username' value="{{old('username')}}" class="form-control form-control-sm" id="username" placeholder="Username">
                                    <sub><span class="help-block text-danger">{{ $errors->first('username') }}</span></sub>
                                </div>
                                <div class="form-group col-lg-12 {{ $errors->has('password') ? 'has-error' : '' }}">
                                    <label>Password</label>
                                    <input type="password" name='password' value="{{old('password')}}" class="form-control form-control-sm" id="exampleInputEmail1" placeholder="******">
                                    <sub><span class="help-block text-danger">{{ $errors->first('password') }}</span></sub>
                                </div>
                            </div>
                            <a href=" {{route('reset_password.index')}} " class="btn btn-link active" style="color : lightblue ;" >  Reset Password  </a>
                            <button class="btn btn-success btn-sm col-md-12" type="submit">Login</button>
                            {{-- <a href=" {{route('register.index', ['sekretaris_bidang'])}} " class="btn btn-success btn-xs col-md-12" >Register</a> --}}
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection