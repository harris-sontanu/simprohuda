<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Traits\HelperTrait;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Support\Str;
use Illuminate\Support\Carbon;

class Legislation extends Model
{
    use HasFactory, SoftDeletes, HelperTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'type',
        'title',
        'slug',
        'reg_number',
        'year',
        'background',
        'institute_id',
        'posted_at',
        'revised_at',
        'validated_at',
    ];

    protected $casts  = [
        'posted_at'     => 'datetime',
        'revised_at'    => 'datetime',
        'validated_at'  => 'datetime',
    ];

    protected $status;

    public function institute()
    {
        return $this->belongsTo(Institute::class);
    }

    public function documents()
    {
        return $this->hasMany(Document::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function scopeDraft($query)
    {
        return $query->whereNull('posted_at');
    }
    
    public function scopePosted($query)
    {
        return $query->whereNotNull('posted_at')
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
        if (empty($this->posted_at) AND empty($this->revised_at) AND empty($this->validated_at)) {
            $status = 'draft';
        } else if (!empty($this->posted_at) AND empty($this->revised_at) AND empty($this->validated_at)) {
            $status = 'posted';
        } else if (!empty($this->revised_at) AND empty($this->validated_at)) {
            $status = 'revised';
        } else if (!empty($this->validated_at)) {
            $status = 'validated';
        }

        if (!empty($this->deleted_at)) {
            $status = 'canceled';
        }

        return $status;
    }

    public function statusBadge(): Attribute
    {
        if ($this->status() == 'draft') {
            $statusBadge = '<span class="badge badge-pill badge-light">Draf</span>';
        } else if ($this->status() == 'posted') {
            $statusBadge = '<span class="badge badge-pill badge-primary">Aktif</span>';
        } else if ($this->status() == 'revised') {
            $statusBadge = '<span class="badge badge-pill badge-warning">Revisi</span>';
        } else if ($this->status() == 'validated') {
            $statusBadge = '<span class="badge badge-pill badge-success">Valid</span>';
        } else if ($this->status() == 'canceled') {
            $statusBadge = '<span class="badge badge-pill badge-dark">Batal</span>';
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

    public function createdYear(): Attribute
    {           
        return Attribute::make(
            get: fn ($value) => Carbon::parse($this->created_at)->translatedFormat('Y')
        );
    }

    public function scopeSearch($query, $request)
    {   
        if (isset($request['search']) AND $search = $request['search']) {
            $query->where(function($q) use ($search) {
                $q->where('title', 'LIKE', '%' . $search . '%');
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

        if ($created_at = $request->created_at AND $created_at = $request->created_at) {
            $query->whereDate('legislations.created_at', Carbon::parse($created_at)->format('Y-m-d'));
        }
        
        if ($posted_at = $request->posted_at AND $posted_at = $request->posted_at) {
            $query->whereDate('legislations.posted_at', Carbon::parse($posted_at)->format('Y-m-d'));
        }

        if ($revised_at = $request->revised_at AND $revised_at = $request->revised_at) {
            $query->whereDate('legislations.revised_at', Carbon::parse($revised_at)->format('Y-m-d'));
        }

        if ($validated_at = $request->validated_at AND $validated_at = $request->validated_at) {
            $query->whereDate('legislations.validated_at', Carbon::parse($validated_at)->format('Y-m-d'));
        }
    }

    public function scopeOrder($query, $request)
    {   
        if ($order = $request->order)
        {
            if ($order === 'institute') {                
                $query->orderBy('institute_name', $request->sort);
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

    public function scopePerbup($query)
    {
        return $query->select(['legislations.*', 'institutes.abbrev AS institute_abbrev', 'institutes.name AS institute_name'])
            ->join('institutes', 'legislations.institute_id', '=', 'institutes.id')
            ->where('type', 'perbup');
    }

    public function scopeSk($query)
    {
        return $query->select(['legislations.*', 'institutes.abbrev AS institute_abbrev', 'institutes.name AS institute_name'])
            ->join('institutes', 'legislations.institute_id', '=', 'institutes.id')
            ->where('type', 'sk');
    }

}
