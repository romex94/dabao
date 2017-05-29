<div class="panel-heading level" role="tab" id="headingOne">
    <h4 class="panel-title flex">
        <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse{{$transaction->id}}" aria-expanded="false" aria-controls="collapse{{$transaction->id}}">
            Refund on {{ $transaction->created_at->diffForHumans() }} 
        </a>
    </h4>
    <span>Click to view details</span>
</div>
<div id="collapse{{$transaction->id}}" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading{{$transaction->id}}">
    <div class="panel-body">
        Transaction date: {{ $transaction->created_at }}<br>
        Amount: {{ $transaction->amount }}<br>
        Description: Refunded {{ $transaction->amount }} credit due to failure of order #{{ $transaction->order_id }}.
    </div>
</div>