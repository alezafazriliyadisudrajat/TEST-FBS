<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class User extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'username' => 'aleza_2775',
            'password' => Hash::make('270705'),
            'posisi' => 'Manajer',
            'gaji' => '999999.99',
            'role' => 'admin',
        ]);
    }
}
