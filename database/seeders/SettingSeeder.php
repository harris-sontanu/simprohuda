<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('settings')->insert([
            'name'      => 'appName',
            'value'     => 'SIMPROHUDA',
        ]);

        DB::table('settings')->insert([
            'name'      => 'appDesc',
            'value'     => 'Sistem Pembentukan Produk Hukum Daerah Kabupaten Klungkung',
        ]);

        DB::table('settings')->insert([
            'name'      => 'appLogo',
            'value'     => asset('assets/images/logo_icon.svg'),
        ]);

        DB::table('settings')->insert([
            'name'      => 'appUrl',
            'value'     => url()->current(),
        ]);

        DB::table('settings')->insert([
            'name'      => 'company',
            'value'     => 'Bagian Hukum Kabupaten Klungkung',
        ]);

        DB::table('settings')->insert([
            'name'      => 'companyUrl',
            'value'     => 'https://jdih.klungkungkab.go.id',
        ]);
    }
}
