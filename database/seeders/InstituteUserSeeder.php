<?php

namespace Database\Seeders;

use App\Models\Institute;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class InstituteUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $institutes = Institute::all();

        foreach ($institutes as $institute) {
            if (rand(0, 1)) {

                for ($i=0; $i < rand(1, 3); $i++) {                 
                    $user_id = User::opd()->get()->random()->id;
                    if (DB::table('institute_user')->where('user_id', $user_id)->doesntExist()) {
                        DB::table('institute_user')->insert([
                            'institute_id'  => $institute->id,
                            'user_id'       => $user_id,
                        ]);
                    }
                }
            }
        }
    }
        
}
