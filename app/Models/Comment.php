<?php

namespace App\Models;

use App\Models\Traits\HelperTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory, HelperTrait;

    public $timestamps = ["created_at"];
    const UPDATED_AT = null;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'legislation_id',
        'sender_id',
        'to_id',
        'comment',
        'read',
        'year',
    ];


    public function legislation()
    {
        return $this->belongsTo(Legislation::class);
    }

    public function sender()
    {
        return $this->belongsTo(User::class);
    }

    public function to()
    {
        return $this->belongsTo(User::class);
    }

    public function scopeUnread($query)
    {
        return $query->where('read', 0);
    }
}
