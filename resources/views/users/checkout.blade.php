@extends('layouts.app')

@section('content')
<form method="POST" action="/confirm/{{ $order->id }}">
	{{ csrf_field() }}
	<div class="container">
	    <div class="row">
	    	<div class="col-md-12">
	    		<h2>Order summary</h2>
	    		<h3>Deliver to</h3>
	    		<address>
					<strong>{{ $order->address->address_line_1 }}, {{ $order->address->address_line_2 }},</strong><br>
					{{ $order->address->town }}, {{ $order->address->state }},<br>
					{{ $order->address->postcode }} Malaysia
				</address>
	    	</div>
	    </div>

	    <div class="row">
	    	<div class="col-md-12">
	    		<h3>Items</h3>
	    		<div class="table-responsive">
	    			<table class="table">
	    				<thead>
	    					<tr>
	    						<td>Food</td>
	    						<td>Notes</td>
	    						<td>Qty</td>
	    						<td>Price (RM)</td>
	    					</tr>
	    				</thead>
	    				<tbody>
	    					@foreach( Cart::content() as $item )
	    						<tr>
	    							<td>
	    								<div class="flex-row">
	    									<img src="{{ $item->options->photo }}" class="img-responsive" width="150px">
	    									<div class="flex" style="padding-left: 25px">
							    				<b>{{ $item->name}}</b><br>
							    				Size: {{ $item->options->description }}
							    			</div>
		    							</div>
		    						</td>
		    						<td>
		    							<textarea name="remarks[{{ $item->rowId }}]"></textarea>
		    						</td>
		    						<td>
		    							{{ $item->qty }}
		    						</td>
		    						<td>
		    							{{ $item->price }}
		    						</td>
	    						</tr>
				    		@endforeach
	    				</tbody>
	    				<tfoot>
	    					<tr>
	    						<td></td>
	    						<td></td>
	    						<td>Total price:</td>
	    						<td><b>{{Cart::content()->sum('price')}}</b></td>
	    					</tr>
	    				</tfoot>
	    			</table>
	    		</div>
	    	</div>
	    </div>

	    <div class="pull-right">
	    	<button class="btn btn-primary">
	    		Confirm order
	    	</button>
	    </div>
	</div>
</form>
@endsection	