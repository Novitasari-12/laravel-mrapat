@extends('admin-partials.welcome')
@section('content-title')
    Pegawai Perusahaan
@endsection
@section('content')
    <div class="card">
        <div class="card-header">
            <strong>
                Tambah Data Pegawai
            </strong>
        </div>
        <div class="card-body">
            <form action=" {{ route('ad_pegawai_perusahaan.store', [
                'with' => 'form',
            ]) }} "
                method="post">
                {{ csrf_field() }}
                <div class="form-group {{ $errors->has('nip_pegawai') ? 'has-error' : '' }}">
                    <label class="block clearfix">Nip Pegawai</label>
                    <input type="text" name='nip_pegawai' value="{{ old('nip_pegawai') }}"
                        class="form-control form-control-sm" id="nip_pegawai" placeholder="Nip Pegawai">
                    <sub><span class="help-block text-danger">{{ $errors->first('nip_pegawai') }}</span></sub>
                </div>

                <div class="form-group {{ $errors->has('nama_pegawai') ? 'has-error' : '' }}">
                    <label class="block clearfix">Nama Pegawai</label>
                    <input type="text" name='nama_pegawai' value="{{ old('nama_pegawai') }}"
                        class="form-control form-control-sm" id="nama_pegawai" placeholder="Nama Pegawai">
                    <sub><span class="help-block text-danger">{{ $errors->first('nama_pegawai') }}</span></sub>
                </div>

                <div class="form-group {{ $errors->has('bidang_pegawai') ? 'has-error' : '' }}">
                    <label class="block clearfix">Bidang Pegawai</label>
                    <input type="text" name='bidang_pegawai' value="{{ old('bidang_pegawai') }}"
                        class="form-control form-control-sm" id="bidang_pegawai" placeholder="Bidang Pegawai">
                    <sub><span class="help-block text-danger">{{ $errors->first('bidang_pegawai') }}</span></sub>
                </div>

                <div class="form-group {{ $errors->has('unit_pegawai') ? 'has-error' : '' }}">
                    <label class="block clearfix">Unit Pegawai</label>
                    <input type="text" name='unit_pegawai' value="{{ old('unit_pegawai') }}"
                        class="form-control form-control-sm" id="unit_pegawai" placeholder="Unit Pegawai">
                    <sub><span class="help-block text-danger">{{ $errors->first('unit_pegawai') }}</span></sub>
                </div>

                <div class="form-group {{ $errors->has('email_pegawai') ? 'has-error' : '' }}">
                    <label class="block clearfix">Email Pegawai</label>
                    <input type="text" name='email_pegawai' value="{{ old('email_pegawai') }}"
                        class="form-control form-control-sm" id="email_pegawai" placeholder="Email Pegawai">
                    <sub><span class="help-block text-danger">{{ $errors->first('email_pegawai') }}</span></sub>
                </div>

                <div class="form-group {{ $errors->has('no_telpon') ? 'has-error' : '' }}">
                    <label class="block clearfix">Nomor Telpon</label>
                    <input type="text" name='no_telpon' value="{{ old('no_telpon') }}"
                        class="form-control form-control-sm" id="no_telpon" placeholder="Nomor Telpon">
                    <sub><span class="help-block text-danger">{{ $errors->first('no_telpon') }}</span></sub>
                </div>

                <div class="form-group {{ $errors->has('password') ? 'has-error' : '' }}">
                    <label class="block clearfix">Password</label>
                    <input type="password" name='password' value="{{ old('password') }}"
                        class="form-control form-control-sm" id="password" placeholder="Password">
                    <sub><span class="help-block text-danger">{{ $errors->first('password') }}</span></sub>
                </div>

                <div class="form-group {{ $errors->has('password_confirmation') ? 'has-error' : '' }}">
                    <label class="block clearfix">Confirmasi Password</label>
                    <input type="password" name='password_confirmation' value="{{ old('password_confirmation') }}"
                        class="form-control form-control-sm" id="password_confirmation" placeholder="Confirmasi Password">
                    <sub><span class="help-block text-danger">{{ $errors->first('password_confirmation') }}</span></sub>
                </div>

                <span class="input-group-btn">
                    <button class="btn btn-sm btn-default" id="btn_add_bidang" type="submit">
                        <i class="ace-icon fa fa-plus bigger-110"></i>
                        Tambahkan
                    </button>
                </span>
            </form>
        </div>
    </div>
@endsection
@section('script')
@endsection
