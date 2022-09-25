<?php

namespace App\Http\Controllers\Legislation;

use App\Http\Controllers\Controller;
use App\Models\Legislation;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class LegislationController extends Controller
{
    protected $type = [
        'perda'  => 'Peraturan Daerah',
        'perbup' => 'Peraturan Bupati',
        'sk'     => 'Surat Keputusan'
    ];

    protected function nextRegNumber($type, $year) 
    {
        $number = Legislation::where('type', $type)
                    ->whereYear('created_at', $year)->max('reg_number');

        return $number + 1;
    }
    
    protected function documentStorage($legislation, $documentType, $sequence = 1)
    {   
        $paddedNextRegNumber = Str::padLeft($this->nextRegNumber($legislation->type, $legislation->created_year), 4, '0');
        $storage_path = 'produk-hukum/' . $legislation->type . '/' . $legislation->created_year . '/' . $paddedNextRegNumber;

        $prefix = 'draf';
        if ($documentType === 'requirement') {
            $prefix = 'req' . Str::padLeft($sequence, 2, '0');
        } else if ($documentType === 'attachment') {
            $prefix = 'lamp' . Str::padLeft($sequence, 2, '0');
        }

        $file_prefix_name = $legislation->created_year . $legislation->type . $legislation->reg_number . $prefix;

        return [
            'path' => $storage_path, 
            'file_prefix_name' => $file_prefix_name
        ];
    }

    protected function removeDocument($documentPath)
    {
        if (Storage::disk('public')->exists($documentPath)) {
            Storage::disk('public')->delete($documentPath);
        }
    }
}
