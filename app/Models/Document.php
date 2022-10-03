<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Support\Facades\Storage;
use App\Models\Traits\HelperTrait;

class Document extends Model
{
    use HasFactory, HelperTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'legislation_id',
        'requirement_id',
        'path',
        'name',
        'posted_at',
        'revised_at',
        'validated_at',
    ];

    protected $casts  = [
        'posted_at'     => 'datetime',
        'revised_at'    => 'datetime',
        'validated_at'  => 'datetime',
    ];

    public function legislation()
    {
        return $this->belongsTo(Legislation::class);
    }

    public function requirement()
    {
        return $this->belongsTo(Requirement::class);
    }

    public function extClass(): Attribute
    {         
        $file = explode('.', $this->path);
        $ext = $file[1];

        if ($ext === 'pdf') {
            $class = 'icon-file-pdf text-danger';
        } else if ($ext === 'doc' OR $ext === 'docx') {
            $class = 'icon-file-word text-primary';
        } else if ($ext === 'xls' OR $ext === 'xlsx') {
            $class = 'icon-file-excel text-success';
        } else if ($ext === 'ppt' OR $ext === 'pptx') {
            $class = 'icon-file-presentation text-warning';
        } else if ($ext === 'zip' OR $ext === 'rar') {
            $class = 'icon-file-zip text-teal';
        } else if ($ext === 'txt' OR $ext === 'rtf') {
            $class = 'icon-file-text2 text-pink';
        } else {
            $class = 'icon-file-empty text-secondary';
        }

        return Attribute::make(
            get: fn ($value) => $class
        );
    }

    public function typeTranslate(): Attribute
    {      
        if ($this->type === 'master') {
            $type = 'Rancangan';
        } else if ($this->type === 'requirement') {
            $type = 'Persyaratan';
        } else if ($this->type === 'attachment') {
            $type = 'Lampiran';
        }

        return Attribute::make(
            get: fn ($value) => $type
        );
    }

    public function source(): Attribute
    {      
        return Attribute::make(
            get: fn ($value) => Storage::url($this->path)
        );
    }

    public function input(): Attribute
    {     
        if ($this->title === 'Draf Ranperda') {
            $input = 'master';
        } else if ($this->title === 'Surat Pengantar') {
            $input = 'surat_pengantar';
        } else if ($this->title === 'Naskah Akademik') {
            $input = 'naskah_akademik';
        } else if ($this->title === 'Notulensi Rapat') {
            $input = 'notulensi_rapat';
        }

        return Attribute::make(
            get: fn ($value) => $input
        );
    }
    
    public function size($precision = 2)
    {   
        $bytes = Storage::disk('public')->size($this->path);

        $units = array('B', 'KB', 'MB', 'GB', 'TB'); 

        $bytes = max($bytes, 0); 
        $pow = floor(($bytes ? log($bytes) : 0) / log(1024)); 
        $pow = min($pow, count($units) - 1); 

        $bytes /= pow(1024, $pow);

        return round($bytes, $precision) . ' ' . $units[$pow]; 
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
        }

        return Attribute::make(
            get: fn ($value) => $statusBadge
        );
    }

    public function scopeMaster($query, $legislation_id)
    {
        return $query->select(['documents.*', 'requirements.*'])
            ->join('requirements', 'documents.requirement_id', '=', 'requirements.id')
            ->where('documents.legislation_id', $legislation_id)
            ->where('requirements.category', 'master');
    }

    public function scopeRequirements($query, $legislation_id)
    {
        return $query->select(['documents.*', 'requirements.*'])
            ->join('requirements', 'documents.requirement_id', '=', 'requirements.id')
            ->where('documents.legislation_id', $legislation_id);
    }
}
