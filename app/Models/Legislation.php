<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Traits\HelperTrait;

class Legislation extends Model
{
    use HasFactory, SoftDeletes, HelperTrait;

    protected $casts  = [
        'posted_at'     => 'datetime',
        'repaired_at'   => 'datetime',
        'revised_at'    => 'datetime',
        'validated_at'  => 'datetime',
    ];
}
