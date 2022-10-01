<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RequirementSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('requirements')->insert([
            'type_id'  => 1,
            'category' => 'master',
            'title'    => 'Draf Ranperda',
            'term'     => 'master',
            'format'   => 'pdf,doc,docx',
            'order'    => 1, 
        ]);
    }
}
