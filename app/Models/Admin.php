<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Admin extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = ['username', 'email', 'password', 'admin_role_id', 'is_superadmin'];

    protected $hidden = ['password'];

    protected $casts = [
        'is_superadmin' => 'boolean',
    ];

    public function role()
    {
        return $this->belongsTo(AdminRole::class, 'admin_role_id');
    }

    public function hasPermission($permission)
    {
        if ($this->is_superadmin) {
            return true;
        }

        if (!$this->role || !$this->role->permissions) {
            return false;
        }

        return in_array($permission, $this->role->permissions);
    }
}
