@extends('admin-partials.welcome')
@section('content-title')
    Buat Kesimpulan Rapat {{ $raker->nama_raker }}
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
            <table class="table">
                <tr>
                    <th style="width:20%;"> Nama Rapat </th>
                    <td> {{ $raker->nama_raker }} </td>
                </tr>
                <tr>
                    <th style="width:20%;"> Ruangan Rapat </th>
                    <td> {{ $raker->ruangan->nama_ruangan }} </td>
                </tr>
                <tr>
                    <th style="width:20%;"> Waktu Rapat </th>
                    <td> {{ $raker->tanggal_jam_masuk_raker }} <b>s/d</b>
                        {{ $raker->tanggal_jam_keluar_raker }} </td>
                </tr>
            </table>

            @csrf

            <textarea class="form-control" onkeyup="setText(this)" id="hasil_rapat" name="hasil_rapat" cols="30"
                rows="10">{{ $raker->notulenRaker->hasil_raker }}</textarea>


        </div>
        <div class="card-footer">
            <button url="{{ route('sb_kesimpulan_rapat.update', ['sb_kesimpulan_rapat' => $raker]) }}" id="simpan-hasil"
                class="btn btn-primary">
                <div id="simpan-hasil-spinner" class="spinner-border spinner-border-sm" role="status">
                    <span class="sr-only">Loading...</span>
                </div>
                Simpan
            </button>
        </div>
    </div>
@endsection
@section('script')
    <script>
        var btnSimpanHasil = $('#simpan-hasil')
        var btnSipanHasiLoading = $("#simpan-hasil-spinner")

        btnSipanHasiLoading.hide()

        CKEDITOR.replace('hasil_rapat')

        var editor = CKEDITOR.instances['hasil_rapat'];
        editor.on('key', function(evt) {
            // requestOutNotulenNote();
        });

        function getDataMetting() {
            return CKEDITOR.instances['hasil_rapat'].getData();
        }

        $('#simpan-hasil').click(() => {
            requestOutNotulenNote();
        })

        function requestOutNotulenNote() {
            btnSimpanHasil.prop('disabled', true)
            btnSipanHasiLoading.show()

            fetch(btnSimpanHasil.attr("url"), {
                    method: 'PUT',
                    body: JSON.stringify({
                        hasil_raker: getDataMetting(),
                        _token: $("input[name=_token]").val()
                    }),
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                    }
                })
                .catch(err => {
                    console.log(err)
                })
                .finally(() => {
                    btnSimpanHasil.prop('disabled', false)
                    btnSipanHasiLoading.hide()
                })

            // $.ajax({
            //     url: btnSimpanHasil.attr("url"),
            //     method: 'PUT',
            //     data: {
            //         hasil_raker: getDataMetting()
            //     },
            //     success: result => {
            //         btnSimpanHasil.prop('disabled', false)
            //         btnSipanHasiLoading.hide()
            //     },
            //     error: err => {
            //         console.log(err)
            //         msg = err.responseJSON
            //         btnSimpanHasil.prop('disabled', false)
            //         btnSipanHasiLoading.hide()
            //     }
            // })
        }
    </script>
@endsection
