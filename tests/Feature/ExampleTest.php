<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\User;
use App\Order;
use App\Address;

class ExampleTest extends TestCase
{
     use DatabaseMigrations;
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testBasicTest()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    /** @test */
    public function  a_user_can_create_info()
    {
        $user = factory('App\User')->create();
        $this->be($user);
        //$order = factory('App\Order')->make(["user_id" => $user->id]);
        
        $user = auth()->user();
        //dd($user);
        $response = $this->post( '/user', $user->toArray());

        $this->assertDatabaseHas("users", ["name"=>$user->name, "email"=>$user->email, "religion"=>$user->religion, "address"=>$user->address]);
        // Fill in and post to /orders

        // Redirect user to /orders page and user should see the created order
    }

    /** @test */
    public function  a_user_can_add_info()
    {
        // $user = factory('App\User')->create();
        $this->signIn();
        // $this->be($user);
        //$order = factory('App\Order')->make(["user_id" => $user->id]);
        
        $user = auth()->user();
        //dd($user);
        $response = $this->post( '/user', $user->toArray());

        $this->assertDatabaseHas("users", ["name"=>$user->name, "email"=>$user->email, "religion"=>$user->religion, "address"=>$user->address]);
        // Fill in and post to /orders

        // Redirect user to /orders page and user should see the created order
    }

    /** @test */
    public function  a_user_can_add_order()
    {
        $user = $this->signIn();
        $order = factory('App\Order')->create();

        //$this->be($order);
        //$order = factory('App\Order')->make(["user_id" => $user->id]);
        
        $response = $this->post( '/order', $order->toArray());
        $this->withExceptionHandling();

        $this->assertDatabaseHas("orders", ["food"=>$order->food, "quantity"=>$order->quantity, "date"=>$order->date, "chefname"=>$order->chefname, "totalpaid"=>$order->totalpaid, "status"=>$order->status, "drivername"=>$order->drivername]);
        // Fill in and post to /orders

        // Redirect user to /orders page and user should see the created order
    }

    /** @test */
    public function  a_user_can_create_address()
    {
        $address = factory('App\Address')->create();
        $this->be($address);
        //$order = factory('App\Order')->make(["user_id" => $user->id]);
        
        $address = auth()->address();
        //dd($user);
        $response = $this->post( '/address', $address->toArray());

        $this->assertDatabaseHas("addresses", ["addressline1"=>$address->addressline1, "addressline2"=>$address->addressline2, "town"=>$address->town, "state"=>$address->state, "country"=>$address->country, "postcode"=>$address->postcode]);
        // Fill in and post to /orders

        // Redirect user to /orders page and user should see the created order
    }

    // /** @test */
    // //test order history//
    // public function  users_are_able_to_view_order_history()
    // {
    //     $user = $this->signIn();
    //     $order = factory('App\Order')->create();

    //     //$this->be($order);
    //     //$order = factory('App\Order')->make(["user_id" => $user->id]);
        
    //     $response = $this->post( '/Order', $order->toArray());
    //     $this->withExceptionHandling();

    //     $this->assertDatabaseHas("orderhistorys", ["chefname"=>$order->chefname, "totalpaid"=>$order->totalpaid, "status"=>$order->status, "drivername"=>$order->drivername]);
    // }

    // /** @test */
    // //test order history//
    // public function  guests_are_unable_to_view_order_history()
    // {
    //     $user = $this->signIn();
    //     $order = factory('App\Order')->create();

    //     //$this->be($order);
    //     //$order = factory('App\Order')->make(["user_id" => $user->id]);
        
    //     $response = $this->post( '/order', $order->toArray());
    //     $this->withExceptionHandling();

    //     $this->assertDatabaseHas("orders", ["food"=>$order->food, "quantity"=>$order->quantity, "date"=>$order->date]);
    // }
}

