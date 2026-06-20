<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use Spatie\Permission\Models\Permission;

class Admin extends Authenticatable
{
    use HasFactory, Notifiable, HasApiTokens, HasRoles;
    protected $guard_name = 'admin';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'username',
        'phone',
        'gender',
        'image',
        'status',
        'email',
        'password',
    ];


    public static function getPermissionGroups()
    {
        $permission__groups = Permission::select('group_name')->groupBy('group_name')->get();
        return $permission__groups;
    }

    public static function getPermissionByGroupName($group_name)
    {
        $permissions = Permission::select('name', 'id')->where('group_name', $group_name)->get();
        return $permissions;
    }


    //   For Gates used in categories for learning
    /* 
     * public function hasRole($roles): bool
     * {
     *    if (is_array($roles)) {
     *        return in_array($this->role, $roles);
     *   }
     *  return $this->role === $roles;
    }
     */



    //  For Policies used in categories for learning
  /*
    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    public function isManager(): bool
    {
        return $this->role === 'manager';
    }

    public function isViewer(): bool
    {
        return $this->role === 'viewer';
    }
  */

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
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
}
