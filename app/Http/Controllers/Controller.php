<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Storage;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    protected $pageTitle = ' - JDIH Admin';
    protected $limit = 25;

    protected function removeImage($image)
    {
        if (!empty($image)) {
            $ext            = substr(strrchr($image, '.'), 1);
            $thumbnail      = str_replace(".{$ext}", "_thumb.{$ext}", $image);

            if (Storage::disk('public')->exists($image)) {
                Storage::disk('public')->delete($image);
            }

            if (Storage::disk('public')->exists($thumbnail)) {
                Storage::disk('public')->delete($thumbnail);
            }
        }
    }

    protected function removeDocument($document)
    {
        if (Storage::disk('public')->exists($document)) {
            Storage::disk('public')->delete($document);
        }
    }
}
