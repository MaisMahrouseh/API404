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
        User::insert([
        'name' => 'mais',
        'email' => 'mm@m.com',
        'password' => Hash::make('mmmmmmm'),
        'date' => '2015-01-01',
        'gender' => 'fmale',
        'Permittivity' => 'Employee'],
        [
        'name' => 'Ahhmad',
        'email' => 'aa@a.com',
        'password' => Hash::make('aaaaaaa'),
        'date' => '2020-01-01',
        'gender' => 'male',
        'Permittivity' => 'Admin'
        ]);
    }
}
