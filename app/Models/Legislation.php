<?php

namespace App\Models;

use App\Models\Scopes\RoleScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Traits\HelperTrait;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Support\Str;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Auth;

class Legislation extends Model
{
    use HasFactory, SoftDeletes, HelperTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'type_id',
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

    /**
     * The "booted" method of the model.
     *
     * @return void
     */
    protected static function booted()
    {
        static::addGlobalScope(new RoleScope);
    }

    public function type()
    {
        return $this->belongsTo(Type::class);
    }

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

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function logs()
    {
        return $this->hasMany(Log::class)->latest();
    }

    public function unreadComments()
    {
        return $this->comments()
                    ->where('read', 0)
                    ->where('to_id', Auth::user()->id);

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

    public function scopeProcessed($query)
    {
        return $query->where(function ($q) {
                        $q->whereNotNull('posted_at')
                            ->orWhereNotNull('revised_at');
                    })
                    ->whereNull('validated_at')
                    ->orderBy('posted_at', 'desc');
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
            $statusBadge = '<span class="badge bg-pink bg-opacity-20 text-pink">Draf</span>';
        } else if ($this->status() == 'posted') {
            $statusBadge = '<span class="badge bg-primary bg-opacity-20 text-primary">Aktif</span>';
        } else if ($this->status() == 'revised') {
            $statusBadge = '<span class="badge bg-warning bg-opacity-20 text-warning">Revisi</span>';
        } else if ($this->status() == 'validated') {
            $statusBadge = '<span class="badge bg-success bg-opacity-20 text-success">Valid</span>';
        } else if ($this->status() == 'canceled') {
            $statusBadge = '<span class="badge bg-danger bg-opacity-20 text-danger">Batal</span>';
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

    public function scopeYear($query, $request)
    {   
        if (isset($request['year']) AND $year = $request['year']) {
            $query->whereYear('legislations.created_at', $year);
        }
    }

    public function scopeFilter($query, $request)
    {
        if ($title = $request->title AND $title = $request->title) {
            $query->where('title', 'LIKE', '%' . $title . '%');
        }

        if ($reg_number = $request->reg_number AND $reg_number = $request->reg_number) {
            $query->where('reg_number', $reg_number);
        }

        if ($institute = $request->institute AND $institute = $request->institute) {
            $query->where('legislations.institute_id', '=', $institute);
        }

        if ($user = $request->user AND $user = $request->user) {
            $query->where('legislations.user_id', $user);
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

    public function scopeRanperda($query)
    {
        return $query->where('type_id', 1);
    }

    public function scopeRanperbup($query)
    {
        return $query->where('type_id', 2);
    }

    public function scopeRansk($query)
    {
        return $query->where('type_id', 3);
    }

}
