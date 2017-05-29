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
    public function a_user_can_create_info()
    {
        $user = factory('App\User')->create();
        $this->be($user);
        //$order = factory('App\Order')->make(["user_id" => $user->id]);
        
        $user = auth()->user();
        //dd($user);
        $response = $this->post( '/user', $user->toArray());

        $this->assertDatabaseHas("users", ["name"=>$user->name, "email"=>$user->email, "religion"=>$user->religion,]);
        // Fill in and post to /orders

        // Redirect user to /orders page and user should see the created order
    }

    /** @test */
    public function a_user_can_add_info()
    {
        // $user = factory('App\User')->create();
        $this->signIn();
        // $this->be($user);
        //$order = factory('App\Order')->make(["user_id" => $user->id]);
        
        $user = auth()->user();
        //dd($user);
        $response = $this->post( '/user', $user->toArray());

        $this->assertDatabaseHas("users", ["name"=>$user->name, "email"=>$user->email, "religion"=>$user->religion,]);
        // Fill in and post to /orders

        // Redirect user to /orders page and user should see the created order
    }
}

