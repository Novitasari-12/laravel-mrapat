
@include('admin-partials.style')

<div class="container">
    <h2>KETERANGAN RAPAT</h2>

    <table class="table">
        <tr> <th> Nama Rapat </th> <td> {{$raker->nama_raker}} </td> </tr>
        <tr> <th> Ruangan</th> <td> {{$raker->ruangan->nama_ruangan}} </td> </tr>
        <tr> <th> Waktu Rapat</th> <td> {{$raker->tanggal_jam_masuk_raker}} - {{$raker->tanggal_jam_keluar_raker}}  </td> </tr>
        <tr> <th> Jumlah Peserta</th> <td> {{$raker->jumlah_peserta_raker}} </td> </tr>
        <tr> <th> Hasil Rapat </th> <td> {!!$raker->notulenRaker->hasil_raker!!} </td>  </tr>
    </table>
    
    <h2>PESERTA RAPAT</h2>
    <hr/>

    <table class="table">
        <?php $no=1; ?>
        <thead>
            <tr>
                <th>#</th>
                <th>NIP</th>
                <th>NAMA</th>
                <th>EMAIL</th>
                <th>WAKTU ABSEN</th>
                <th>KETERANGAN ABSEN</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($raker->pesertaRaker as $item)
                <tr class="text-{{$item->status_absensi ? 'success' : 'danger'}} ">
                    <th> {{$no++}} </th>
                    <th> {{$item->pegawaiPerusahaan->nip_pegawai}} </th>
                    <th> {{$item->pegawaiPerusahaan->nama_pegawai}} </th>
                    <th> {{$item->pegawaiPerusahaan->email_pegawai}} </th>
                    <th> {{$item->tanggal_jam_absensi}}</th>
                    <th> {{$item->keterangan_absensi}} </th>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

<script type="text/javascript">
    window.print();
</script>