@extends('admin-partials.welcome')
@section('content-title')
    Permohonan Rapat
@endsection
@section('content')
    <div class="card">
        <div class="card-header">
            <h5 class="card-title">
                <a href="{{ route('sb_permohonan_rapat.index') }}" class="btn btn-xs btn-success"> <i class="fa fa-arrow-left"
                        aria-hidden="true"></i> Kembali </a>
            </h5>
        </div>
        <div class="card-body">
            <form action="{{ route('sb_permohonan_rapat.store') }}" method="post" style="height:700px;">
                {{ csrf_field() }}

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group {{ $errors->has('nama_rapat') ? 'has-error' : '' }}">
                            <label class="block">Nama Rapat</label>
                            <input type="text" name='nama_rapat' required value="{{ old('nama_rapat') }}"
                                class="form-control form-control-xs" id="nama_rapat" placeholder="Nama Rapat">
                            <sub><span class="help-block text-danger">{{ $errors->first('nama_rapat') }}</span></sub>
                        </div>

                        <div class="form-group {{ $errors->has('tanggal_jam_masuk') ? 'has-error' : '' }}">
                            <label class="block">Waktu Masuk</label>
                            <input type="datetime-local" id="waktu_masuk" required name='tanggal_jam_masuk'
                                value="{{ old('tanggal_jam_masuk') }}" class="form-control form-control-xs"
                                placeholder="Waktu Masuk">
                            <sub><span class="help-block text-danger">{{ $errors->first('tanggal_jam_masuk') }}</span></sub>
                        </div>

                        <div class="form-group {{ $errors->has('tanggal_jam_keluar') ? 'has-error' : '' }}">
                            <label class="block">Waktu Keluar</label>
                            <input type="datetime-local" id="waktu_keluar" required name='tanggal_jam_keluar'
                                value="{{ old('tanggal_jam_keluar') }}" class="form-control form-control-xs"
                                placeholder="Waktu Keluar">
                            <sub><span
                                    class="help-block text-danger">{{ $errors->first('tanggal_jam_keluar') }}</span></sub>
                        </div>

                        <div class="form-group{{ $errors->has('deskripsi') ? 'has-error' : '' }}">
                            <label class="block">Deskripsi Rapat</label>
                            <textarea name="deskripsi" id="deskripsi" required class="form-control form-control-sm" placeholder="Deskripsi Rapat">{{ old('deskripsi') }}</textarea>
                            <sub><span class="help-block text-danger">{{ $errors->first('deskripsi') }}</span></sub>
                        </div>

                    </div>
                    <div class="col-md-6">

                        <div class="form-group{{ $errors->has('ruangan') ? 'has-error' : '' }}">
                            <label class="block">Ruangan Rapat</label>
                            <select required data-placeholder="Pilih Ruangan Rapat" name='ruangan'
                                class="form-control form-control-sm select" id="ruangan">
                                <option value=""> Ruangan Rapat </option>
                                @foreach ($ruangan as $item)
                                    <option data-kapasitas="{{ $item->kapasitas_ruangan }}"
                                        {{ old('ruangan') == $item->id ? 'selected' : '' }} value="{{ $item->id }}">
                                        {{ $item->nama_ruangan }} - Maks. {{ $item->kapasitas_ruangan }} Orang </option>
                                @endforeach
                            </select>
                            <sub><span class="help-block text-danger">{{ $errors->first('ruangan') }}</span></sub>
                        </div>

                        <div id="group-jumlah" style="width:30%;"
                            class="form-group {{ $errors->has('jumlah_peserta') ? 'has-error' : '' }}">
                            <label class="block">Jumlah Peserta</label>
                            <input required type="number" name='jumlah_peserta' value="{{ old('jumlah_peserta') }}"
                                class="form-control form-control-xs" id="jumlah_peserta" placeholder="Jumlah Peserta">
                            <sub><span class="help-block text-danger">{{ $errors->first('jumlah_peserta') }}</span></sub>
                        </div>

                        <div id="group-peserta" class="form-group{{ $errors->has('peserta') ? 'has-error' : '' }}">
                            <label class="block" id="label-peserta">Peserta Rapat</label>
                            <select required data-placeholder="Pilih Peserta Rapat" multiple name='peserta[]'
                                class="form-control form-control-sm select" id="peserta">
                                @foreach ($pegawai as $item)
                                    <option
                                        {{ in_array($item->id, is_array(old('peserta')) ? old('peserta') : []) ? 'selected' : '' }}
                                        value="{{ $item->id }}"> {{ $item->bidang_pegawai }} -
                                        {{ $item->nama_pegawai }} </option>
                                @endforeach
                            </select>
                            <sub><span class="help-block text-danger">{{ $errors->first('peserta') }}</span></sub>
                        </div>

                        <div id="group-fasilitas">
                            <label id="label-fasilitas" class="block">Fasilitas</label>
                            <select data-placeholder="Pilih Rapat" multiple name='fasilitas[]'
                                class="form-control form-control-sm select" id="fasilitas">
                                @foreach ($fasilitas as $item)
                                    <option
                                        {{ in_array($item->fasilitas, is_array(old('fasilitas')) ? old('fasilitas') : []) ? 'selected' : '' }}
                                        value="{{ $item->fasilitas }}"> {{ $item->fasilitas }} </option>
                                @endforeach
                            </select>
                            <div class="form-group{{ $errors->has('inpt_fasilitas') ? 'has-error' : '' }}">
                                <input type="text" name='inpt_fasilitas' value="{{ old('inpt_fasilitas') }}"
                                    class="form-control form-control-sm tags" id="inpt_fasilitas" placeholder="Fasilitas">
                                <sub><span
                                        class="help-block text-danger">{{ $errors->first('inpt_fasilitas') }}</span></sub>
                            </div>
                        </div>

                        <div id="group-notulen" class="form-group{{ $errors->has('notulen') ? 'has-error' : '' }}">
                            <label class="block">Notulen Rapat</label>
                            <select data-placeholder="Pilih Notulen Rapat" name='notulen'
                                class="form-control form-control-sm select" id="notulen">
                                <option value=""> Notulen Rapat </option>
                                @foreach ($pegawai as $item)
                                    <option {{ old('notulen') == $item->id ? 'selected' : '' }}
                                        value="{{ $item->id }}"> {{ $item->bidang_pegawai }} -
                                        {{ $item->nama_pegawai }} </option>
                                @endforeach
                            </select>
                            <sub><span class="help-block text-danger">{{ $errors->first('notulen') }}</span></sub>
                        </div>


                    </div>
                </div>


                <button type="submit" id="btn-simpan" class="btn btn-sm btn-primary"> Simpan </button>

            </form>

            <div class="test">

            </div>
        </div>
    </div>
@endsection
