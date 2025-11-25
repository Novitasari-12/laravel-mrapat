@extends('admin-partials.welcome')
@section('content-title')
    Permohonan Rapat
@endsection
@section('content')

    <div class="card">
        <div class="card-header">
            <a href=" {{ route('sb_permohonan_rapat.create') }} " class="btn btn-xs btn-success"> <b class="fa fa-plus"></b>
                Buat Pemohonan Rapat </a>
        </div>
        <div class="card-body table-responsive">
            <?php $no = 1; ?>
            <table class="table">
                <thead>
                    <tr>
                        <th style="width:1%;">#</th>
                        <th> Nama</th>
                        <th> Ruangan</th>
                        <th> Waktu Rapat</th>
                        <th> Jumlah Peserta</th>
                        <th> Option </th>
                        <th> Persetujuan </th>
                        <th> Kehadiran </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($raker as $item)
                        <tr>
                            <td> {{ $no++ }} </td>
                            <td> {{ $item->nama_raker }} </td>
                            <td> {{ $item->ruangan->nama_ruangan }} </td>
                            <td>
                                {{ $item->tanggal_jam_masuk_raker }}
                                <br> <b>s/d</b> {{ $item->tanggal_jam_keluar_raker }}
                            </td>
                            <td> {{ $item->jumlah_peserta_raker }} ORANG</td>
                            <td>
                                @if (isset($item->persetujuanRaker))
                                    <form id='del-ajukan-{{ $item->id }}'
                                        action="{{ route('sb_permohonan_rapat.batal_pengajuan', $item->persetujuanRaker->id) }}"
                                        style="display:none;" method="post">
                                        {{ csrf_field() }}
                                        {{ method_field('DELETE') }}
                                    </form>
                                    <a href="#" class="btn btn-danger btn-xs"
                                        onclick="
                                var cfm = confirm('Yakin Akan Menghapus ?');
                                if(cfm){
                                    event.preventDefault();
                                    document.getElementById('del-ajukan-{{ $item->id }}').submit();
                                }
                                ">
                                        BATAL AJUKAN </a>
                                @else
                                    <a href="{{ route('sb_permohonan_rapat.edit', $item->id) }}"
                                        class="btn btn-info btn-xs"> <b class="fa fa-eye"></b> | <b class="fa fa-edit"></b>
                                    </a>
                                    <form id='{{ $item->id }}'
                                        action="{{ route('sb_permohonan_rapat.destroy', $item->id) }}"
                                        style="display:none;" method="post">
                                        {{ csrf_field() }} {{ method_field('DELETE') }}
                                    </form>
                                    <a href="" class="btn btn-danger btn-xs"
                                        onclick="
                                    var cfm = confirm('Yakin Akan Menghapus ?');
                                    if(cfm){
                                    event.preventDefault();
                                    document.getElementById('{{ $item->id }}').submit();
                                    }
                                ">
                                        <b class="fa fa-times"></b> </a>
                                    <form id='ajukan-{{ $item->id }}'
                                        action="{{ route('sb_permohonan_rapat.pengajuan', $item->id) }}"
                                        style="display:none;" method="post">
                                        {{ csrf_field() }}
                                    </form>
                                    <a href="#" class="btn btn-success btn-xs"
                                        onclick="
                                    event.preventDefault();
                                    document.getElementById('ajukan-{{ $item->id }}').submit();
                                ">
                                        AJUKAN </a>
                                @endif
                            </td>
                            @if (isset($item->persetujuanRaker))
                                <td>
                                    @if ($item->persetujuanRaker->status_persetujuan_raker)
                                        @if (!isset($item->notulenRaker->hasil_raker))
                                            <a class="btn btn-xs btn-primary text-white"
                                                href="{{ route('sb_kesimpulan_rapat.edit', [
                                                    'sb_kesimpulan_rapat' => $item,
                                                ]) }}">
                                                <i class="fa fa-plus"></i>
                                                Buat Kesimpulan Rapat
                                            </a>
                                        @else
                                            <div class="btn-group">
                                                <a class="btn btn-xs btn-primary text-white"
                                                    href="{{ route('sb_kesimpulan_rapat.edit', [
                                                        'sb_kesimpulan_rapat' => $item,
                                                    ]) }}">
                                                    <i class="fa fa-edit"></i>
                                                    Edit Kesimpulan Rapat
                                                </a>
                                                <a href="{{ route('sb_kesimpulan_rapat.show', [
                                                    'sb_kesimpulan_rapat' => $item,
                                                ]) }}"
                                                    class="btn btn-xs btn-info text-white">
                                                    <i class="fa fa-eye"></i>
                                                    Hasil Kesimpulan Rapat
                                                </a>
                                            </div>
                                        @endif

                                        <button class="btn btn-xs btn-success"> <i
                                                class="ace-icon fa fa-check white bigger-125"> </i> Disetujui </a> </button>

                                        <button type="button" class="btn btn-primary btn-xs" data-toggle="modal"
                                            data-target="#modal-persetujuan-{{ $item->id }}">
                                            <i class="fa fa-info"> </i>
                                        </button>

                                        <a href=" {{ route('sb_persetujuan_rapat.show', $item->id) }} "
                                            class="btn btn-xs btn-success"> <b class="fa fa-print"></b> </a>

                                        <!-- The Modal -->
                                        <div class="modal fade" id="modal-persetujuan-{{ $item->id }}">
                                            <div class="modal-dialog modal-xl">
                                                <div class="modal-content">

                                                    <!-- Modal Header -->
                                                    <div class="modal-header">
                                                        <h4 class="modal-title text-capitalize"> {{ $item->nama_raker }}
                                                        </h4>
                                                        <button type="button" class="close"
                                                            data-dismiss="modal">&times;</button>
                                                    </div>

                                                    <!-- Modal body -->
                                                    <div class="modal-body">
                                                        <p> {{ $item->persetujuanRaker->deskripsi_persetujuan_raker }} </p>
                                                    </div>

                                                    <!-- Modal footer -->
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary"
                                                            data-dismiss="modal">Close</button>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                    @else
                                        {{-- <i class="ace-icon fa fa-spinner fa-spin info bigger-125"> </i> Menunggu... --}}
                                        <button class="btn btn-warning btn-xs"><i
                                                class="ace-icon fa fa-exclamation-triangle info bigger-125"> </i> Belum
                                            Disetujui </button>

                                        @if ($item->persetujuanRaker->deskripsi_persetujuan_raker != '')
                                            <button class="btn btn-xs btn-primary" data-toggle="modal"
                                                data-target="#modal-info-{{ $item->id }}"> <i class="fa fa-info"></i>
                                            </button>
                                        @endif

                                        <!-- The Modal -->
                                        <div class="modal fade" id="modal-info-{{ $item->id }}">
                                            <div class="modal-dialog modal-xl">
                                                <div class="modal-content">

                                                    <!-- Modal Header -->
                                                    <div class="modal-header">
                                                        <h4 class="modal-title text-capitalize"> {{ $item->nama_raker }}
                                                        </h4>
                                                        <button type="button" class="close"
                                                            data-dismiss="modal">&times;</button>
                                                    </div>

                                                    <!-- Modal body -->
                                                    <div class="modal-body">
                                                        <p> {{ $item->persetujuanRaker->deskripsi_persetujuan_raker }} </p>
                                                    </div>

                                                    <!-- Modal footer -->
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary"
                                                            data-dismiss="modal">Close</button>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                </td>
                            @else
                                <td></td>
                            @endif
                            <td>
                                @if ($item->persetujuanRaker)
                                    <a href="{{ route('sb_kehadiran_rapat.detail', $item->id) }}"
                                        class="btn btn-primary btn-xs text-white"> <i class="fa fa-check"></i> Kehadiran
                                        Perserta </a>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>


@endsection
