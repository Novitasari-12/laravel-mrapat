<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Notulen Edit | Kesimpulan Rapat</title>
    @include('admin-partials.style')
</head>

<body>

    <div class="container">
        <a href=" {{ route('notulen.logout') }} " id="publish-hasil" class="btn btn-info btn-xs"> Logout </a>
        <table class="table">
            <tr>
                <th style="width:20%;"> Nama Rapat </th>
                <td> {{ $notulen->raker->nama_raker }} </td>
            </tr>
            <tr>
                <th style="width:20%;"> Ruangan Rapat </th>
                <td> {{ $notulen->raker->ruangan->nama_ruangan }} </td>
            </tr>
            <tr>
                <th style="width:20%;"> Waktu Rapat </th>
                <td> {{ $notulen->raker->tanggal_jam_masuk_raker }} <b>s/d</b>
                    {{ $notulen->raker->tanggal_jam_keluar_raker }} </td>
            </tr>
        </table>

        @if (!$notulen->status_tulis)
            <div class="alert alert-danger">
                Status penulisan tidak active, jadi kamu tidak dapat melakukan pengeditan, minta ke admin untuk
                mengactivekannya
            </div>
        @endif
        <textarea {{ !$notulen->status_tulis ? 'readonly' : '' }} class="form-control" onkeyup="setText(this)"
            id="hasil_rapat" name="hasil_rapat" cols="30" rows="10">{{ $notulen->hasil_raker }}</textarea>

        <button {{ !$notulen->status_tulis ? 'disabled' : '' }} id="simpan-hasil" class="btn btn-primary col-md-12">
            Simpan </button>

    </div>

    <div id="alert"></div>
    <hr>

    <div class="container">
        <button {{ !$notulen->status_tulis ? 'disabled' : '' }} onclick="publish(this)" id="publish-hasil"
            data-idnotulen="{{ $notulen->id }}" data-idraker="{{ $notulen->id_raker }}" class="btn btn-danger">
            Publish </button>
    </div>

    @include('admin-partials.script')
    <script>
        CKEDITOR.replace('hasil_rapat')

        var editor = CKEDITOR.instances['hasil_rapat'];
        editor.on('key', function(evt) {
            requestOutNotulenNote();
        });

        function getDataMetting() {
            return CKEDITOR.instances['hasil_rapat'].getData();
        }

        function publish(e) {
            var cfm = confirm('Dengan melakukan publish anda tidak akan bisa mengubah hasil rapat ini lagi, yakin ?');
            if (cfm) {
                e.disabled = true;
                e.innerHTML = `<i class="ace-icon fa fa-spinner fa-spin warning bigger-125"></i>`
                $.ajax({
                    url: "{{ route('ntln_hasil_rapat.update', $notulen->id) }}",
                    method: 'PUT',
                    data: {
                        publish: 1
                    },
                    success: result => {
                        console.log(result)
                        // showAlert('alert', result.msg, 'success')
                        // location.reload()
                        location.href = 'logout'
                    },
                    error: err => {

                        var id = e.getAttribute('data-idnotulen')
                        var id_raker = e.getAttribute('data-idraker')

                        $.ajax({
                            url: '{{ url('api/action/batal_publish_notulen') }}',
                            method: 'POST',
                            data: {
                                id,
                                id_raker
                            },
                            success: (data) => {
                                // console.log(data)
                                // msg = err.responseJSON 
                                // showAlert('alert', "Tidak dapat mengirim email", 'danger')
                                location.reload()
                            },
                            error: err => {
                                console.log(err)
                            }
                        })

                    }
                })
            }
        }

        $('#simpan-hasil').click(() => {
            requestOutNotulenNote();
        })

        function requestOutNotulenNote() {
            $.ajax({
                url: "{{ route('ntln_hasil_rapat.update', $notulen->id) }}",
                method: 'PUT',
                data: {
                    hasil_raker: getDataMetting()
                },
                success: result => {
                    console.log(result)
                },
                error: err => {
                    console.log(err)
                    msg = err.responseJSON
                }
            })
        }
    </script>
</body>

</html>
