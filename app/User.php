<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Gate;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'description', 'profile_picture'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function orders()
    {
        return $this->hasMany('App\Order');
    }

    public function products()
    {
        return $this->hasMany('App\Product');
    }

    public function hasRole(string $role)
    {
        return $this->role === $role;
    }

    public function hasAnyRole(array $roles)
    {
        foreach ($roles as $role) {
            if ($role === $this->role) {
                return true;
            }
        }
        return false;
    }

    public function updatePassword($old, $new)
    {
        if (Gate::denies('change-password', $old)) {
            return back()->with('error', 'Wachtwoorden komen niet overeen');
        }
        $this->password = $new;
    }
}
