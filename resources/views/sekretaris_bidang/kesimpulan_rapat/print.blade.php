
@include('admin-partials.style')

<div class="container">
    <table class="table">
        <tr> <th> Nama Rapat </th> <td> {{$raker->nama_raker}} </td> </tr>
        <tr> <th> Ruangan</th> <td> {{$raker->ruangan->nama_ruangan}} </td> </tr>
        <tr> <th> Waktu Rapat</th> <td> {{$raker->tanggal_jam_masuk_raker}} - {{$raker->tanggal_jam_keluar_raker}}  </td> </tr>
        <tr> <th> Jumlah Peserta</th> <td> {{$raker->jumlah_peserta_raker}} </td> </tr>
        <tr> <th> Hasil Rapat </th> <td>  </td> </tr>
    </table>
    {!!$raker->notulenRaker->hasil_raker!!}
</div>

<script type="text/javascript">
    window.print();
</script>
