<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class RyanTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function a_user_can_create_an_order()
    {
    	$order = factory('App\Order')->make();	

    	$this->post('/order', $order->toArray());

    	$this->assertEquals(1, auth()->user()->orders->count());
    } 
}