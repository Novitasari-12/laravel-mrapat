
@include('admin-partials.style')

<div class="container">
    <table class="table">
        <tr> <th> ID Rapat </th> <td> {{$raker->id}} </td> </tr>
        <tr> <th> Nama Rapat </th> <td> {{$raker->nama_raker}} </td> </tr>
        <tr> <th> Ruangan</th> <td> {{$raker->ruangan->nama_ruangan}} </td> </tr>
        <tr> <th> Waktu Rapat</th> <td> {{$raker->tanggal_jam_masuk_raker}} - {{$raker->tanggal_jam_keluar_raker}}  </td> </tr>
        <tr> <th> Jumlah Peserta</th> <td> {{$raker->jumlah_peserta_raker}} </td> </tr>
    </table>
    <center>
        <div id="qrcode" data="{{json_encode($qrcode)}}"></div>
    </center>
    
</div>

@include('admin-partials.script')

<script type="text/javascript">

    canvas = document.getElementById("qrcode")
    canvas.innerHTML = ""
    new QRCode(canvas, {
        text: canvas.getAttribute('data'),
        width: 450,
        height: 450,
        colorDark: "#000000",
        colorLight: "#ffffff",
        correctLevel: QRCode.CorrectLevel.L
    });

    window.print();
</script>