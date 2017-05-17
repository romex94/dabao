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
}