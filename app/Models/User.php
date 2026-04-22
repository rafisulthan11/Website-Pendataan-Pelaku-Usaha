<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'id_user'; // <-- PENYESUAIAN 1

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [ // <-- PENYESUAIAN 2
        'name',
        'nama_lengkap',
        'nip',
        'email',
        'password',
        'id_role',
        'status',
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
        'password' => 'hashed',
    ];

    /**
     * Define the many-to-one relationship with Role.
     * Seorang User pasti memiliki satu Role.
     */
    public function role() // <-- PENYESUAIAN 3
    {
        return $this->belongsTo(Role::class, 'id_role', 'id_role');
    }

    public function isStaff(): bool
    {
        return $this->role?->nama_role === 'staff';
    }

    public function isAdmin(): bool
    {
        return $this->role?->nama_role === 'admin';
    }

    public function isSuperAdmin(): bool
    {
        return $this->role?->nama_role === 'super admin';
    }

    public function isAdminOrSuperAdmin(): bool
    {
        return $this->isAdmin() || $this->isSuperAdmin();
    }

    /**
     * Get the user's full name (accessor for 'name' attribute)
     * Maps the custom 'nama_lengkap' field to the standard 'name' attribute
     */
    public function getNameAttribute()
    {
        return $this->nama_lengkap ?? 'User';
    }

    /**
     * Support code paths that still access the default 'id' attribute.
     */
    public function getIdAttribute()
    {
        return $this->attributes['id_user'] ?? null;
    }

    /**
     * Support legacy assignments using the standard 'name' attribute.
     */
    public function setNameAttribute($value): void
    {
        $this->attributes['nama_lengkap'] = $value;
    }
}