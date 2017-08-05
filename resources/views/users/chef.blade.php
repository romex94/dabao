@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10">
        	<chefs :order="{{ $order->toJson() }}" :halal="{{ auth()->user()->halal_food_only }}"></chefs>
        </div>
    </div>
</div>
@endsection
