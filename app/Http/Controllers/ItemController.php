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
            /*$items = factory("App\Item", 5)->make();
            //dd($items);
            foreach($items as $item)
            {
                Cart::add($item->type . "-" . $item->type_id, $item->name, 1, $item->price, ['photo' => $item->photo, 'type' => $item->type]);
            }*/
        }
        return Cart::content()->toArray(); 
    }

    public function add(Request $request)
    {
    	

        $quantity = $request->quantity ?: 1;
        $order_id = $request->order_id ?: auth()->user()->orders->last()->id;

        // Check if it is ordered already
        $item = Item::where('type_id', $request->type_id)
                     ->where('type', $request->type)
                     ->where('order_id', $order_id) // make sure for same order
                     ->where('description', $request->description) // make sure same size
                     ->first();

        if( !isset($item) )
        {
            // Not yet ordered in the same order before
            $item = Item::create([
                'name' => $request->name,
                'description' => $request->description,
                'price' => $request->price,
                'type' => $request->type,
                'type_id' => $request->type_id,
                'order_id' => $order_id,
                'photo' => $request->photo,
            ]);

            $cartitem = Cart::add($item->type . "-" . $item->type_id, $item->name, $quantity, $item->price, ['photo' => $item->photo, 'type' => $item->type, 'description' => $item->description]);

            $item->update(['row_id_in_cart' => $cartitem->rowId]);
        }
        else
        {
            // Ordered before
            $item->update(['quantity' => $item->quantity + $quantity]);
            Cart::update($item->row_id_in_cart, $item->quantity);
        }
        

    	
        

    	return response(200);
    }

    public function remove(Request $request)
    {

        Cart::update($request->rowId, $request->quantity);

        $item = Item::where('row_id_in_cart', $request->rowId)->first();

        if( isset($item) )
        {
            $item->update(['quantity' => $request->quantity]);
            if($request->quantity <= 0)
            {
                $item->delete();
            }       
        }

    }


}
