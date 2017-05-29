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
    protected $guarded = [];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function complains()
    {
        return $this->hasMany('App\Complain');
    }


    public function transactions()
    {
        return $this->hasMany('App\Transaction')->latest();
    }

    public function getCreditBalanceAttribute()
    {
        return $this->transactions()->where('type', 'in')->orWhere('type', 'refund')->sum('amount');
    }

    public function orders()
    {
        return $this->hasMany('App\Order');
    }

    public function addresses()
    {
        return $this->hasMany('App\Address');
    }
}

