<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('types')->insert([
            'name'  => 'Ranperda',
            'slug'  => 'ranperda',
            'desc'  => 'Rancangan Peraturan Daerah',
        ]);

        DB::table('types')->insert([
            'name'  => 'Ranperbup',
            'slug'  => 'ranperbup',
            'desc'  => 'Rancangan Peraturan Bupati',
        ]);

        DB::table('types')->insert([
            'name'  => 'Rancangan SK',
            'slug'  => 'ransk',
            'desc'  => 'Rancangan Surat Keputusan',
        ]);
    }
}
