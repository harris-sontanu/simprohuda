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

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'slug',
        'abbrev',
        'category',
        'code',
        'desc',
        'sort',
        'corrector_id',
    ];

    public function corrector()
    {
        return $this->belongsTo(User::class);
    }

    public function users()
    {
        return $this->belongsToMany(User::class);
    }
    
    public function legislations()
    {
        return $this->hasMany(Legislation::class);
    }

    protected function category(): Attribute
    {
        $categories = [
            'bagian' => 'Bagian',
            'sekretariat dprd' => 'Sekretariat DPRD',
            'dinas' => 'Dinas',
            'badan' => 'Badan',
            'kecamatan' => 'Kecamatan',
            'kelurahan' => 'Kelurahan',
        ];

        return Attribute::make(
            get: fn ($value) => $categories[$value],
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
