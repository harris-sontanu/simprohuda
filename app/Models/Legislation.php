<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Traits\HelperTrait;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Support\Str;

class Legislation extends Model
{
    use HasFactory, SoftDeletes, HelperTrait;

    protected $casts  = [
        'posted_at'     => 'datetime',
        'repaired_at'   => 'datetime',
        'revised_at'    => 'datetime',
        'validated_at'  => 'datetime',
    ];

    protected $status;

    public function institute()
    {
        return $this->belongsTo(Institute::class);
    }

    public function scopeDraft($query)
    {
        return $query->whereNull(['posted_at', 'repaired_at', 'revised_at', 'validated_at']);
    }
    
    public function scopePosted($query)
    {
        return $query->whereNotNull('posted_at')
                    ->whereNull(['repaired_at', 'revised_at', 'validated_at']);
    }

    public function scopeRepaired($query)
    {
        return $query->whereNotNull('repaired_at')
                    ->whereNull(['revised_at', 'validated_at']);
    }

    public function scopeRevised($query)
    {
        return $query->whereNotNull('revised_at')
                    ->whereNull('validated_at');
    }

    public function scopeValidated($query)
    {
        return $query->whereNotNull('validated_at');
    }

    public function status()
    {
        if (empty($this->posted_at) AND empty($this->repaired_at) AND empty($this->revised_at) AND empty($this->validated_at)) {
            $status = 'draft';
        } else if (!empty($this->posted_at) AND empty($this->repaired_at) AND empty($this->revised_at) AND empty($this->validated_at)) {
            $status = 'posted';
        } else if (!empty($this->posted_at) AND !empty($this->repaired_at) AND empty($this->revised_at) AND empty($this->validated_at)) {
            $status = 'repaired';
        } else if (!empty($this->posted_at) AND !empty($this->repaired_at) AND !empty($this->revised_at) AND empty($this->validated_at)) {
            $status = 'revised';
        } else if (!empty($this->posted_at) AND !empty($this->repaired_at) AND !empty($this->revised_at) AND !empty($this->validated_at)) {
            $status = 'validated';
        }

        return $status;
    }

    public function statusBadge(): Attribute
    {
        if ($this->status() == 'draft') {
            $statusBadge = '<span class="badge badge-pill badge-secondary">Draf</span>';
        } else if ($this->status() == 'posted') {
            $statusBadge = '<span class="badge badge-pill badge-primary">Aktif</span>';
        } else if ($this->status() == 'repaired') {
            $statusBadge = '<span class="badge badge-pill badge-warning">Perbaikan</span>';
        } else if ($this->status() == 'revised') {
            $statusBadge = '<span class="badge badge-pill badge-purple">Revisi</span>';
        } else if ($this->status() == 'validated') {
            $statusBadge = '<span class="badge badge-pill badge-success">Valid</span>';
        }

        return Attribute::make(
            get: fn ($value) => $statusBadge
        );
    }

    public function regNumber(): Attribute
    {           
        return Attribute::make(
            get: fn ($value) => Str::padLeft($value, 4, '0')
        );
    }

    public function scopeSearch($query, $request)
    {   
        if (isset($request['search']) AND $search = $request['search']) {
            $query->where(function($q) use ($search) {
                $q->where('title', 'LIKE', '%' . $search . '%')
                ->orWhere('institutes.name', 'LIKE', '%' . $search . '%');
            });
        }
    }

    public function scopeFilter($query, $request)
    {
        if ($title = $request->title AND $title = $request->title) {
            $query->where('title', 'LIKE', '%' . $title . '%');
        }

        if ($institute = $request->institute AND $institute = $request->institute) {
            $query->where('legislations.institute_id', '=', $institute);
        }

        if ($reg_number = $request->reg_number AND $reg_number = $request->reg_number) {
            $query->where('reg_number', 'LIKE', '%' . $reg_number . '%');
        }
    }

    public function scopeOrder($query, $request)
    {   
        if ($order = $request->order)
        {
            if ($order === 'category') {                
                $query->orderBy('category_abbrev', $request->sort);
            } else if ($order === 'user') {
                $query->orderBy('user_name', $request->sort);
            } else {
                $query->orderBy($order, $request->sort);
            }
        }
    }

    public function scopePerda($query)
    {
        return $query->select(['legislations.*', 'institutes.abbrev AS institute_abbrev', 'institutes.name AS institute_name'])
            ->join('institutes', 'legislations.institute_id', '=', 'institutes.id')
            ->where('type', 'perda');
    }

}
