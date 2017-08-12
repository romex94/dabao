<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Chef extends Model
{
    //

    public function order()
    {
    	return $this->belongsTo('App\Order');
    }

    public function items()
    {
    	return $this->hasMany('App\Item');
    }
}
