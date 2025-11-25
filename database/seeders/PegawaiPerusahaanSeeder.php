<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\PegawaiPerusahaan;
use App\MyLibraries\Generate\Id;

class PegawaiPerusahaanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {


        $data = '[
            {
            "NAMA": "JEFRI MARTHA",
            "UNIT": "STI SUMATERA BARAT",
            "EMAIL": "jefri.martha@mail.co.id"
            },
            {
            "NAMA": "NUR ROKHMANUDDIN",
            "UNIT": "STI SUMATERA BARAT",
            "EMAIL": "nur.rokhmanuddin@mail.co.id"
            },
            {
            "NAMA": "NORAVIAN YOSA",
            "UNIT": "STI SUMATERA BARAT",
            "EMAIL": "yanyosa@mail.co.id"
            },
            {
            "NAMA": "MUTIA KUMALA SARI",
            "UNIT": "STI SUMATERA BARAT",
            "EMAIL": "mutia.kumala@mail.co.id"
            },
            {
            "NAMA": "DJUL IRFAN ANHAR",
            "UNIT": "STI SUMATERA BARAT",
            "EMAIL": "irfan.anhar@mail.co.id"
            },
            {
            "NAMA": "AFDAL",
            "UNIT": "STI SUMATERA BARAT",
            "EMAIL": "afdalmtk@gmail.com"
            },
            {
            "NAMA": "NUR AFUWA NINGTYAS",
            "UNIT": "STI SUMATERA BARAT",
            "EMAIL": "nurafuwaningtyas@mail.com"
            },
            {
            "NAMA": "SANDRI",
            "UNIT": "STI SUMATERA BARAT",
            "EMAIL": "sandriadnin26@mail.com"
            },
            {
            "NAMA": "SHIRO",
            "UNIT": "STI SUMATERA BARAT",
            "EMAIL": "lxafdal@gmail.com"
            }
        ]';

        $data = json_decode($data);
        $indx = 0;
        foreach ($data as $item) {
            PegawaiPerusahaan::create([
                'id' => Id::generate(new PegawaiPerusahaan()),
                'nip_pegawai' => ($indx++) . "918022SCY",
                'nama_pegawai' => $item->NAMA,
                'email_pegawai' => $item->EMAIL,
                'unit_pegawai' => $item->UNIT,
            ]);
        }
    }
}
