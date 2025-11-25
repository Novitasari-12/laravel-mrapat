<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Level;
use App\Models\SekretarisBidang;
use App\Models\User as ModelsUser;
use Illuminate\Database\Seeder;
use App\MyLibraries\Generate\Id;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::create([
            'id_level' => Level::where('level', 'adum_fasilitas')->first()->id,
            'email' => 'admin@admin.com',
            'password' => Hash::make(123456),
        ]);

        $user = ModelsUser::create([
            'id_level' => Level::where('level', 'sekretaris_bidang')->first()->id,
            'email' => 'sekretaris@bidang.com',
            'password' => Hash::make(123456),
        ]);

        $sekretaris_bidang = SekretarisBidang::create([
            'id' => Id::generate(new SekretarisBidang()),
            'id_user' => $user->id,
        ]);


    }
}
