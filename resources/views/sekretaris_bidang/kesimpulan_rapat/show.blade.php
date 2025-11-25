@extends('admin-partials.welcome')
@section('content-title')
    Kesimpulan Rapat {{ $raker->nama_raker }}
@endsection
@section('content')
    <div class="card">
        <div class="card-header">
            <div class="w-100 d-flex flex-row justify-content-between">
                <a href="{{ route('sb_permohonan_rapat.index') }}" class="btn btn-xs btn-success"> <i class="fa fa-arrow-left"
                        aria-hidden="true"></i> Kembali </a>

                <div class="d-flex flex flex-row">
                    <form id="postkesimpulanrapat" method="POST"
                        action="{{ route('sb_kesimpulan_rapat.publish', [
                            'id_notulen' => $raker->notulenRaker->id,
                        ]) }}">
                        @csrf
                        <button
                            onclick="this.setAttribute('disabled', 'disabled'); document.getElementById('postkesimpulanrapat').submit()"
                            target="_blank" class="btn btn-xs btn-info mr-2"> <b class="fa fa-envelope"></b>
                            Kirim semua peserta rapat
                        </button>
                    </form>

                    <a target="_blank"
                        href=" {{ route('sb_kesimpulan_rapat.show', [
                            'sb_kesimpulan_rapat' => $raker,
                            'print' => true,
                        ]) }} "
                        class="btn btn-xs btn-secondary"> <b class="fa fa-print"></b> </a>
                </div>
            </div>
        </div>
        <div class="card-body">
            <table class="table">
                <tr>
                    <th style="width:10%;"> Nama Rapat </th>
                    <td> {{ $raker->nama_raker }} </td>
                </tr>
                <tr>
                    <th style="width:10%;"> Ruangan Rapat </th>
                    <td> {{ $raker->ruangan->nama_ruangan }} </td>
                </tr>
                <tr>
                    <th style="width:10%;"> Waktu Rapat </th>
                    <td> {{ $raker->tanggal_jam_masuk_raker }} <b>s/d</b>
                        {{ $raker->tanggal_jam_keluar_raker }} </td>
                </tr>
                <tr>
                    <th style="width:10%;"> Kesimpulan Rapat </th>
                    <td> {!! $raker->notulenRaker->hasil_raker !!} </td>
                </tr>
            </table>




        </div>
    </div>
@endsection
