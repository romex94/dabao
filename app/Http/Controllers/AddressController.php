<?php

namespace App\Http\Controllers;

use App\address;
use Illuminate\Http\Request;
use App\Address;

class AddressController extends Controller
{
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
        Address::create([
            'addressline1' =>$request->addressline1,
            'addressline2' =>$request->addressline2,
            'town' => $request->town,
            'state' => $request->state,
            'country' => $request->country,
            'postcode' => $request->postcode,
            ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\address  $address
     * @return \Illuminate\Http\Response
     */
    public function show(address $address)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\address  $address
     * @return \Illuminate\Http\Response
     */
    public function edit(address $address)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\address  $address
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, address $address)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\address  $address
     * @return \Illuminate\Http\Response
     */
    public function destroy(address $address)
    {
        //
    }
}
