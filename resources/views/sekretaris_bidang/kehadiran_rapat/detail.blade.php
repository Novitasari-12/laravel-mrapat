@extends('admin-partials.welcome')
@section('content-title')
    Kehadiran {{ $rapat->nama_raker }}
@endsection
@section('content')
    <div class="card">
        <div class="card-header">
            <div class="w-100 d-flex flex-row justify-content-between">
                <a href="{{ route('sb_permohonan_rapat.index') }}" class="btn btn-xs btn-success"> <i class="fa fa-arrow-left"
                        aria-hidden="true"></i> Kembali </a>

                <a target="_blank"
                    href=" {{ route('sb_kehadiran_rapat.show', [
                        'sb_kehadiran_rapat' => $rapat,
                    ]) }} "
                    class="btn btn-xs btn-secondary"> <b class="fa fa-print"></b> </a>
            </div>
        </div>
        <div class="card-body table-responsive">
            <table class="table">
                <tr>
                    <th> Id Rapat </th>
                    <td> {{ $rapat->id }} </td>
                </tr>
                <tr>
                    <th> Nama Rapat </th>
                    <td> {{ $rapat->nama_raker }} </td>
                </tr>
                <tr>
                    <th> Ruangan</th>
                    <td> {{ $rapat->ruangan->nama_ruangan }} </td>
                </tr>
                <tr>
                    <th> Waktu Rapat</th>
                    <td> {{ $rapat->tanggal_jam_masuk_raker }} - {{ $rapat->tanggal_jam_keluar_raker }} </td>
                </tr>
                <tr>
                    <th> Jumlah Peserta</th>
                    <td> {{ $rapat->jumlah_peserta_raker }} </td>
                </tr>
                <tr>
                    <th> Hasil Rapat </th>
                    <td> {!! $rapat->notulenRaker->hasil_raker !!} </td>
                </tr>
            </table>

            <h2>PESERTA RAPAT</h2>
            <hr />

            <table class="table">
                <?php $no = 1; ?>
                <thead>
                    <tr>
                        <th>#</th>
                        <th>NIP</th>
                        <th>NAMA</th>
                        <th>EMAIL</th>
                        <th>WAKTU ABSEN</th>
                        <th>KETERANGAN ABSEN</th>
                        <th>FOTO</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($peserta_rapat as $item)
                        <tr class="text-{{ $item->status_absensi ? 'success' : 'danger' }} ">
                            <th> {{ $no++ }} </th>
                            <th> {{ $item->pegawaiPerusahaan->nip_pegawai }} </th>
                            <th> {{ $item->pegawaiPerusahaan->nama_pegawai }} </th>
                            <th> {{ $item->pegawaiPerusahaan->email_pegawai }} </th>
                            <th> {{ $item->tanggal_jam_absensi }}</th>
                            <th> {{ $item->keterangan_absensi }} </th>
                            <th>
                                @if ($item->status_absensi)
                                    <!-- Button trigger modal -->
                                    <a data-toggle="modal" data-target="#modal-{{ $item->id }}-">
                                        <img alt="{{ $item->getUploadFoto()->originalName }}"
                                            src="{{ $item->getUploadFoto()->path }}" style="width: 50px"
                                            class="img-thumbnail">
                                    </a>

                                    <!-- Modal -->
                                    <div class="modal fade" id="modal-{{ $item->id }}-" tabindex="-1" role="dialog"
                                        aria-labelledby="modal-{{ $item->id }}-Label" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="modal-{{ $item->id }}-Label">
                                                        {{ $item->getUploadFoto()->originalName }}</h5>
                                                    <button type="button" class="close" data-dismiss="modal"
                                                        aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <img alt="{{ $item->getUploadFoto()->originalName }}"
                                                        src="{{ $item->getUploadFoto()->path }}" class="w-100">
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary"
                                                        data-dismiss="modal">Close</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            </th>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
