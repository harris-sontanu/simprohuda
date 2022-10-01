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
            'term'     => 'master',
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
    }
}
