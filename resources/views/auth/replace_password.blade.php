@extends('welcome')
@section('content-title')
    Perbaiki Password
@endsection
@section('content')
<div class="container">
    <div class="card" style="background-image: url({{asset('images/kerja_bg.jpg')}}) ; background-size: cover ;">
        <div class="card-body">
            <div class="col d-flex justify-content-center">
                <div class="card" style="opacity: 0.9;" >
                    <div class="card-body login-card-body">
                        <form action=" {{route('replace_password', [$user->remember_token, $user->email])}} " method="POST" id="loginForm">
                            {{ csrf_field() }}
                            <div class="form-group col-lg-12">
                                <label>Password</label>
                                <input type="password" name='password' value="{{old('password')}}" class="form-control form-control-sm {{ $errors->has('password') ? 'is-invalid' : '' }}" id="exampleInputEmail1" placeholder="******">
                                <sub><span class="help-block text-danger">{{ $errors->first('password') }}</span></sub>
                            </div>
                            <div class="form-group col-lg-12">
                                <label>Repeat Password</label>
                                <input type='password' name='password_confirmation' placeholder="******" class="form-control">
                            </div>
                            <button class="btn btn-success btn-block">Save password</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


@endsection