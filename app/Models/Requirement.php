<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Requirement extends Model
{
    use HasFactory;

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    public function type()
    {
        return $this->belongsTo(Type::class);
    }

    public function documents()
    {
        return $this->hasMany(Document::class);
    }

    public function scopeMaster($query, $type_id)
    {
        return $query->where('type_id', $type_id)
                    ->where('category', 'master');
    }

    public function scopeRequirements($query, $type_id)
    {
        return $query->where('type_id', $type_id)
                    ->where('category', 'requirement')
                    ->orderBy('order');
    }
}
