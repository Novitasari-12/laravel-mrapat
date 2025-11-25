@extends('admin-partials.welcome')
@section('content-title')
    Profile
@endsection
@section('content')
<div class="col-md-12">
    <div class="card">
        <div class="card-body">
            <form action=" {{route('sb_change_profile')}} " method="post">
                {{ csrf_field() }}
                <div class="form-group {{ $errors->has('email') ? 'has-error' : '' }}">
                    <label class="block clearfix" >Email</label>
                    <input type="email" name='email' value="{{auth()->user()->email}}" class="form-control form-control-sm" id="email" placeholder="Email">
                    <sub><span class="help-block text-danger">{{ $errors->first('email') }}</span></sub>
                </div>

                <div class="form-group {{ $errors->has('nama_sekretaris') ? 'has-error' : '' }}">
                    <label class="block clearfix" >Nama Sekretaris</label>
                    <input type="text" name='nama_sekretaris' value="{{auth()->user()->sekretarisBidang->nama_sekretaris}}" class="form-control form-control-sm" id="nama_sekretaris" placeholder="Nama Sekretaris">
                    <sub><span class="help-block text-danger">{{ $errors->first('nama_sekretaris') }}</span></sub>
                </div>

                <div class="form-group {{ $errors->has('bidang_sekretaris') ? 'has-error' : '' }}">
                    <label class="block clearfix" >Bidang Sekretaris</label>
                    <input type="text" name='bidang_sekretaris' value="{{auth()->user()->sekretarisBidang->bidang_sekretaris}}" class="form-control form-control-sm" id="bidang_sekretaris" placeholder="Bidang Sekretaris">
                    <sub><span class="help-block text-danger">{{ $errors->first('bidang_sekretaris') }}</span></sub>
                </div>

                <div class="form-group {{ $errors->has('no_telpon_sekretaris') ? 'has-error' : '' }}">
                    <label class="block clearfix" >No Telpon Sekretaris</label>
                    <input type="text" name='no_telpon_sekretaris' value="{{auth()->user()->sekretarisBidang->no_telpon_sekretaris}}" class="form-control form-control-sm" id="no_telpon_sekretaris" placeholder="No Telpon Sekretaris">
                    <sub><span class="help-block text-danger">{{ $errors->first('no_telpon_sekretaris') }}</span></sub>
                </div>

                <p class="text-warning"> Note : Jika ingin mengubah passowrd silahkan isi bagian di bawah ini, tapi jika tidak ingin ubah passwod dan hanya email saja silahkan biarkan bagian password di bawah ini </p>
                <div class="form-group {{ $errors->has('password') ? 'has-error' : '' }}">
                    <label class="block clearfix" >Password</label>
                    <input type="password" name='password' value="{{old('password')}}" class="form-control form-control-sm" id="password" placeholder="Password">
                    <sub><span class="help-block text-danger">{{ $errors->first('password') }}</span></sub>
                </div>
                <div class="form-group {{ $errors->has('cpassword') ? 'has-error' : '' }}">
                    <label class="block clearfix" >Konfirmasi Password</label>
                    <input type="password" name='password_confirmation' value="{{old('password_confirmation')}}" class="form-control form-control-sm" id="password_confirmation" placeholder="Konfirmasi Password">
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
</div>

@endsection