<?php

namespace Database\Seeders;

use App\Models\Institute;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Illuminate\Database\Seeder;

class InstituteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Institute::factory()
            ->count(15)
            ->state(new Sequence(
                fn ($sequence) => [
                    'operator_id' => User::where('role', 'bagianhukum')->get()->random()
                ],
            ))
            ->create();
    }
}
