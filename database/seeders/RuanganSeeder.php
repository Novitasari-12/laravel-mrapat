<?php

namespace Database\Seeders;

use App\Models\Ruangan;
use Illuminate\Database\Seeder;
use App\MyLibraries\Generate\Id;

class RuanganSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            ["BAGONJONG", "30"],
            ["AULA 1",	"100"],
            ["MERAPI 1", "15"],
            ["MERAPI 2", "15"],
            ["SINGGALANG", "15"],
            ["PAGARUYUNG", "25"],
            ["TANDIKEK", "20"],
            ["AULA RENDAN",	"15"],
            ["AULA LAKDAN",	"15"]
        ];

        foreach ($data as $key => $value) {
            Ruangan::create([
                'id' => Id::generate(new Ruangan()),
                'nama_ruangan' => $value[0],
                'kapasitas_ruangan' => $value[1],
            ]);
        }

    }
}
