@extends('admin-partials.welcome')
@section('content-title')
    Kesimpulan Rapat
@endsection
@section('content')
    <div class="card">
        <div class="card-body">
            <?php $no = 1; ?>
            <table class="table">
                <thead>
                    <tr>
                        <th style="width:1%;">#</th>
                        <th> Nama</th>
                        <th> Ruangan</th>
                        <th> Waktu Rapat</th>
                        <th> Jumlah Peserta</th>
                        <th> Status Tulis Notulen</th>
                        <th> Hasil Rapat </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($notulen as $item)
                        <tr>
                            <td> {{ $no++ }} </td>
                            <td> {{ $item->raker->nama_raker }} </td>
                            <td> {{ $item->raker->ruangan->nama_ruangan }} </td>
                            <td> {{ $item->raker->tanggal_jam_masuk_raker }} -{{ $item->raker->tanggal_jam_keluar_raker }}
                            </td>
                            <td> {{ $item->raker->jumlah_peserta_raker }} </td>
                            <td>
                                <form id="status_tulis_{{ $item->id_raker }}"
                                    action="{{ route('sb_kesimpulan_rapat.update', $item->id_raker) }}" method="post">
                                    {{ csrf_field() }}
                                    {{ method_field('PUT') }}

                                    <select
                                        onchange="
                                    let iSelected = this.selectedIndex
                                    var cfm = confirm('Yakin Mengubah Status ?');
                                    if(cfm){
                                        event.preventDefault();
                                        document.getElementById('status_tulis_{{ $item->id_raker }}').submit();
                                    } else {
                                        this.selectedIndex = iSelected === 0 ? 1 : 0
                                    }
                                "
                                        name="status_tulis" class="form-control form-control-sm">
                                        @foreach ([['val' => 0, 'name' => 'Not Active'], ['val' => 1, 'name' => 'Active']] as $vStat)
                                            <option {{ $vStat['val'] == $item->status_tulis ? 'selected' : '' }}
                                                value="{{ $vStat['val'] }}"> {{ $vStat['name'] }} </option>
                                        @endforeach
                                    </select>

                                </form>
                            </td>
                            <td>
                                <button class="btn btn-xs btn-info" data-toggle="modal"
                                    data-target="#generate_barcode-modal-{{ $item->id }}"> <b class="fa fa-eye"></b>
                                </button>
                                <div class="modal fade" id="generate_barcode-modal-{{ $item->id }}">
                                    <div class="modal-dialog modal-xl">
                                        <div class="modal-content">

                                            <!-- Modal Header -->
                                            <div class="modal-header">
                                                <h4 class="modal-title">HASIL RAPAT {{ $item->raker->nama_raker }} </h4>
                                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                            </div>

                                            <!-- Modal body -->
                                            <div class="modal-body" id="box-qrcode">
                                                {!! $item->hasil_raker !!}
                                            </div>

                                            <!-- Modal footer -->
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary"
                                                    data-dismiss="modal">Close</button>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                                <a href=" {{ route('sb_kesimpulan_rapat.show', [
                                    'sb_kesimpulan_rapat' => $item->raker,
                                    'print' => true,
                                ]) }} "
                                    class="btn btn-xs btn-success"> <b class="fa fa-print"></b> </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
