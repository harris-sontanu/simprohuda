<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RequirementSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('requirements')->insert([
            'type_id'  => 1,
            'category' => 'master',
            'title'    => 'Draf Ranperda',
            'term'     => 'ranperda',
            'format'   => 'pdf,doc,docx',
            'order'    => 1, 
        ]);

        DB::table('requirements')->insert([
            'type_id'  => 1,
            'category' => 'requirement',
            'title'    => 'Surat Pengantar',
            'term'     => 'surat_pengantar',
            'desc'     => 'Surat Pengantar Kepala Perangkat Daerah pemrakarsa Ranperda.',
            'format'   => 'pdf,doc,docx',
            'order'    => 1, 
        ]);

        DB::table('requirements')->insert([
            'type_id'  => 1,
            'category' => 'requirement',
            'title'    => 'Naskah Akademik',
            'term'     => 'naskah_akademik',
            'desc'     => 'Naskah Akademik Ranperda yang sudah berpedoman dengan ketentuan Lampiran I UU 12 Tahun 2011 beserta perubahannya.',
            'format'   => 'pdf,doc,docx',
            'order'    => 2, 
        ]);

        DB::table('requirements')->insert([
            'type_id'  => 1,
            'category' => 'requirement',
            'title'    => 'Notulensi Rapat Pembahasan',
            'term'     => 'notulensi_rapat',
            'desc'     => 'Notulensi rapat pembahasan Ranperda yg diadakan oleh Perangkat Daerah.',
            'format'   => 'pdf,doc,docx',
            'order'    => 3, 
        ]);

        DB::table('requirements')->insert([
            'type_id'  => 1,
            'category' => 'requirement',
            'title'    => 'Peta Keterkaitan',
            'term'     => 'peta_keterkaitan',
            'desc'     => 'Peta Keterkaitan Rancangan Produk Hukum Daerah yang diajukan',
            'format'   => 'pdf,doc,docx',
            'order'    => 4, 
            'mandatory'=> 0,
        ]);

        DB::table('requirements')->insert([
            'type_id'  => 2,
            'category' => 'master',
            'title'    => 'Draf Ranperbup',
            'term'     => 'ranperbup',
            'format'   => 'pdf,doc,docx',
            'order'    => 1, 
        ]);

        DB::table('requirements')->insert([
            'type_id'  => 2,
            'category' => 'requirement',
            'title'    => 'Surat Pengantar',
            'term'     => 'surat_pengantar',
            'desc'     => 'Surat Pengantar Kepala Perangkat Daerah pemrakarsa Ranperbup.',
            'format'   => 'pdf,doc,docx',
            'order'    => 1, 
        ]);

        DB::table('requirements')->insert([
            'type_id'  => 2,
            'category' => 'requirement',
            'title'    => 'Kajian Akademik',
            'term'     => 'kajian_akademik',
            'desc'     => 'Kajian Akademik Ranperbup.',
            'format'   => 'pdf,doc,docx',
            'order'    => 2, 
        ]);

        DB::table('requirements')->insert([
            'type_id'  => 2,
            'category' => 'requirement',
            'title'    => 'Notulensi Rapat Pembahasan',
            'term'     => 'notulensi_rapat',
            'desc'     => 'Notulensi rapat pembahasan usulan Ranperbup yang diadakan oleh Perangkat Daerah.',
            'format'   => 'pdf,doc,docx',
            'order'    => 3, 
        ]);

        DB::table('requirements')->insert([
            'type_id'  => 2,
            'category' => 'requirement',
            'title'    => 'Peta Keterkaitan',
            'term'     => 'peta_keterkaitan',
            'desc'     => 'Peta Keterkaitan Rancangan Produk Hukum Daerah yang diajukan',
            'format'   => 'pdf,doc,docx',
            'order'    => 4, 
            'mandatory'=> 0,
        ]);

        DB::table('requirements')->insert([
            'type_id'  => 3,
            'category' => 'master',
            'title'    => 'Draf Rancangan SK',
            'term'     => 'rancangan_sk',
            'format'   => 'pdf,doc,docx',
            'order'    => 1, 
        ]);

        DB::table('requirements')->insert([
            'type_id'  => 3,
            'category' => 'requirement',
            'title'    => 'Surat Pengantar',
            'term'     => 'surat_pengantar',
            'format'   => 'pdf,doc,docx',
            'order'    => 1, 
        ]);

        DB::table('requirements')->insert([
            'type_id'  => 3,
            'category' => 'requirement',
            'title'    => 'Resume Keputusan Bupati',
            'term'     => 'resume',
            'format'   => 'pdf,doc,docx',
            'order'    => 2, 
        ]);

        DB::table('requirements')->insert([
            'type_id'  => 3,
            'category' => 'requirement',
            'title'    => 'DPA/RKA-KL',
            'term'     => 'dpa_rka_kl',
            'format'   => 'pdf,doc,docx',
            'order'    => 3, 
            'mandatory'=> 0,
        ]);

        DB::table('requirements')->insert([
            'type_id'  => 3,
            'category' => 'requirement',
            'title'    => 'Notulensi Rapat Pembahasan',
            'term'     => 'notulensi_rapat',
            'desc'     => 'Notulensi rapat pembahasan usulan SK terakhir.',
            'format'   => 'pdf,doc,docx',
            'order'    => 4, 
        ]);
    }
}
