<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserSeeder extends Seeder
{
    public function run()
    {
        UserDB::insert([],[]);
      $user1 = User::create([

        ]);


      $user2 = User::create([
        'name' => 'Ahhmad',
        'email' => 'aa@a.com',
        'password' => Hash::make('aaaaaaa'),
        'date' => '2020-01-01',
        'gender' => 'male',
        'Permittivity' => 'Admin'
      ]);

    }
}
