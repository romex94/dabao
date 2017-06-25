<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Events\DriverResultReturned;
use Psr\Http\Message\ServerRequestInterface;
use Log;

class APIController extends Controller
{
    //
    public function getDriverResult(ServerRequestInterface $request)
    {
    	Log::info("Request received!");
    	Log::info("For order: " . $request );
    	event(new DriverResultReturned($request->order_id, 
    								   $request->status,
    								   $request->driver_id,
    								   $request->driver_name,
    								   $request->driver_image));
    }
}
