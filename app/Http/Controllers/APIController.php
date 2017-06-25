<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Events\DriverResultReturned;

class APIController extends Controller
{
    //
    public function getDriverResult(Request $request)
    {
    	Log::info("Request received!");
    	Log::info("For order: " . $request->order_id );
    	event(new DriverResultReturned($request->order_id, 
    								   $request->status,
    								   $request->driver_id,
    								   $request->driver_name,
    								   $request->driver_image));
    }
}
