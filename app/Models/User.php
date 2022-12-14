<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use App\Models\Traits\HelperTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Support\Carbon;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes, HelperTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'username',
        'email',
        'password',
        'role',
        'phone',
        'www',
        'bio',
        'facebook',
        'twitter',
        'instagram',
        'tiktok',
        'youtube',
        'picture',
        'last_logged_in_at',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'last_logged_in_at' => 'datetime'
    ];

    public function responsibles()
    {
        return $this->hasMany(Institute::class, 'corrector_id');
    }

    public function institutes()
    {
        return $this->belongsToMany(Institute::class);
    }

    public function legislations()
    {
        return $this->hasMany(Legislation::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class, 'sender_id');
    }

    public function replies()
    {
        return $this->hasMany(Comment::class, 'to_id');
    }

    public function logs()
    {
        return $this->hasMany(Log::class);
    }

    public function scopeSorted($query, $request = [])
    {
        if (isset($request['order'])) {
            return $query->orderBy($request['order'], $request['sort']);
        } else {
            return $query->orderBy('name', 'asc');
        }
    }

    public function scopePending($query)
    {
        return $query->whereNull('deleted_at')
                    ->whereNull('email_verified_at');
    }

    public function scopeActive($query)
    {
        return $query->whereNull('deleted_at')
                    ->whereNotNull('email_verified_at');
    }

    public function scopeSearch($query, $request)
    {
        if (isset($request['search']) AND $search = $request['search']) {
            $query->where(function($q) use ($search) {
                $q->where('name', 'LIKE', '%' . $search . '%')
                ->orWhere('email', 'LIKE', '%' . $search . '%')
                ->orWhere('role', 'LIKE', '%' . $search . '%');
            });
        }
    }

    public function scopeFilter($query, $request)
    {
        if (!empty($request['name']) AND $name = $request['name']) {
            $query->where('name', 'LIKE', '%' . $name . '%');
        }

        if (!empty($request['email']) AND $email = $request['email']) {
            $query->where('email', 'LIKE', '%' . $email . '%');
        }

        if (!empty($request['role']) AND $role = $request['role']) {
            $query->where('role', '=', $role);
        }

        if (!empty($request['phone']) AND $phone = $request['phone']) {
            $query->where('phone', 'LIKE', '%' . $phone . '%');
        }

        if (!empty($request['www']) AND $www = $request['www']) {
            $query->where('www', 'LIKE', '%' . $www . '%');
        }

        if (!empty($request['name']) AND $name = $request['name']) {
            $query->where('name', 'LIKE', '%' . $name . '%');
        }

        if (!empty($request['bio']) AND $bio = $request['bio']) {
            $query->where('bio', 'LIKE', '%' . $bio . '%');
        }

        if (!empty($request['last_logged_in_at']) AND $last_logged_in_at = $request['last_logged_in_at']) {
            $query->whereDate('last_logged_in_at', Carbon::parse($last_logged_in_at)->format('Y-m-d'));
        }

        if (!empty($request['created_at']) AND $created_at = $request['created_at']) {
            $query->whereDate('created_at', Carbon::parse($created_at)->format('Y-m-d'));
        }
    }

    public function scopeOrder($query, $request)
    {
        if (!empty($request['order']) AND $order = $request['order']) {
            $query->orderBy($order, $request['sort']);
        }
    }

    public function status()
    {
        $status = 'active';
        if (is_null($this->email_verified_at)) $status = 'pending';
        if (!is_null($this->deleted_at)) $status = 'trash';

        return $status;
    }

    public function statusBadgeHtml(): Attribute
    {
        $status = $this->status();

        if ($status == 'active') {
            $badgeHtml = '<span class="badge bg-primary bg-opacity-20 text-primary">Aktif</span>';
        } else if ($status == 'pending') {
            $badgeHtml = '<span class="badge bg-warning bg-opacity-20 text-warning">Tinjau</span>';
        } else if ($status == 'trash') {
            $badgeHtml = '<span class="badge bg-dark bg-opacity-20 text-dark">Sampah</span>';
        } else {
            $badgeHtml = '<span class="badge bg-info bg-opacity-20 text-info">'.$status.'</span>';
        }

        return new Attribute(
            get: fn ($value) => $badgeHtml
        );
    }

    protected function role(): Attribute
    {   
        $roles = [
            'administrator' => 'Administrator',
            'bagianhukum' => 'Bagian Hukum',
            'opd' => 'Perangkat Daerah'
        ];

        return Attribute::make(
            get: fn ($value) => $roles[$value],
        );
    }

    public function scopeAdmin($query)
    {
        return $query->where('role', 'administrator');
    }

    public function scopeOpd($query)
    {
        return $query->where('role', 'opd');
    }

    public function scopeBagianHukum($query)
    {
        return $query->where('role', 'bagianhukum');
    }

}
