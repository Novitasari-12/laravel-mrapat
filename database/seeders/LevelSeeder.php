<?php

namespace Database\Seeders;

use App\Models\Level;
use App\MyLibraries\Generate\Id;
use Illuminate\Database\Seeder;

class LevelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Level::create([
            'id' => Id::generate(new Level()),
            'level' => 'adum_fasilitas' 
        ]);

        Level::create([
            'id' => Id::generate(new Level()),
            'level' => 'sekretaris_bidang'
        ]);
    }
}
