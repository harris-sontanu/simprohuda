<?php

namespace App\Http\Controllers\Legislation;

use App\Http\Controllers\Controller;
use App\Models\Legislation;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class LegislationController extends Controller
{
    protected function nextRegNumber($type_id, $year) 
    {
        $number = Legislation::where('type_id', $type_id)
                    ->whereYear('created_at', $year)->max('reg_number');

        return $number + 1;
    }
    
    protected function documentStorage($legislation, $documentType, $sequence = 1)
    {   
        $storage_path = 'produk-hukum/' . $legislation->type->slug . '/' . $legislation->created_year . '/' . $legislation->reg_number;

        $prepend = 'draf';
        if ($documentType === 'requirement') {
            $prepend = 'syrt' . Str::padLeft($sequence, 2, '0');
        } else if ($documentType === 'attachment') {
            $prepend = 'lamp' . Str::padLeft($sequence, 2, '0');
        }

        $file_prefix_name = $legislation->created_year . $legislation->type->slug . $legislation->reg_number . $prepend;

        return [
            'path' => $storage_path, 
            'file_prefix_name' => $file_prefix_name
        ];
    }

    protected function documentUpload($legislation, $request)
    {   
        $currentTime = '_' . now()->timestamp;

        // Upload master document
        $master = $legislation->type->requirements->where('category', 'master')->first();
        if ($request->hasFile($master->term))
        {
            $file = $request->file($master->term);
    
            $documentStorage = $this->documentStorage($legislation, $master->term);
            $file_name = $documentStorage['file_prefix_name'] . $currentTime . '.' . $file->getClientOriginalExtension();    
    
            $path = $file->storeAs($documentStorage['path'], $file_name, 'public');
            
            $legislation->documents()->create([
                'requirement_id'    => $master->id,
                'path'  => $path,
                'name'  => $file_name,
                'posted_at' => ($request->has('post')) ? now() : null,
            ]);
        }

        // Upload all requirement documents
        $requirements = $legislation->type->requirements
                            ->where('category', 'requirement')
                            ->sortBy('order');

        $requirements->values()->all();

        foreach ($requirements as $requirement) {
            if ($request->hasFile($requirement->term))
            {
                $file = $request->file($requirement->term);
        
                $documentStorage = $this->documentStorage($legislation, 'requirement', $requirement->order);
                $file_name = $documentStorage['file_prefix_name'] . $currentTime . '.' . $file->getClientOriginalExtension();    
        
                $path = $file->storeAs($documentStorage['path'], $file_name, 'public');
                
                $legislation->documents()->create([
                    'requirement_id'    => $requirement->id,
                    'path'  => $path,
                    'name'  => $file_name,
                    'posted_at' => ($request->has('post')) ? now() : null,
                ]);
            }
        }

    }

    protected function removeDocument($documentPath)
    {
        if (Storage::disk('public')->exists($documentPath)) {
            Storage::disk('public')->delete($documentPath);
        }
    }
}
