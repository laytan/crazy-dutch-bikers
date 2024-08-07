<?php

namespace App;

use Exception;
use Gate;
use Hash;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'description', 'profile_picture', 'api_token',
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

    public function getProfilePictureDimensionsAttribute()
    {
        try {
            if ($this->getOriginal('profile_picture') == null) {
                list($width, $height, $type, $attr) =
                    getimagesize(public_path('images/profile-placeholder.png'));
            } else {
                list($width, $height, $type, $attr) =
                    getimagesize(storage_path('app/public/' . $this->getOriginal('profile_picture')));
            }
        } catch (Exception $e) {
            // Image was probably deleted
            return [1, 1];
        }
        return [$width, $height];
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

    /**
     * Change the users password if the old password is the current password.
     * Return wether it was succesfull
     */
    public function updatePassword(string $old, string $new): bool
    {
        if (Gate::denies('change-password', $old)) {
            return false;
        }
        $this->password = Hash::make($new);
        return true;
    }
}
