<?php

namespace Tests\Feature;

use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Tests\TestCase;

class RyanTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function user_can_view_their_credit()
    {
    	// Given that we have a user
    	$this->signIn();	

    	// User have 3 in transactions
    	$in_transactions = factory('App\Transaction', 3)->create(['user_id' => auth()->id(), 'type' => 'in']);

    	// User have 3 out transactions
    	$out_transactions = factory('App\Transaction', 3)->create(['user_id' => auth()->id(), 'type' => 'out']);

    	// User have 1 refunded transactions
    	$refund = factory('App\Transaction')->create(['user_id' => auth()->id(), 'type' => 'refund']);

    	$this->get('/home')->assertSee($in_transactions->sum('amount') + $refund->amount . '');
    }

    /** @test */
    public function guests_may_not_top_up_credit()
    {
    	$this->withExceptionHandling()
    		->get('/topup')
    		->assertRedirect('/login');

    	$this->post('/topup', [])
    		->assertRedirect('/login');
    }

    /** @test */
    public function user_can_top_up_their_credit()
    {
    	// Given that we have a user
    	$this->signIn();

    	$transaction = factory('App\Transaction')->make();

    	$this->post('topup', $transaction->toArray());

    	$this->assertDatabaseHas('transactions', ['user_id' => auth()->id(), 'amount' => $transaction->amount, 'type' => 'in']);

    }

    /** @test */
    public function user_can_view_their_transaction_details()
    {
     	$this->signIn();

     	// User have 3 in transactions
    	$in_transaction = factory('App\Transaction')->create(['user_id' => auth()->id(), 'type' => 'in']);

    	// User have 3 out transactions
    	$out_transaction = factory('App\Transaction')->create(['user_id' => auth()->id(), 'type' => 'out']);

    	// User have 1 refunded transactions
    	$refund = factory('App\Transaction')->create(['user_id' => auth()->id(), 'type' => 'refund']);
     
     	$this->get('/topup')
     		->assertSee($in_transaction->amount . '')
     		->assertSee($out_transaction->amount . '')
     		->assertSee($refund->amount . '');
    }  

    public function a_guest_cannot_create_an_order()
    {

    	$order = factory('App\Order')->make();

    	$response = $this->withExceptionHandling()
    					->post('/order', $order->toArray());

    	$response->assertRedirect('/login');
    } 

    /** @test */
    public function an_authenticated_user_can_create_an_order()
    {
    	$this->signIn();

    	$order = factory('App\Order')->make();

    	$this->post('/order', $order->toArray());

    	$this->assertEquals(1, auth()->user()->orders->count());
    }

    /** @test */
    public function an_authenticated_user_can_add_items_to_cart()
    {
        $this->signIn();

        $item = factory('App\Item')->make(['quantity' => 1]);

        $this->post('/cart/add', $item->toArray());

        $this->assertEquals(1, Cart::count());
    } 

    /** @test */
    public function user_can_remove_cart_items()
    {
        $this->signIn();

        Cart::destroy();

        $item = factory('App\Item')->make(['quantity' => 1]);

        $this->post('/cart/add', $item->toArray());

        $this->assertEquals(1, Cart::count());

        $this->post('/cart/remove', [Cart::content()->first()->rowId, 0]);

        $this->assertEquals(0, Cart::count());

    }  
}