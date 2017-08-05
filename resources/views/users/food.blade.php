@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10">
        	<foods :chef="{{ $id }}"></foods>
        </div>
    </div>
</div>
@endsection
