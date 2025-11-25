@extends('welcome')
@section('content-title')
    Reset Password
@endsection
@section('content')
<div class="container">
    <div class="card" style="background-image: url({{asset('images/kerja_bg.jpg')}}) ; background-size: cover ;">
        <div class="card-body">
            <div class="col d-flex justify-content-center">
                <div class="card" style="opacity: 0.9;" >
                    <div class="card-body">
                        <form action=" {{route('reset_password')}} " method="POST" id="loginForm">
                            {{ csrf_field() }}
                            <div class="row">
                                <div class="form-group col-lg-12 ">
                                    <label>E-Mail</label>
                                    <input type="email" name='email' value="{{old('email')}}" class="form-control form-control-sm {{ $errors->has('email') ? 'is-invalid' : '' }}" id="exampleInputEmail1" placeholder="example@mail.com">
                                    <sub><span class="help-block text-danger">{{ $errors->first('email') }}</span></sub>
                                </div>
                            </div>
                            <div class="btn-group text-left col-md-12">
                                <button class="btn btn-xs btn-success loginbtn">Reset password</button>
                                <button class="btn btn-xs btn-danger" type="reset" >Reset</button>
                            </div>
                            <p class="mb-1">
                                <a href="{{route('login.index')}}">Masukan Akun</a>
                            </p>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection