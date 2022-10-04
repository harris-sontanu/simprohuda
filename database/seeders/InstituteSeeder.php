<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class InstituteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $name = 'Inspektorat';
        DB::table('institutes')->insert([
            'name'      => $name,
            'slug'      => Str::slug($name),
            'category'  => 'lembaga teknis daerah',
            'operator_id'   => (rand(0, 1) === 0) ? null : User::where('role', 'opd')->get()->random()->id,
        ]);

        $name = 'Badan Kepegawaian dan Pengembangan Sumber Daya Manusia';
        DB::table('institutes')->insert([
            'name'      => $name,
            'slug'      => Str::slug($name),
            'category'  => 'lembaga teknis daerah',
            'operator_id'   => (rand(0, 1) === 0) ? null : User::where('role', 'opd')->get()->random()->id,
        ]);

        $name = 'Badan Pengelolaan Keuangan dan Pendapatan Daerah';
        DB::table('institutes')->insert([
            'name'      => $name,
            'slug'      => Str::slug($name),
            'category'  => 'lembaga teknis daerah',
            'operator_id'   => (rand(0, 1) === 0) ? null : User::where('role', 'opd')->get()->random()->id,
        ]);

        $name = 'Badan Perencanaan, Penelitian dan Pengembangan';
        DB::table('institutes')->insert([
            'name'      => $name,
            'slug'      => Str::slug($name),
            'category'  => 'lembaga teknis daerah',
            'operator_id'   => (rand(0, 1) === 0) ? null : User::where('role', 'opd')->get()->random()->id,
        ]);

        $name = 'Badan Penanggulangan Bencana Daerah';
        DB::table('institutes')->insert([
            'name'      => $name,
            'slug'      => Str::slug($name),
            'category'  => 'lembaga teknis daerah',
            'operator_id'   => (rand(0, 1) === 0) ? null : User::where('role', 'opd')->get()->random()->id,
        ]);

        $name = 'Badan Kesatuan Bangsa dan Politik';
        DB::table('institutes')->insert([
            'name'      => $name,
            'slug'      => Str::slug($name),
            'category'  => 'lembaga teknis daerah',
            'operator_id'   => (rand(0, 1) === 0) ? null : User::where('role', 'opd')->get()->random()->id,
        ]);

        $name = 'Bagian Pemerintahan dan Kesejahteraan';
        DB::table('institutes')->insert([
            'name'      => $name,
            'slug'      => Str::slug($name),
            'category'  => 'sekretariat daerah',
            'operator_id'   => (rand(0, 1) === 0) ? null : User::where('role', 'opd')->get()->random()->id,
        ]);

        $name = 'Bagian Hukum';
        DB::table('institutes')->insert([
            'name'      => $name,
            'slug'      => Str::slug($name),
            'category'  => 'sekretariat daerah',
            'operator_id'   => (rand(0, 1) === 0) ? null : User::where('role', 'opd')->get()->random()->id,
        ]);

        $name = 'Bagian Administrasi Pembangunan, Perekonomian, dan Sumber Daya Alam';
        DB::table('institutes')->insert([
            'name'      => $name,
            'slug'      => Str::slug($name),
            'category'  => 'sekretariat daerah',
            'operator_id'   => (rand(0, 1) === 0) ? null : User::where('role', 'opd')->get()->random()->id,
        ]);

        $name = 'Bagian Pengadaan Barang/Jasa';
        DB::table('institutes')->insert([
            'name'      => $name,
            'slug'      => Str::slug($name),
            'category'  => 'sekretariat daerah',
            'operator_id'   => (rand(0, 1) === 0) ? null : User::where('role', 'opd')->get()->random()->id,
        ]);

        $name = 'Bagian Umum';
        DB::table('institutes')->insert([
            'name'      => $name,
            'slug'      => Str::slug($name),
            'category'  => 'sekretariat daerah',
            'operator_id'   => (rand(0, 1) === 0) ? null : User::where('role', 'opd')->get()->random()->id,
        ]);

        $name = 'Bagian Protokol dan Komunikasi Pimpinan';
        DB::table('institutes')->insert([
            'name'      => $name,
            'slug'      => Str::slug($name),
            'category'  => 'sekretariat daerah',
            'operator_id'   => (rand(0, 1) === 0) ? null : User::where('role', 'opd')->get()->random()->id,
        ]);

        $name = 'Bagian Organisasi';
        DB::table('institutes')->insert([
            'name'      => $name,
            'slug'      => Str::slug($name),
            'category'  => 'sekretariat daerah',
            'operator_id'   => (rand(0, 1) === 0) ? null : User::where('role', 'opd')->get()->random()->id,
        ]);

        $name = 'Dinas Kesehatan';
        DB::table('institutes')->insert([
            'name'      => $name,
            'slug'      => Str::slug($name),
            'category'  => 'dinas',
            'operator_id'   => (rand(0, 1) === 0) ? null : User::where('role', 'opd')->get()->random()->id,
        ]);
        
        $name = 'Dinas Sosial, Pemberdayaan Perempuan dan Perlindungan Anak';
        DB::table('institutes')->insert([
            'name'      => $name,
            'slug'      => Str::slug($name),
            'category'  => 'dinas',
            'operator_id'   => (rand(0, 1) === 0) ? null : User::where('role', 'opd')->get()->random()->id,
        ]);

        $name = 'Dinas Pekerjaan Umum, Penataan Ruang, Perumahan dan Kawasan Permukiman';
        DB::table('institutes')->insert([
            'name'      => $name,
            'slug'      => Str::slug($name),
            'category'  => 'dinas',
            'operator_id'   => (rand(0, 1) === 0) ? null : User::where('role', 'opd')->get()->random()->id,
        ]);

        $name = 'Dinas Pendidikan, Kepemudaan, dan Olahraga';
        DB::table('institutes')->insert([
            'name'      => $name,
            'slug'      => Str::slug($name),
            'category'  => 'dinas',
            'operator_id'   => (rand(0, 1) === 0) ? null : User::where('role', 'opd')->get()->random()->id,
        ]);

        $name = 'Dinas Pemberdayaan Masyarakat dan Desa, Pengendalian Penduduk dan Keluarga Berencana';
        DB::table('institutes')->insert([
            'name'      => $name,
            'slug'      => Str::slug($name),
            'category'  => 'dinas',
            'operator_id'   => (rand(0, 1) === 0) ? null : User::where('role', 'opd')->get()->random()->id,
        ]);

        $name = 'Dinas Kependudukan dan Pencatatan Sipil';
        DB::table('institutes')->insert([
            'name'      => $name,
            'slug'      => Str::slug($name),
            'category'  => 'dinas',
            'operator_id'   => (rand(0, 1) === 0) ? null : User::where('role', 'opd')->get()->random()->id,
        ]);

        $name = 'Dinas Kearsipan dan Perpustakaan';
        DB::table('institutes')->insert([
            'name'      => $name,
            'slug'      => Str::slug($name),
            'category'  => 'dinas',
            'operator_id'   => (rand(0, 1) === 0) ? null : User::where('role', 'opd')->get()->random()->id,
        ]);

        $name = 'Dinas Kebudayaan';
        DB::table('institutes')->insert([
            'name'      => $name,
            'slug'      => Str::slug($name),
            'category'  => 'dinas',
            'operator_id'   => (rand(0, 1) === 0) ? null : User::where('role', 'opd')->get()->random()->id,
        ]);

        $name = 'Dinas Komunikasi dan Informatika';
        DB::table('institutes')->insert([
            'name'      => $name,
            'slug'      => Str::slug($name),
            'category'  => 'dinas',
            'operator_id'   => (rand(0, 1) === 0) ? null : User::where('role', 'opd')->get()->random()->id,
        ]);

        $name = 'Dinas Koperasi, Usaha Kecil dan Menengah, Perindustrian dan Perdagangan';
        DB::table('institutes')->insert([
            'name'      => $name,
            'slug'      => Str::slug($name),
            'category'  => 'dinas',
            'operator_id'   => (rand(0, 1) === 0) ? null : User::where('role', 'opd')->get()->random()->id,
        ]);

        $name = 'Dinas Lingkungan Hidup dan Pertanahan';
        DB::table('institutes')->insert([
            'name'      => $name,
            'slug'      => Str::slug($name),
            'category'  => 'dinas',
            'operator_id'   => (rand(0, 1) === 0) ? null : User::where('role', 'opd')->get()->random()->id,
        ]);

        $name = 'Dinas Ketahanan Pangan dan Perikanan';
        DB::table('institutes')->insert([
            'name'      => $name,
            'slug'      => Str::slug($name),
            'category'  => 'dinas',
            'operator_id'   => (rand(0, 1) === 0) ? null : User::where('role', 'opd')->get()->random()->id,
        ]);

        $name = 'Dinas Penanaman Modal dan Pelayanan Terpadu Satu Pintu';
        DB::table('institutes')->insert([
            'name'      => $name,
            'slug'      => Str::slug($name),
            'category'  => 'dinas',
            'operator_id'   => (rand(0, 1) === 0) ? null : User::where('role', 'opd')->get()->random()->id,
        ]);

        $name = 'Dinas Perhubungan';
        DB::table('institutes')->insert([
            'name'      => $name,
            'slug'      => Str::slug($name),
            'category'  => 'dinas',
            'operator_id'   => (rand(0, 1) === 0) ? null : User::where('role', 'opd')->get()->random()->id,
        ]);

        $name = 'Dinas Ketenagakerjaan';
        DB::table('institutes')->insert([
            'name'      => $name,
            'slug'      => Str::slug($name),
            'category'  => 'dinas',
            'operator_id'   => (rand(0, 1) === 0) ? null : User::where('role', 'opd')->get()->random()->id,
        ]);

        $name = 'Dinas Pariwisata';
        DB::table('institutes')->insert([
            'name'      => $name,
            'slug'      => Str::slug($name),
            'category'  => 'dinas',
            'operator_id'   => (rand(0, 1) === 0) ? null : User::where('role', 'opd')->get()->random()->id,
        ]);

        $name = 'Dinas Pertanian';
        DB::table('institutes')->insert([
            'name'      => $name,
            'slug'      => Str::slug($name),
            'category'  => 'dinas',
            'operator_id'   => (rand(0, 1) === 0) ? null : User::where('role', 'opd')->get()->random()->id,
        ]);

        $name = 'Satuan Polisi Pamong Praja dan Pemadam Kebakaran';
        DB::table('institutes')->insert([
            'name'      => $name,
            'slug'      => Str::slug($name),
            'category'  => 'lembaga teknis daerah',
            'operator_id'   => (rand(0, 1) === 0) ? null : User::where('role', 'opd')->get()->random()->id,
        ]);
    }
}
