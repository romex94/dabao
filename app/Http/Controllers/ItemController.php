<?php

namespace App\Http\Controllers;

use App\Item;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Http\Request;

class ItemController extends Controller
{
    //
    public function add(Request $request)
    {
    	$item = Item::create([
    			'name' => $request->name,
    			'description' => $request->description,
    			'price' => $request->price,
    			'type' => $request->type,
    			'type_id' => $request->type_id,
    			'order_id' => $request->order_id,
    		]);

    	$quantity = $request->quantity ?: 1;

    	Cart::add($item->id, $item->name, $quantity, $item->price);

    	return response(200);
    }
}
