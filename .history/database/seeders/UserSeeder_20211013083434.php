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
      $user1 = User::create([
            'name' => 'mais',
            'email' => 'mm@M.com',
            'password' => Hash::make('mmmmmmm'),
            'date' => '2015-01-01',
            'gender' => 'fmale',
            'Permittivity' => 'Employee'
        ]);
      $user1->createToken('LaravelAuthApp')->accessToken;
      $user1 -> save();

      $user2 = User::create([
        'name' => 'Ahhmad',
        'email' => 'aa@a.com',
        'password' => Hash::make('aaaaaaa'),
        'date' => '2020-01-01',
        'gender' => 'male',
        'Permittivity' => 'Admin'
      ]);
    $user2->createToken('LaravelAuthApp')->accessToken;
    $user2 -> save();

    }
}
