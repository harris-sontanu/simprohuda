<?php

namespace App\Http\Controllers\Legislation;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LegislationController extends Controller
{
    protected $type = [
        'perda'  => 'Peraturan Daerah',
        'perbup' => 'Peraturan Bupati',
        'sk'     => 'Surat Keputusan'
    ];
    
}
