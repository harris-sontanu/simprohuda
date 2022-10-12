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

        User::factory()->create([
            'name'  => 'Ib. Gede Dhiksita',
            'username' => 'gusdedhikshita',
            'email' => 'ibgd98@mail.ugm.ac.id',
            'password'  => Hash::make('HtrXjng8YNm8mfd'),
            'role'  => 'administrator',
        ]);

        User::factory()->create([
            'name'  => 'John Doe',
            'username' => 'adminBagHukum',
            'email' => 'bagian.hukum@mail.com',
            'password'  => Hash::make('admin123'),
            'role'  => 'bagianhukum',
        ]);

        User::factory()->create([
            'username' => 'adminOpd',
            'email' => 'perangkat.daerah@mail.com',
            'password'  => Hash::make('12345678'),
            'role'  => 'opd',
        ]);

        User::factory()
            ->count(2)
            ->create([
                'role'  => 'administrator'
            ]);

        User::factory()
            ->count(6)
            ->create([
                'role'  => 'bagianhukum'
            ]);

        User::factory()
            ->count(31)
            ->create([
                'role'  => 'opd'
            ]);
        }
}
