<?php

namespace App\Models;

use App\Models\Traits\HelperTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory, HelperTrait;

    public function legislation()
    {
        return $this->belongsTo(Legislation::class);
    }

    public function author()
    {
        return $this->belongsTo(User::class);
    }
}
