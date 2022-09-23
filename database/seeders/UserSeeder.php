<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::factory()->create([
            'name'  => 'Harris Sontanu',
            'username' => 'harris',
            'email' => 'harris.sontanu@gmail.com',
            'password'  => Hash::make('jokotole'),
            'role'  => 'administrator',
        ]);

        User::factory()
            ->count(12)
            ->create();
    }
}
