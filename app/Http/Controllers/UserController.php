<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;

class UserController extends Controller
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
        // Get the current user
        // Modify the modifiable attributes
        // Save the edited user
        // Return to the original page
        User::create([
            'name' =>$request->name,
            'password' =>$request->password,
            'email' =>$request->email,
            'religion' => $request->name,
            'phone' => $request->phone,
            'status' =>  $request->status,
            'halal_food_only'=> $request->halal_food_only,
            ]);

        if (Auth::attempt(['email' => $user->email, 'password' => $user->password])) {
            // Authentication passed...
            return redirect()->intended('/user');
            
        }

        
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
    public function edit()
    {
        //
        $user = auth()->user;
        
        return view("welcome", ['user'=>$user] );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        //
        $password = $request->password; 
        // Get the current user
        $user = auth()->user();
        if (empty($password)) {
            $password = $user->password;
        }
        // Modify the modifiable attributes
        $user->name = $request->name;
        $user->password = $password;
        $user->religion = $request->religion;
        $user->phone = $request->phone;
        $user->status = $request->status;
        $user->halal_food_only = $request->halal_food_only;

        // Save the edited user
        $user->save();
        
        return view('user');
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
}
