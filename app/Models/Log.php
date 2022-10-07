<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Log extends Model
{
    use HasFactory;

    public $timestamps = ["created_at"];
    const UPDATED_AT = null;

    public function legislation()
    {
        return $this->belongsTo(Legislation::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
