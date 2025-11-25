@extends('admin-partials.welcome')
@section('content-title')
    Persetujuan Raker
@endsection
@section('content')
    <div class="card">
        <div class="card-header">
            <h5 class="card-title text-primary">
                Menunggu Persetujuan
            </h5>
        </div>
        <div class="card-body">
            <?php $no = 1; ?>
            <table class="table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Nama Rapat</th>
                        <th>Nama Sekretaris</th>
                        <th style="width:20%;">Tempat (Aksi)</th>
                        <th style="width:20%;">Waktu Mulai - Keluar</th>
                        <th>Fasilitas</th>
                        <th>Persetujuan (Aksi)</th>
                        <th>Peserta</th>
                        <th>Tambahkan Keteangan</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($noPersetujuan as $item)
                        <tr>
                            <td> {{ $no++ }} </td>
                            <td> {{ $item->raker->nama_raker }} </td>
                            <td> {{ $item->sekretarisBidang->nama_sekretaris }} </td>
                            <td>
                                <form id="ruangan-{{ $item->id }}"
                                    action="{{ route('ad_persetujuan_rapat.update', [$item->id]) }}" method="post">
                                    {{ csrf_field() }}
                                    {{ method_field('PUT') }}
                                    <select name='ruangan'
                                        onchange="
                                        var cfm = confirm('Yakin mengubah ruangan rapat ?');
                                        if(cfm){
                                            event.preventDefault();
                                            document.getElementById('ruangan-{{ $item->id }}').submit();
                                        }
                                    "
                                        class="select form-control form-control-sm">
                                        @foreach ($ruangan as $vRuangan)
                                            <option {{ $item->raker->id_ruangan == $vRuangan->id ? 'selected' : '' }}
                                                value="{{ $vRuangan->id }}"> {{ $vRuangan->nama_ruangan }} - KAPASITAS
                                                {{ $vRuangan->kapasitas_ruangan }} </option>
                                        @endforeach
                                    </select>
                                </form>
                            </td>
                            <td>
                                Mulai <b>{{ $item->raker->tanggal_jam_masuk_raker }}</b>
                                Keluar <b> {{ $item->raker->tanggal_jam_keluar_raker }} </b>
                            </td>
                            <td>
                                <select onchange="setRuangan(this)" onload="setRuangan(this)"
                                    class="form-control form-control-sm">
                                    <option value=""> {{ $item->raker->fasilitasPendukungRaker->count() }}
                                        Fasilitas
                                    </option>
                                    @foreach ($item->raker->fasilitasPendukungRaker as $fasilitas)
                                        <option value=""> {{ $fasilitas->fasilitas_pendukung }} </option>
                                    @endforeach
                                </select>
                            </td>
                            <td>

                                <div class="row align-items-center">
                                    <form class="col-md-10" id="persetujuan-{{ $item->id }}"
                                        action="{{ route('ad_persetujuan_rapat.update', [$item->id]) }}" method="post">
                                        {{ csrf_field() }}
                                        {{ method_field('PATCH') }}

                                        <select name='status_persetujuan'
                                            onchange="
                                        var cfm = confirm('Yakin mengubah persetujuan rapat ?');
                                        if(cfm){
                                            event.preventDefault();
                                            addLoadingPage({{ $item->id }});
                                            document.getElementById('persetujuan-{{ $item->id }}').submit();
                                        }
                                    "
                                            class="form-control form-control-sm">
                                            <?php
                                            $status_persetujuan = [['name' => 'BELUM DISETUJUI', 'val' => 0], ['name' => 'DISETUJUI', 'val' => 1]];
                                            ?>
                                            @foreach ($status_persetujuan as $vItem)
                                                <option
                                                    {{ $item->status_persetujuan_raker == $vItem['val'] ? 'selected' : '' }}
                                                    value="{{ $vItem['val'] }}"> {{ $vItem['name'] }} </option>
                                            @endforeach
                                        </select>

                                        <sub id="has-email-sending-{{ $item->id }}" class="display-none">Pengriman
                                            Email...</sub>
                                    </form>
                                    <div class="col-md-2">
                                        <div class="loader display-none" id="loader-{{ $item->id }}"></div>
                                    </div>
                                </div>



                            </td>
                            <td>
                                <select class="form-control form-control-sm">
                                    <option> {{ $item->raker->pesertaRaker->count() }} ORANG </option>
                                    @foreach ($item->raker->pesertaRaker as $vPeserta)
                                        <option> {{ $vPeserta->pegawaiPerusahaan->nama_pegawai }} </option>
                                    @endforeach
                                </select>
                            </td>
                            <td>

                                <button type="button" class="btn btn-primary btn-xs" data-toggle="modal"
                                    data-target="#no-persetujuan-{{ $item->id }}">
                                    + Tambahkan
                                </button>

                            </td>

                            <!-- The Modal -->
                            <div class="modal fade" id="no-persetujuan-{{ $item->id }}">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <form action=" {{ route('ad_persetujuan_rapat.update', [$item->id]) }} "
                                            method="post">
                                            {{ csrf_field() }}
                                            {{ method_field('PUT') }}
                                            <!-- Modal Header -->
                                            <div class="modal-header">
                                                <h4 class="modal-title"> {{ ucwords($item->raker->nama_raker) }} </h4>
                                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                            </div>

                                            <!-- Modal body -->
                                            <div class="modal-body" style="padding-bottom:5%;">

                                                <textarea onkeyup="setDeskripsi(this)" onload="setDeskripsi(this)" cols="30" rows="10"
                                                    name='deskripsi_persetujuan_raker' class="form-control form-control-sm"
                                                    placeholder="Alasan persetujuan atau penolakan [optional] jadikan ini sebagai pesan yang akan di berikan kepada si pemohon rapat ">{{ $item->deskripsi_persetujuan_raker }}</textarea>

                                            </div>

                                            <!-- Modal footer -->
                                            <div class="modal-footer">
                                                <button data-idRaker='{{ $item->id_raker }}'
                                                    data-idSekretarisBidang='{{ $item->id_sekretaris_bidang }}'
                                                    onclick="setBtnSimpan(this)" onload="setBtnSimpan(this)"
                                                    data-link="{{ route('ad_persetujuan_rapat.update', $item->id) }}"
                                                    class="btn btn-sm btn-primary"> SIMPAN </button>
                                                <button type="button" class="btn btn-secondary btn-sm"
                                                    data-dismiss="modal">Close</button>
                                            </div>

                                        </form>
                                    </div>
                                </div>
                            </div>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>


    <hr />

    <div class="card">
        <div class="card-header">
            <h5 class="card-title text-success">
                Telah Disetujui
            </h5>
        </div>
        <div class="card-body">
            <?php $no = 1; ?>
            <table class="table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Nama Rapat</th>
                        <th>Nama Sekretaris</th>
                        <th style="width:20%;">Tempat (Aksi)</th>
                        <th style="width:20%;">Waktu Mulai - Keluar</th>
                        <th>Fasilitas</th>
                        <th>Persetujuan (Aksi)</th>
                        <th>Peserta</th>
                        <th>Tambahkan Keteangan</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($yesPersetujuan as $item)
                        <tr>
                            <td> {{ $no++ }} </td>
                            <td> {{ $item->raker->nama_raker }} </td>
                            <td> {{ $item->sekretarisBidang->nama_sekretaris }} </td>
                            <td>
                                <form id="ruangan-{{ $item->id }}"
                                    action="{{ route('ad_persetujuan_rapat.update', [$item->id]) }}" method="post">
                                    {{ csrf_field() }}
                                    {{ method_field('PUT') }}
                                    <select name='ruangan'
                                        onchange="
                                        var cfm = confirm('Yakin mengubah ruangan rapat ?');
                                        if(cfm){
                                            event.preventDefault();
                                            document.getElementById('ruangan-{{ $item->id }}').submit();
                                        }
                                    "
                                        class="select form-control">
                                        @foreach ($ruangan as $vRuangan)
                                            <option {{ $item->raker->id_ruangan == $vRuangan->id ? 'selected' : '' }}
                                                value="{{ $vRuangan->id }}"> {{ $vRuangan->nama_ruangan }} - KAPASITAS
                                                {{ $vRuangan->kapasitas_ruangan }} </option>
                                        @endforeach
                                    </select>
                                </form>
                            </td>
                            <td>
                                Mulai <b>{{ $item->raker->tanggal_jam_masuk_raker }}</b>
                                Keluar <b> {{ $item->raker->tanggal_jam_keluar_raker }} </b>
                            </td>
                            <td>
                                <select onchange="setRuangan(this)" onload="setRuangan(this)"
                                    class="form-control form-control-sm">
                                    <option value=""> {{ $item->raker->fasilitasPendukungRaker->count() }}
                                        Fasilitas
                                    </option>
                                    @foreach ($item->raker->fasilitasPendukungRaker as $fasilitas)
                                        <option value=""> {{ $fasilitas->fasilitas_pendukung }} </option>
                                    @endforeach
                                </select>
                            </td>
                            <td>

                                <div class="row align-items-center">
                                    <form class="col-md-10" id="persetujuan-{{ $item->id }}"
                                        action="{{ route('ad_persetujuan_rapat.update', [$item->id]) }}" method="post">
                                        {{ csrf_field() }}
                                        {{ method_field('PUT') }}

                                        <select name='status_persetujuan'
                                            onchange="
                                        var cfm = confirm('Yakin mengubah persetujuan rapat ?');
                                        if(cfm){
                                            event.preventDefault();
                                            addLoadingPage({{ $item->id }});
                                            document.getElementById('persetujuan-{{ $item->id }}').submit();
                                        }
                                    "
                                            class="form-control form-control-sm">
                                            <?php
                                            $status_persetujuan = [['name' => 'BELUM DISETUJUI', 'val' => 0], ['name' => 'DISETUJUI', 'val' => 1]];
                                            ?>
                                            @foreach ($status_persetujuan as $vItem)
                                                <option
                                                    {{ $item->status_persetujuan_raker == $vItem['val'] ? 'selected' : '' }}
                                                    value="{{ $vItem['val'] }}"> {{ $vItem['name'] }} </option>
                                            @endforeach
                                        </select>
                                        <sub id="has-email-sending-{{ $item->id }}" class="display-none">Pengriman
                                            Email...</sub>
                                    </form>
                                    <div class="col-md-2">
                                        <div class="loader display-none" id="loader-{{ $item->id }}"></div>
                                    </div>
                                </div>



                            </td>
                            <td>
                                <select class="form-control form-control-sm">
                                    <option> {{ $item->raker->pesertaRaker->count() }} ORANG </option>
                                    @foreach ($item->raker->pesertaRaker as $vPeserta)
                                        <option> {{ $vPeserta->pegawaiPerusahaan->nama_pegawai }} </option>
                                    @endforeach
                                </select>
                            </td>
                            <td>

                                <button type="button" class="btn btn-primary btn-xs" data-toggle="modal"
                                    data-target="#no-persetujuan-{{ $item->id }}">
                                    + Tambahkan
                                </button>

                            </td>

                            <!-- The Modal -->
                            <div class="modal fade" id="no-persetujuan-{{ $item->id }}">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <form action=" {{ route('ad_persetujuan_rapat.update', [$item->id]) }} "
                                            method="post">
                                            {{ csrf_field() }}
                                            {{ method_field('PUT') }}
                                            <!-- Modal Header -->
                                            <div class="modal-header">
                                                <h4 class="modal-title"> {{ ucwords($item->raker->nama_raker) }} </h4>
                                                <button type="button" class="close"
                                                    data-dismiss="modal">&times;</button>
                                            </div>

                                            <!-- Modal body -->
                                            <div class="modal-body" style="padding-bottom:5%;">

                                                <textarea onkeyup="setDeskripsi(this)" onload="setDeskripsi(this)" cols="30" rows="10"
                                                    name='deskripsi_persetujuan_raker' class="form-control form-control-sm"
                                                    placeholder="Alasan persetujuan atau penolakan [optional] jadikan ini sebagai pesan yang akan di berikan kepada si pemohon rapat ">{{ $item->deskripsi_persetujuan_raker }}</textarea>

                                            </div>

                                            <!-- Modal footer -->
                                            <div class="modal-footer">
                                                <button data-idRaker='{{ $item->id_raker }}'
                                                    data-idSekretarisBidang='{{ $item->id_sekretaris_bidang }}'
                                                    onclick="setBtnSimpan(this)" onload="setBtnSimpan(this)"
                                                    data-link="{{ route('ad_persetujuan_rapat.update', $item->id) }}"
                                                    class="btn btn-sm btn-primary"> SIMPAN </button>
                                                <button type="button" class="btn btn-secondary btn-sm"
                                                    data-dismiss="modal">Close</button>
                                            </div>

                                        </form>
                                    </div>
                                </div>
                            </div>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
@section('script')
    <script>
        function addLoadingPage(id) {

            let idHasEmailSending = "has-email-sending-" + id;
            let idLoader = "loader-" + id;

            let eHasElementSending = document.getElementById(idHasEmailSending)
            let eLoader = document.getElementById(idLoader)

            eHasElementSending.classList.remove("display-none")
            eLoader.classList.remove("display-none")

            // var data = document.getElementsByClassName('wrapper').item(0)
            // data.setAttribute('style', 'position: absolute; width: 100%; height: 100%; background-color: white; flex: content;  display: flex; align-content: center; justify-content: center;')
            // data.innerHTML = `
        //     <img src="https://flevix.com/wp-content/uploads/2019/07/Comp-2.gif"/>
        // `
        }
    </script>
@endsection
