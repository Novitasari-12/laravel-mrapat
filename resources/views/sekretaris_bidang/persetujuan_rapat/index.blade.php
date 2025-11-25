@extends('admin-partials.welcome')
@section('content-title')
    Persetujuan Rapat
@endsection
@section('content')
    <?php $no = 1 ; ?>
    <table class="table"> 
        <thead>
            <tr>
                <th style="width:1%;">#</th>
                <th> Nama</th>
                <th> Ruangan</th>
                <th> Waktu Rapat</th>
                <th> Jumlah Peserta</th>
                <th> QR CODE </th>
            </tr>
        </thead>
        <tbody>
            @foreach ($persetujuan as $item)
                <tr>
                    <td> {{$no++}} </td>
                    <td> {{$item->raker->nama_raker}} </td>
                    <td> {{$item->raker->ruangan->nama_ruangan }} </td>
                    <td> {{$item->raker->tanggal_jam_masuk_raker}} -{{$item->raker->tanggal_jam_keluar_raker}} </td>
                    <td> {{$item->raker->jumlah_peserta_raker}} </td>
                    <td>
                        <a href=" {{route('sb_persetujuan_rapat.show', $item->id_raker)}} " class="btn btn-xs btn-success"> <b class="fa fa-print"></b> </a>
                        <button class="btn btn-xs btn-info" data-generate='{{json_encode($raker[$item->id])}}' data-toggle="modal" onclick="addData(this)" id='generate-qrcode' data-target="#generate_barcode-modal-{{$item->id}}"> Generate </button>
                        <!-- The Modal -->
                        <div class="modal fade" id="generate_barcode-modal-{{$item->id}}">
                            <div class="modal-dialog modal-xl">
                                <div class="modal-content">
                                
                                    <!-- Modal Header -->
                                    <div class="modal-header">
                                    <h4 class="modal-title">QR CODE {{$item->raker->nama_raker}} </h4>
                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                    </div>
                                    
                                    <!-- Modal body -->
                                    <div class="modal-body" id="box-qrcode">
                                    
                                    </div>
                                    
                                    <!-- Modal footer -->
                                    <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                    </div>
                                    
                                </div>
                            </div>
                        </div>
                    </th>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
@section('script')
    <script>

        $('.table').DataTable()
        function addData(e){
            var dataGenerate = e.getAttribute('data-generate')
            canvas = document.getElementById("box-qrcode")
            canvas.innerHTML = ""
            new QRCode(canvas, {
                text: dataGenerate,
                width: 450,
                height: 450,
                colorDark: "#000000",
                colorLight: "#ffffff",
                correctLevel: QRCode.CorrectLevel.L
            });
        }

    </script>
@endsection