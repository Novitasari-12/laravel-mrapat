<?php

namespace Database\Seeders;

use App\Models\ListFasilitas;
use App\MyLibraries\Generate\Id;
use Illuminate\Database\Seeder;

class FasilitasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $dataFasilitas = [
            'INFOKUS',
            'LAPTOP',
            'KABEL HDMI',
            'MEJA',
            'KURSI',
            'PAPAN TULIS',
            'MIC',
            'SPIDOL',
            'SPEAKER',
            'PRINTER',
            'VICON',
        ];

        foreach ($dataFasilitas as $key => $value) {
            ListFasilitas::create([
                'id' => Id::generate(new ListFasilitas()),
                'fasilitas' => $value
            ]);
        }
    }
}
