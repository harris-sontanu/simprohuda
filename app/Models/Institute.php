<?php

namespace App\Models;

use App\Models\Traits\HelperTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Support\Str;

class Institute extends Model
{
    use HasFactory, HelperTrait;

    public function operator()
    {
        return $this->belongsTo(User::class);
    }

    protected function category(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => Str::title($value),
        );
    }

    public function scopeSorted($query, $request = [])
    {
        if (isset($request['order'])) {
            return $query->orderBy($request['order'], $request['sort']);
        } else {
            return $query->orderBy('name', 'asc');
        }
    }

    public function scopeSearch($query, $request)
    {
        if (isset($request['search']) AND $search = $request['search']) {
            $query->where(function($q) use ($search) {
                $q->where('name', 'LIKE', '%' . $search . '%')
                ->orWhere('abbrev', 'LIKE', '%' . $search . '%')
                ->orWhere('category', 'LIKE', '%' . $search . '%')
                ->orWhere('desc', 'LIKE', '%' . $search . '%');
            });
        }
    }
}
