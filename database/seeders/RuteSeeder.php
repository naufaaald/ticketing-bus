<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RuteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('rute')->insert([
            'tujuan' => 'Bukittinggi',
            'start' => 'Jambi',
            'end' => 'Bukittinggi',
            'harga' => 175000,
            'jam' => '02:00:00',
            'transportasi_id' => 1,
        ]);
    }
}
