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
            'address' => $request->address,
            'phone' => $request->phone,
            'preorderStatus' =>  $request->preorderStatus,
            'status' =>  $request->status,
            'image' => $request->image,
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
        $user->email = $request->email;
        $user->religion = $request->religion;
        $user->address = $request->address;
        $user->phone = $request->phone;
        $user->preorderStatus = $request->preorderStatus;
        $user->status = $request->status;

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
