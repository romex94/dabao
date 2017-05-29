<?php

namespace App\Http\Controllers;

use App\address;
use Illuminate\Http\Request;

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
        return view('Address.add-address-form');
        
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
        $this->validate( $request, [
                'address_line_1' => 'required',
                'town' => 'required',
                'state' => 'required',
                'postcode' => 'required',
                ]);

        auth()->user()->addresses()->create([
            'address_line_1' =>$request->address_line_1,
            'address_line_2' =>$request->address_line_2,
            'town' => $request->town,
            'state' => $request->state,
            'country' => 'Malaysia',
            'postcode' => $request->postcode,
            ]);
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
         $address = auth()->user()->addresses()->first();
        
        return view('Address.address-form', ['address' => $address]);
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
        $this->validate( $request, [
                'address_line_1' => 'required',
                'town' => 'required',
                'state' => 'required',
                'postcode' => 'required',
                ]);
        
        // $password = $request->password; 
        // // Get the current user
        // $user = auth()->user();
        // if (empty($password)) {
        //     $password = $user->password;
        // }
        // Modify the modifiable attributes

        $address = auth()->user()->addresses()->first();
        $address->address_line_1 = $request->address_line_1;
        $address->address_line_2= $request->address_line_2;
        $address->town = $request->town;
        $address->state = $request->state;
        $address->postcode = $request->postcode;

        // Save the edited user
        $address->save();
        
        return view('address');
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
