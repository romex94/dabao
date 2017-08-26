<?php

namespace App\Http\Controllers;

use App\Address;
use App\Item;
use App\Order;
use Carbon\Carbon;
use GuzzleHttp\Client;
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

        // TODO! Hard coded delivery time for testing purpose, should be dynamic
        $order = Order::create([
                    'delivery_time' => "2017-08-21 08:00", //$request->delivery_time, 
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

    public function food(Request $request, $chef_id)
    {
        $current_order = auth()->user()->orders->last();
        $current_order->update([
                'chef_id' => $chef_id,
                'chef_name' => $request->name,
                'chef_address' => $request->address,
                'chef_longitude' => $request->longitude,
                'chef_latitude' => $request->latitude,
                'status' => 'select_food'
            ]);

        return view('users.food', ['id' => $chef_id]);
    }

    public function chef()
    {
        $current_order = auth()->user()->orders->last();

        return view('users.chef', ['order' => $current_order]);
    }

    public function checkout(Request $request)
    {
        $order = auth()->user()->orders->last();
        return view('users.checkout', ["order" => $order]);
    }

    public function confirm(Request $request, Order $order)
    {
        //dd($request);

        foreach($request->remarks as $key => $remarks)
        {
            $item = Item::where('row_id_in_cart', $key)->first();
            $item->update([
                'remarks' => $remarks
                ]);
        }

        $client = new Client();

        $response = $client->request('POST', 'https://driver.welory.com.my/api/deliver', [
                        'form_params' => [
                            'order_id' => $order->id,
                            'pickup_time' => Carbon::now()->toDateTimeString(), // TODO! calculate time
                            'pickup_address' => $order->chef_address,
                            'longitude' => $order->chef_longitude,
                            'latitude' => $order->chef_latitude,
                        ], 
                        'verify' => false,
                    ]);

        $body = json_decode($response->getBody());

        $client->request('POST', 'https://chef.welory.com.my/api/order/' . $order->chef_id, [
                'form_params' => [
                    'order_id' => $order->id,
                    'pick_up_time' => Carbon::now()->toDateTimeString(), // TODO! calculate time
                    'driver' => $body->fname,
                    'driver_car_plate' => 'WWW Car Plate',
                    'food' => $order->foods->toArray(),
                    'total_paid' => $order->foods()->sum('price')
                ],
                'verify' => false,
            ]);
    }
}
