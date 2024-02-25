<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TransportasiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('transportasi')->insert([
            'name' => 'Bus 01',
            'kode' => 'BH 7066 AU',
            'jumlah' => 36,
            'category_id' => 1
        ]);
    }
}
