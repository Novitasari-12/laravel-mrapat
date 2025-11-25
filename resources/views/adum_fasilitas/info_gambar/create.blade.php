@extends('admin-partials.welcome')
@section('content-title')
    Informasi Gambar 
@endsection
@section('content')
    <div class="card">
        <div class="card-header">
            <a href=" {{route('informasi_gambar.index')}} " class="btn btn-xs btn-success"> <i class="fa fa fa-arrow-left"></i> Kembali </a>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-5">
                    <form action="{{route('informasi_gambar.store')}}" enctype="multipart/form-data" method="post">
                        {{ csrf_field() }}
                        <div class="form-group">
                            <label class="block clearfix" >Nama Gambar</label>
                            <input type="text" name='nama' value="{{old('nama')}}" class="form-control form-control-sm  {{ $errors->has('nama') ? 'is-invalid' : '' }}" id="nama" placeholder="Nama Gambar">
                            <sub><span class="help-block text-danger">{{ $errors->first('nama') }}</span></sub>
                        </div>
                        <div class="form-group">
                            <label class="block clearfix" >Gambar</label>
                            <input type="file" accept="image/*" name='gambar' onchange="openFile(this)" value="{{old('gambar')}}" class="form-control form-control-sm  {{ $errors->has('gambar') ? 'is-invalid' : '' }}" name="gambar" placeholder="Gambar">
                            <sub><span class="help-block text-danger">{{ $errors->first('gambar') }}</span></sub>
                        </div>
                        <div class="form-group">
                            <label class="block clearfix" >Informasi Gambar</label>
                            <textarea class="form-control form-control-sm  {{ $errors->has('informasi_gambar') ? 'is-invalid' : '' }}" name="informasi_gambar" placeholder="Gambar">{{old('informasi_gambar')}}</textarea>
                            <sub><span class="help-block text-danger">{{ $errors->first('informasi_gambar') }}</span></sub>
                        </div>
                        <div class="form-group">
                            <label class="block clearfix" >Waktu Mulai Ditampilkan</label>
                            <input type="datetime-local"  value="{{old('waktu_mulai_ditampilkan')}}" class="form-control form-control-sm  {{ $errors->has('waktu_mulai_ditampilkan') ? 'is-invalid' : '' }}" name="waktu_mulai_ditampilkan" placeholder="Waktu Mulai Ditampilkan">
                            <sub><span class="help-block text-danger">{{ $errors->first('waktu_mulai_ditampilkan') }}</span></sub>
                        </div>
                        <div class="form-group">
                            <label class="block clearfix" >Waktu Selesai Ditampilkan</label>
                            <input type="datetime-local" value="{{old('waktu_selesai_ditampilkan')}}" class="form-control form-control-sm  {{ $errors->has('waktu_selesai_ditampilkan') ? 'is-invalid' : '' }}" name="waktu_selesai_ditampilkan" placeholder="Waktu Selesai Ditampilkan">
                            <sub><span class="help-block text-danger">{{ $errors->first('waktu_selesai_ditampilkan') }}</span></sub>
                        </div>
                        <button class="btn btn-sm btn-primary col-md-12"> Simpan </button>
                    </form>
                </div>
                <div class="col-md-4">
                    <img src="" class="col-md-12" id="out-image" />
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script>
        function openFile(e){
            var input = e;
            var reader = new FileReader();
            reader.onload = function(){
                var dataURL = reader.result;
                var output = document.getElementById('out-image');
                output.src = dataURL;
            };
            reader.readAsDataURL(input.files[0]);
        }
    </script>
@endsection