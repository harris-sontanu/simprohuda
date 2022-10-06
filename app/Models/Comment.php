<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    public function legislation()
    {
        return $this->belongsTo(Legislation::class);
    }

    public function author()
    {
        return $this->belongsTo(User::class);
    }
}
