<?php

namespace Database\Seeders;

use App\Models\Institute;
use App\Models\User;
use Illuminate\Database\Seeder;
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
        Institute::factory()->create([
            'name'      => $name,
            'slug'      => Str::slug($name),
            'category'  => 'lembaga teknis daerah',
            'corrector_id'   => User::where('role', 'bagianhukum')->get()->random()->id,
        ]);

        $name = 'Badan Kepegawaian dan Pengembangan Sumber Daya Manusia';
        Institute::factory()->create([
            'name'      => $name,
            'slug'      => Str::slug($name),
            'abbrev'    => 'BKPSDM',
            'category'  => 'lembaga teknis daerah',
            'corrector_id'   => User::where('role', 'bagianhukum')->get()->random()->id,
        ]);

        $name = 'Badan Pengelolaan Keuangan dan Pendapatan Daerah';
        Institute::factory()->create([
            'name'      => $name,
            'slug'      => Str::slug($name),
            'abbrev'    => 'BPKPD',
            'category'  => 'lembaga teknis daerah',
            'corrector_id'   => User::where('role', 'bagianhukum')->get()->random()->id,
        ]);

        $name = 'Badan Perencanaan, Penelitian dan Pengembangan';
        Institute::factory()->create([
            'name'      => $name,
            'slug'      => Str::slug($name),
            'abbrev'    => 'BPPP',
            'category'  => 'lembaga teknis daerah',
            'corrector_id'   => User::where('role', 'bagianhukum')->get()->random()->id,
        ]);

        $name = 'Badan Penanggulangan Bencana Daerah';
        Institute::factory()->create([
            'name'      => $name,
            'slug'      => Str::slug($name),
            'abbrev'    => 'BPBD',
            'category'  => 'lembaga teknis daerah',
            'corrector_id'   => User::where('role', 'bagianhukum')->get()->random()->id,
        ]);

        $name = 'Badan Kesatuan Bangsa dan Politik';
        Institute::factory()->create([
            'name'      => $name,
            'slug'      => Str::slug($name),
            'abbrev'    => 'BKBP',
            'category'  => 'lembaga teknis daerah',
            'corrector_id'   => User::where('role', 'bagianhukum')->get()->random()->id,
        ]);

        $name = 'Bagian Pemerintahan dan Kesejahteraan';
        Institute::factory()->create([
            'name'      => $name,
            'slug'      => Str::slug($name),
            'abbrev'    => 'BPK',
            'category'  => 'sekretariat daerah',
            'corrector_id'   => User::where('role', 'bagianhukum')->get()->random()->id,
        ]);

        $name = 'Bagian Hukum';
        Institute::factory()->create([
            'name'      => $name,
            'slug'      => Str::slug($name),
            'abbrev'    => 'BH',
            'category'  => 'sekretariat daerah',
            'corrector_id'   => User::where('role', 'bagianhukum')->get()->random()->id,
        ]);

        $name = 'Bagian Administrasi Pembangunan, Perekonomian, dan Sumber Daya Alam';
        Institute::factory()->create([
            'name'      => $name,
            'slug'      => Str::slug($name),
            'abbrev'    => 'BAPPSDA',
            'category'  => 'sekretariat daerah',
            'corrector_id'   => User::where('role', 'bagianhukum')->get()->random()->id,
        ]);

        $name = 'Bagian Pengadaan Barang/Jasa';
        Institute::factory()->create([
            'name'      => $name,
            'slug'      => Str::slug($name),
            'abbrev'    => 'BPBJ',
            'category'  => 'sekretariat daerah',
            'corrector_id'   => User::where('role', 'bagianhukum')->get()->random()->id,
        ]);

        $name = 'Bagian Umum';
        Institute::factory()->create([
            'name'      => $name,
            'slug'      => Str::slug($name),
            'abbrev'    => 'BU',
            'category'  => 'sekretariat daerah',
            'corrector_id'   => User::where('role', 'bagianhukum')->get()->random()->id,
        ]);

        $name = 'Bagian Protokol dan Komunikasi Pimpinan';
        Institute::factory()->create([
            'name'      => $name,
            'slug'      => Str::slug($name),
            'abbrev'    => 'BPKP',
            'category'  => 'sekretariat daerah',
            'corrector_id'   => User::where('role', 'bagianhukum')->get()->random()->id,
        ]);

        $name = 'Bagian Organisasi';
        Institute::factory()->create([
            'name'      => $name,
            'slug'      => Str::slug($name),
            'abbrev'    => 'BO',
            'category'  => 'sekretariat daerah',
            'corrector_id'   => User::where('role', 'bagianhukum')->get()->random()->id,
        ]);

        $name = 'Dinas Kesehatan';
        Institute::factory()->create([
            'name'      => $name,
            'slug'      => Str::slug($name),
            'category'  => 'dinas',
            'corrector_id'   => User::where('role', 'bagianhukum')->get()->random()->id,
        ]);
        
        $name = 'Dinas Sosial, Pemberdayaan Perempuan dan Perlindungan Anak';
        Institute::factory()->create([
            'name'      => $name,
            'slug'      => Str::slug($name),
            'category'  => 'dinas',
            'corrector_id'   => User::where('role', 'bagianhukum')->get()->random()->id,
        ]);

        $name = 'Dinas Pekerjaan Umum, Penataan Ruang, Perumahan dan Kawasan Permukiman';
        Institute::factory()->create([
            'name'      => $name,
            'slug'      => Str::slug($name),
            'category'  => 'dinas',
            'corrector_id'   => User::where('role', 'bagianhukum')->get()->random()->id,
        ]);

        $name = 'Dinas Pendidikan, Kepemudaan, dan Olahraga';
        Institute::factory()->create([
            'name'      => $name,
            'slug'      => Str::slug($name),
            'category'  => 'dinas',
            'corrector_id'   => User::where('role', 'bagianhukum')->get()->random()->id,
        ]);

        $name = 'Dinas Pemberdayaan Masyarakat dan Desa, Pengendalian Penduduk dan Keluarga Berencana';
        Institute::factory()->create([
            'name'      => $name,
            'slug'      => Str::slug($name),
            'category'  => 'dinas',
            'corrector_id'   => User::where('role', 'bagianhukum')->get()->random()->id,
        ]);

        $name = 'Dinas Kependudukan dan Pencatatan Sipil';
        Institute::factory()->create([
            'name'      => $name,
            'slug'      => Str::slug($name),
            'category'  => 'dinas',
            'corrector_id'   => User::where('role', 'bagianhukum')->get()->random()->id,
        ]);

        $name = 'Dinas Kearsipan dan Perpustakaan';
        Institute::factory()->create([
            'name'      => $name,
            'slug'      => Str::slug($name),
            'category'  => 'dinas',
            'corrector_id'   => User::where('role', 'bagianhukum')->get()->random()->id,
        ]);

        $name = 'Dinas Kebudayaan';
        Institute::factory()->create([
            'name'      => $name,
            'slug'      => Str::slug($name),
            'category'  => 'dinas',
            'corrector_id'   => User::where('role', 'bagianhukum')->get()->random()->id,
        ]);

        $name = 'Dinas Komunikasi dan Informatika';
        Institute::factory()->create([
            'name'      => $name,
            'slug'      => Str::slug($name),
            'category'  => 'dinas',
            'corrector_id'   => User::where('role', 'bagianhukum')->get()->random()->id,
        ]);

        $name = 'Dinas Koperasi, Usaha Kecil dan Menengah, Perindustrian dan Perdagangan';
        Institute::factory()->create([
            'name'      => $name,
            'slug'      => Str::slug($name),
            'category'  => 'dinas',
            'corrector_id'   => User::where('role', 'bagianhukum')->get()->random()->id,
        ]);

        $name = 'Dinas Lingkungan Hidup dan Pertanahan';
        Institute::factory()->create([
            'name'      => $name,
            'slug'      => Str::slug($name),
            'category'  => 'dinas',
            'corrector_id'   => User::where('role', 'bagianhukum')->get()->random()->id,
        ]);

        $name = 'Dinas Ketahanan Pangan dan Perikanan';
        Institute::factory()->create([
            'name'      => $name,
            'slug'      => Str::slug($name),
            'category'  => 'dinas',
            'corrector_id'   => User::where('role', 'bagianhukum')->get()->random()->id,
        ]);

        $name = 'Dinas Penanaman Modal dan Pelayanan Terpadu Satu Pintu';
        Institute::factory()->create([
            'name'      => $name,
            'slug'      => Str::slug($name),
            'category'  => 'dinas',
            'corrector_id'   => User::where('role', 'bagianhukum')->get()->random()->id,
        ]);

        $name = 'Dinas Perhubungan';
        Institute::factory()->create([
            'name'      => $name,
            'slug'      => Str::slug($name),
            'category'  => 'dinas',
            'corrector_id'   => User::where('role', 'bagianhukum')->get()->random()->id,
        ]);

        $name = 'Dinas Ketenagakerjaan';
        Institute::factory()->create([
            'name'      => $name,
            'slug'      => Str::slug($name),
            'category'  => 'dinas',
            'corrector_id'   => User::where('role', 'bagianhukum')->get()->random()->id,
        ]);

        $name = 'Dinas Pariwisata';
        Institute::factory()->create([
            'name'      => $name,
            'slug'      => Str::slug($name),
            'category'  => 'dinas',
            'corrector_id'   => User::where('role', 'bagianhukum')->get()->random()->id,
        ]);

        $name = 'Dinas Pertanian';
        Institute::factory()->create([
            'name'      => $name,
            'slug'      => Str::slug($name),
            'category'  => 'dinas',
            'corrector_id'   => User::where('role', 'bagianhukum')->get()->random()->id,
        ]);

        $name = 'Satuan Polisi Pamong Praja dan Pemadam Kebakaran';
        Institute::factory()->create([
            'name'      => $name,
            'slug'      => Str::slug($name),
            'category'  => 'lembaga teknis daerah',
            'corrector_id'   => User::where('role', 'bagianhukum')->get()->random()->id,
        ]);
    }
}
