<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    //
    protected $guarded = [];
    protected $with = ['address'];
    public function user()
    {
    	return $this->belongsTo('App\User');
    }

    public function foods()
    {
    	return $this->hasMany('App\Food');
    }

    public function address()
    {
        return $this->belongsTo('App\Address');
    }
}
