@extends('admin-partials.welcome')
@section('content-title')
    Profile
@endsection
@section('content')
<div class="card">
    <div class="card-body">
        <form action=" {{route('ad_change_profile')}} " method="post">
            {{ csrf_field() }}
            <div class="form-group {{ $errors->has('email') ? 'has-error' : '' }}">
                <label class="block clearfix" >Email</label>
                <input type="email" name='email' value="{{auth()->user()->email}}" class="form-control form-control-xs" id="email" placeholder="Email">
                <sub><span class="help-block text-danger">{{ $errors->first('email') }}</span></sub>
            </div>

            <p class="text-info"> Note : Jika ingin mengubah passowrd silahkan isi bagian di bawah ini, tapi jika tidak ingin ubah passwod dan hanya email saja silahkan biarkan bagian password di bawah ini </p>
            <div class="form-group {{ $errors->has('password') ? 'has-error' : '' }}">
                <label class="block clearfix" >Password</label>
                <input type="password" name='password' value="{{old('password')}}" class="form-control form-control-xs" id="password" placeholder="Password">
                <sub><span class="help-block text-danger">{{ $errors->first('password') }}</span></sub>
            </div>
            <div class="form-group {{ $errors->has('cpassword') ? 'has-error' : '' }}">
                <label class="block clearfix" >Konfirmasi Password</label>
                <input type="password" name='password_confirmation' value="{{old('password_confirmation')}}" class="form-control form-control-xs" id="password_confirmation" placeholder="Konfirmasi Password">
                <sub><span class="help-block text-danger">{{ $errors->first('cpassword') }}</span></sub>
            </div>
            <span class="input-group-btn">
                <button class="btn btn-sm btn-info" id="btn_add_bidang" type="submit">
                    Simpan
                </button>
            </span>
        </form>
    </div>
</div>
    
@endsection