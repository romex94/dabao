<?php

namespace App;

use Gloudemans\Shoppingcart\Contracts\Buyable;
use Illuminate\Database\Eloquent\Model;

class Item extends Model implements Buyable
{
    protected $guarded = [];

    public function order()
    {
    	return $this->belongsTo('App\Order');
    }

    /**
     * Get the identifier of the Buyable item.
     *
     * @return int|string
     */
    public function getBuyableIdentifier($options = null){
    	return $this->id;
    }

    /**
     * Get the description or title of the Buyable item.
     *
     * @return string
     */
    public function getBuyableDescription($options = null){
    	return $this->name;
    }

    /**
     * Get the price of the Buyable item.
     *
     * @return float
     */
    public function getBuyablePrice($options = null){
    	return $this->price;
    }

}
