<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert(
            [
                'f_name' => 'admin',
                'l_name' => 'admin',
                'role' => env('ADMIN'),
                'status' => env('ACTIVE'),
                'email' => 'admin@gmail.com',
                'password' => Hash::make('password'),
            ]
        );
    }
}
