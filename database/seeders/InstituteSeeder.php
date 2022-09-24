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
                    'operator_id' => (rand(0, 1) === 0) ? null : User::where('role', 'opd')->get()->random()
                ],
            ))
            ->create();
    }
}
