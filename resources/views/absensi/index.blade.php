@extends('welcome')
@section('content-title')
    Ambil Absensi Rapat
@endsection
@section('content')
    <div class="container">
        <div class="card" style="background-image: url({{ asset('images/kerja_bg.jpg') }}) ; background-size: cover ;">
            <div class="card-body">
                <div class="row">
                    <form action="{{ route('absensi.ambilAbsensi') }}" enctype="multipart/form-data" class="col-md-6 col-md-4"
                        method="post">
                        {{ csrf_field() }}
                        <hr />
                        <div class="form-group col-lg-12">
                            <label class="block clearfix">ID RAPAT</label>
                            <input type="id_rapat" name='id_rapat' value="{{ old('id_rapat') }}"
                                class="form-control form-control-sm {{ $errors->has('id_rapat') ? 'is-invalid' : '' }}"
                                id="id_rapat" placeholder="ID RAPAT">
                            <sub><span class="help-block text-danger">{{ $errors->first('id_rapat') }}</span></sub>
                        </div>
                        <div class="form-group col-lg-12">
                            <label class="block clearfix">NIP</label>
                            <input type="text" name='nip' value="{{ old('nip') }}"
                                class="form-control form-control-sm {{ $errors->has('id_rapat') ? 'is-invalid' : '' }}"
                                id="nip" placeholder="NIP">
                            <sub><span class="help-block text-danger">{{ $errors->first('nip') }}</span></sub>
                        </div>
                        <div class="form-group col-lg-12">
                            <label class="block clearfix">PASSWORD</label>
                            <input type="password" name='password' value="{{ old('password') }}"
                                class="form-control form-control-sm {{ $errors->has('id_rapat') ? 'is-invalid' : '' }}"
                                id="password" placeholder="PASSWORD">
                            <sub><span class="help-block text-danger">{{ $errors->first('password') }}</span></sub>
                        </div>
                        <div class="form-group col-lg-12">
                            <div class="inputtakephoto" name="upload_foto"
                                valid="{{ $errors->has('upload_foto') ? 'is-invalid' : '' }}"></div>
                            <sub><span class="help-block text-danger">{{ $errors->first('upload_foto') }}</span></sub>
                        </div>

                        <button type="submit" class="btn btn-sm btn-success col-md-12"> ABSEN RAPAT </button>
                    </form>
                    <div class="col-md-4 col-sm-4">
                        @if (session('absensi') != null)
                            @if (session('absensi')->status_absensi)
                                <h1> BPK. {{ session('absensi')->pegawaiPerusahaan->nama_pegawai }} TELAH MENGAMBIL ABSENI
                                </h1>
                                <h3 class="bg-light p-2"> {{ session('absensi')->tanggal_jam_absensi }} </h3>
                                <h3
                                    class="{{ session('absensi')->keterangan_absensi == 'TELAT' ? 'bg-danger' : 'bg-success' }} p-2">
                                    {{ session('absensi')->keterangan_absensi }} </h3>
                            @endif
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script src="{{ mix('js/app.js') }}"></script>
@endsection
