@extends('admin-partials.welcome')
@section('content-title')
    Pegawai Perusahaan
@endsection
@section('content')
    <div class="card">
        <div class="card-header">
            <a href="{{ route('ad_pegawai_perusahaan.create') }}" class="btn btn-primary btn-sm">
                <i class="fa fa-plus"></i>
                Tambah Data Pengawai
            </a>
            <button type="button" class="btn btn-xs btn-info" data-toggle="modal" data-target="#add-pegawai-perusahaan">
                Import File Excel
            </button>
            <a href="{{ asset('excel/FormatExcelPegawaiPerusahaan.xls') }}" target="blank" class="btn btn-xs btn-success"
                data-toggle="modal">
                Unduh Format Excel
            </a>
            <!-- Modal -->
            <div class="modal fade" id="add-pegawai-perusahaan" tabindex="-1" role="dialog"
                aria-labelledby="add-pegawai-perusahaanLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Upload File Excel</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div id="response"></div>
                            <div class="form-group">
                                <label class="ace-file-input"> File Excel .xls</label>
                                <input type="file" class="form-control form-control-sm" accept=".xls" name="file-excel"
                                    id="file-excel">
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-xs btn-secondary" data-dismiss="modal">Close</button>
                            <button type="button" id="btnUploadFileExcel" class="btn btn-xs btn-primary">Upload</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-body">
            @php
                $index = 1;
            @endphp
            <table class="table">
                <thead>
                    <tr>
                        <th style="width:2%;">#</th>
                        <th style="width:10%;">NIP</th>
                        <th>NAMA</th>
                        <th>BIDANG</th>
                        <th>UNIT</th>
                        <th>EMAIL</th>
                        <th>TELPON</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($pegawaiPerusahaan as $item)
                        <tr>
                            <td style="widtd:2%;"> {{ $index++ }} </td>
                            <td> {{ $item->nip_pegawai }} </td>
                            <td> {{ $item->nama_pegawai }} </td>
                            <td> {{ $item->bidang_pegawai }} </td>
                            <td> {{ $item->unit_pegawai }} </td>
                            <td> {{ $item->email_pegawai }} </td>
                            <td> {{ $item->no_telpon }} </td>
                            <td>

                                <a href="{{ route('ad_pegawai_perusahaan.edit', $item->id) }}"
                                    class="btn btn-xs btn-primary">
                                    <i class="fa fa-edit"></i>
                                </a>

                                <form id='{{ $item->id }}'
                                    action="{{ route('ad_pegawai_perusahaan.destroy', $item->id) }}" style="display:none;"
                                    method="post">
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
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
@section('script')
    <script src="{{ asset('assets/js/xls.js') }}"></script>
    <script>
        $(() => {
            var file = document.getElementById('file-excel')
            file.addEventListener('change', (e) => {
                var oFile = e.target.files[0]
                var sFileName = oFile.name
                var reader = new FileReader()

                reader.onload = (e) => {
                    var data = e.target.result
                    var cfb = XLS.CFB.read(data, {
                        type: 'binary'
                    });
                    var wb = XLS.parse_xlscfb(cfb);
                    wb.SheetNames.forEach(item => {
                        var pegawai = XLS.utils.sheet_to_row_object_array(wb.Sheets[item])
                        var btnUpload = document.getElementById('btnUploadFileExcel')
                        btnUpload.addEventListener('click', e => {
                            console.log(pegawai)
                            $.ajax({
                                method: 'POST',
                                url: '{{ route('ad_pegawai_perusahaan.store') }}',
                                data: {
                                    pegawai
                                },
                                success: (data) => {
                                    console.log(data)
                                    alert('Success Import')
                                    setTimeout(() => location.reload(),
                                        1000)
                                },
                                error: (err) => {
                                    console.log(err)
                                    alert('Gagal Import')
                                    setTimeout(() => location.reload(),
                                        1000)
                                }
                            })
                        })
                    })
                }

                reader.readAsBinaryString(oFile)

            }, false)
        })
    </script>
@endsection
