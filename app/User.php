<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'realname', 'email', 'password'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function premiumSubscriptions()
    {
        return $this->hasMany('App\PremiumSubscription');
    }

    public function premiumSubscription()
    {
        return $this->premiumSubscriptions()->valid()->first();
    }

    public function isPremium()
    {
        return !$this->premiumSubscriptions()->valid()->get()->isEmpty();
    }

}
