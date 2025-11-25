<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UsersTableSeeder::class);
        $this->call(LevelSeeder::class);
        $this->call(UserSeeder::class);
        $this->call(RuanganSeeder::class);
        $this->call(PegawaiPerusahaanSeeder::class);
        $this->call(FasilitasSeeder::class);
    }
}
