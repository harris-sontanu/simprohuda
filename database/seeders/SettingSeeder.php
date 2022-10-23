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
            'key'       => 'appName',
            'value'     => 'SIMPROHUDA',
        ]);

        DB::table('settings')->insert([
            'key'       => 'appDesc',
            'value'     => 'Sistem Pembentukan Produk Hukum Daerah Kabupaten Klungkung',
        ]);

        DB::table('settings')->insert([
            'key'       => 'appLogo',
            'value'     => asset('assets/images/logo_icon.svg'),
        ]);

        DB::table('settings')->insert([
            'key'       => 'appUrl',
            'value'     => url()->current(),
        ]);

        DB::table('settings')->insert([
            'key'       => 'company',
            'value'     => 'Bagian Hukum Kabupaten Klungkung',
        ]);

        DB::table('settings')->insert([
            'key'       => 'companyUrl',
            'value'     => 'https://jdih.klungkungkab.go.id',
        ]);
    }
}
