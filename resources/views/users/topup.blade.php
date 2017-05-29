@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8">
            <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
                <div class="panel panel-default">
                    @forelse( auth()->user()->transactions as $transaction )
                       @if( view()->exists("users.transactions.transaction_{$transaction->type}"))
                            @include("users.transactions.transaction_{$transaction->type}", ['transaction' => $transaction])
                       @endif 
                    @empty
                        <p>You have not made any purchases.</p>
                    @endforelse
                </div>
            </div>
        </div>
    
    <div class="row">
        <div class="col-md-4">
            <div class="panel panel-default">
                <div class="panel-body">
                    You have a balance of
                    <h2>{{ auth()->user()->creditBalance }} <small>credit</small></h2>
                                     
                </div>
                <div class="panel-footer">
                    <h4>Top up:</h4>
                    <form action="/topup" method="POST">
                        {{ csrf_field() }}
                        <div class="form-group">
                            <input class="form-control" type="number" name="amount" placeholder="Amount" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Top up</button>
                    </form>   
                </div>

            </div>
        </div>
    </div>
</div>
@endsection

@section('footerjs')
    <script>
    $('.collapse').collapse();
    </script>
@endsection
