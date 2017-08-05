<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    //
    protected $guarded = [];

    protected $appends = ['fullAddress'];

    public function user(){
        return $this->belongTo('App\User');
    }

    public function orders(){
    	return $this->hasMany('App\Order');
    }

    public function getFullAddressAttribute(){
    	$address = collect([$this->address_line_1, $this->address_line_2, $this->town, $this->country, $this->state, $this->country]);
    	$filtered = $address->filter(function( $value, $key ){
    		return $value != "";
    	})->all();


    	$address_string = implode(", ", $filtered);
    	return $address_string;
    }
}
