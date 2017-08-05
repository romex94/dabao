<?php

namespace App\Http\Controllers;

use App\Events\DriverResultReturned;
use App\Order;
use Illuminate\Http\Request;
use Log;

class APIController extends Controller
{
    //
    public function getDriverResult(Request $request)
    {
    	Order::findOrFail($request->order_id)
                ->update([
                    'status' => 'selecting_chef',
                    'driver_id' => $request->driver_id,
                ]);
        
        event(new DriverResultReturned($request->order_id, 
    								   $request->status,
    								   $request->driver_id,
    								   $request->driver_name,
    								   $request->driver_image));


    }
}
