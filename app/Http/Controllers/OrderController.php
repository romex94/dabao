<?php

namespace App\Http\Controllers;

use App\Address;
use App\Order;
use Illuminate\Http\Request;
use Log;

class OrderController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('users.order');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $address_id = $request->address_id;
        // Check if user used previous address or created a new one
        if( $request->address_id == 999 )
        {
            // User created a new one
            $new_address = auth()->user()->addresses()->create([
                    'latitude' => $request->latitude,
                    'longitude' => $request->longitude,
                    'address_line_1' => $request->address_line_1,
                    'address_line_2' => $request->address_line_2,
                    'town' => $request->town,
                    'state' => $request->state,
                    'postcode' => $request->postcode,
                    'country' => 'Malaysia'
                ]);

            $address_id = $new_address->id;
        } 
        else 
        {
            $address = Address::findOrFail($address_id)->update([
                    'latitude' => $request->latitude,
                    'longitude' => $request->longitude,
                    'address_line_1' => $request->address_line_1,
                    'address_line_2' => $request->address_line_2,
                    'town' => $request->town,
                    'state' => $request->state,
                    'postcode' => $request->postcode
                ]);
        }

        $user = $request->user_id ?: auth()->id();
        //Log::info($request);
        $order = Order::create([
                    'delivery_time' => $request->delivery_time,
                    'delivery_location' => $request->delivery_location,
                    'user_id' => $user,
                    'longitude' => $request->longitude,
                    'latitude' => $request->latitude,
                    'address_id' => $address_id
                ]);

        return response($order->toArray(), 202);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function food($chef_id)
    {
        return view('users.food', ['id' => $chef_id]);
    }

    public function chef()
    {
        $current_order = auth()->user()->orders->last();
        return view('users.chef', ['order' => $current_order]);
    }
}
