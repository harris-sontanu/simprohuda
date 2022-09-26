<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Institute;
use App\Models\Legislation;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Sequence;

class LegislationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Legislation::factory()
            ->count(55)
            ->state(new Sequence(
                fn ($sequence) => [
                    'institute_id' => Institute::get()->random(),
                    'user_id'  => User::all()->random(),
                ],
            ))
            ->create();
    }
}
