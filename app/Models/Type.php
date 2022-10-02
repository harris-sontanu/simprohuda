<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Type extends Model
{
    use HasFactory;

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    public function legislations()
    {
        return $this->hasMany(Legislation::class);
    }

    public function requirements()
    {
        return $this->hasMany(Requirements::class);
    }
}
