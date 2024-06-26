<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            [
                'id' => 1,
                'name' => 'Admin',
                'username' => 'admin',
                'password' => Hash::make('admin123'),
                'level' => 'Admin',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'id' => 2,
                'name' => 'Naufal',
                'username' => 'naufal',
                'password' => Hash::make('12345678'),
                'level' => 'Penumpang',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'id' => 3,
                'name' => 'Harry Antomy',
                'username' => 'harry',
                'password' => Hash::make('12345678'),
                'level' => 'Penumpang',
                'created_at' => now(),
                'updated_at' => now()
            ]
        ]);
    }
}
