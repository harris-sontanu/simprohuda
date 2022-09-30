<?php

namespace App\Http\Controllers\Legislation;

use App\Http\Controllers\Controller;
use App\Models\Legislation;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Carbon;

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

    protected function documentUpload($legislation, $request)
    {   
        $currentTime = Carbon::now()->timestamp;

        if ($request->hasFile('master'))
        {
            $file = $request->file('master');
    
            $documentStorage = $this->documentStorage($legislation, 'master');
            $file_name = $documentStorage['file_prefix_name'] . $currentTime . '.' . $file->getClientOriginalExtension();    
    
            $path = $file->storeAs($documentStorage['path'], $file_name, 'public');
            
            $legislation->documents()->create([
                'type'  => 'master',
                'path'  => $path,
                'name'  => $file_name,
                'title' => 'Draf Ranperda',
            ]);
        }

        $attachments = $request->attachments;
        if (!empty($attachments[0]['file']))
        {
            // Get the next order
            $currentOrder = $legislation->documents->where('type', 'attachment')->max('order');
            if (!empty($currentOrder)) {
                $i = $currentOrder + 1;
            } else {
                $i = 1;
            }

            foreach ($attachments as $attachment) {

                $documentStorage = $this->documentStorage($legislation, 'attachment', $i);    
                $file_name = $documentStorage['file_prefix_name'] . $currentTime . '.' . $attachment['file']->getClientOriginalExtension();     

                $path = $attachment['file']->storeAs($documentStorage['path'], $file_name, 'public');
                
                $legislation->documents()->create([
                    'type'  => 'attachment',
                    'order' => $i,
                    'path'  => $path,
                    'name'  => $file_name,
                    'title'  => $attachment['title'],
                ]);

                $i++;
            }
        }

        if ($request->hasFile('surat_pengantar'))
        {
            $file = $request->file('surat_pengantar');
    
            $documentStorage = $this->documentStorage($legislation, 'requirement');
            $file_name = $documentStorage['file_prefix_name'] . $currentTime . '.' . $file->getClientOriginalExtension();    
    
            $path = $file->storeAs($documentStorage['path'], $file_name, 'public');
            
            $legislation->documents()->create([
                'type'  => 'requirement',
                'order' => 1,
                'path'  => $path,
                'name'  => $file_name,
                'title' => 'Surat Pengantar',
            ]);
        }

        if ($request->hasFile('naskah_akademik'))
        {
            $file = $request->file('naskah_akademik');
    
            $documentStorage = $this->documentStorage($legislation, 'requirement', 2);
            $file_name = $documentStorage['file_prefix_name'] . $currentTime . '.' . $file->getClientOriginalExtension();    
    
            $path = $file->storeAs($documentStorage['path'], $file_name, 'public');
            
            $legislation->documents()->create([
                'type'  => 'requirement',
                'order' => 2,
                'path'  => $path,
                'name'  => $file_name,
                'title' => 'Naskah Akademik',
            ]);
        }

        if ($request->hasFile('notulensi_rapat'))
        {
            $file = $request->file('notulensi_rapat');
    
            $documentStorage = $this->documentStorage($legislation, 'requirement', 3);
            $file_name = $documentStorage['file_prefix_name'] . $currentTime . '.' . $file->getClientOriginalExtension();    
    
            $path = $file->storeAs($documentStorage['path'], $file_name, 'public');
            
            $legislation->documents()->create([
                'type'  => 'requirement',
                'order' => 3,
                'path'  => $path,
                'name'  => $file_name,
                'title' => 'Notulensi Rapat',
            ]);
        }
    }

    protected function removeDocument($documentPath)
    {
        if (Storage::disk('public')->exists($documentPath)) {
            Storage::disk('public')->delete($documentPath);
        }
    }
}
