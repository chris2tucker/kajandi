<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Cache;
class User extends Authenticatable
{
    use Notifiable;
protected $guarded = ['admin'];
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token', 'verification_token',
    ];

    public function vendors()
    {
        return $this->hasOne(vendors::class);
    }

    public function roles()
    {
        return $this->belongsToMany('App\Role', 'user_role', 'user_id', 'role_id');
    }
    public function customersvendors()
    {
        return $this->HasMany('App\customersvendor', 'favourite_customer');
    }
    public function notifications()
    {
        return $this->HasMany('App\Notification');
    }
     public function isOnline()
    {
        return Cache::has('user-is-online-'.$this->id);
    }
}
