<?php

namespace App\Models;

use App\Models\Traits\HelperTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory, HelperTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'legislation_id',
        'author_id',
        'comment',
        'read',
        'year',
    ];


    public function legislation()
    {
        return $this->belongsTo(Legislation::class);
    }

    public function author()
    {
        return $this->belongsTo(User::class);
    }
}
