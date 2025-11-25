<?php 

     $notulen = $data['notulen'];
     $pegawai = $data['pegawai'];
     $raker = $data['raker'];
     $peserta = $data['peserta'];
 
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>HASIL RAPAT</title>
    <style>
        tr, td, th {
            border-bottom: 1px solid gray;
            padding: 1%;
        }
        table {
            text-align: left;
            width: 100%;
        }
        td {
            width : 10% ;
        }
    </style>
</head>
<body>

    <p>Kepada Yth. <br/>
    {{$pegawai->nama_pegawai}}<br/>
    di tempat</p>

    <p> hal : hasil rapat {{$raker->nama_raker}} </p>
    
    <table border="0" class="table">
        <tr> <td> Ruangan Rapat </td> <th> {{$raker->ruangan->nama_ruangan}} </th> </tr>
        <tr> <td> Waktu Masuk  </td> <th> {{$raker->tanggal_jam_masuk_raker}} </th> </tr>
        <tr> <td> Waktu Keluar  </td> <th> {{$raker->tanggal_jam_keluar_raker}} </th> </tr>
        <tr> <td> Jumlah Peserta  </td> <th> {{$raker->jumlah_peserta_raker}} </th> </tr>
        <tr> <td> Deskripsi Rapat  </td> <th> {!!$raker->deskripsi_raker!!} </th> </tr>
    </table>

    <h4>Hasil :</h4>
    {!! $notulen->hasil_raker !!}

    <p> Atas perhatian Bapak/Ibu {{$pegawai->nama_pegawai}}, kami ucapkan terimakasih </p>

</body>
</html>