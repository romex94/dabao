<?php

namespace App\Http\Controllers;

use App\Item;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Http\Request;

class ItemController extends Controller
{
    //
    
    public function index()
    {
        // Whip up 5 mock items and add to cart
        //Cart::destroy();
        if( Cart::count() == 0 )
        {
            $items = factory("App\Item", 5)->make();
            //dd($items);
            foreach($items as $item)
            {
                Cart::add($item->type . "-" . $item->type_id, $item->name, 1, $item->price, ['photo' => $item->photo, 'type' => $item->type]);
            }
        }
        return Cart::content()->toArray(); 
    }

    public function add(Request $request)
    {
    	$quantity = $request->quantity ?: 1;

        $item = Item::create([
    			'name' => $request->name,
    			'description' => $request->description,
    			'price' => $request->price,
    			'type' => $request->type,
    			'type_id' => $request->type_id,
    			'order_id' => $request->order_id,
                'photo' => $request->photo,
                'quantity' => $quantity
    		]);

    	Cart::add($item->type . "-" . $item->type_id, $item->name, $quantity, $item->price, ['photo' => $item->photo, 'type' => $item->type]);

    	return response(200);
    }

    public function remove(Request $request)
    {
        Cart::update($request->rowId, $request->quantity);
        //Cart::remove($request->rowId);
    }
}
