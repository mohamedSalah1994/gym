@extends('profile')
@section('profileHead')
<h1>{{__('profile.My Account')}}</h1>
@endsection
@section('content')
<div class="col-lg-9">

<div class="card card--lg">
<div class="card__header">
<h4>{{__('profile.LastPayments')}}</h4>
</div>
<div class="card__content">
    @if(count(auth()->guard('user')->user()->paymentsObjs) >0)
       <table class="table  table-hover custom_table_subscriptions">
        <thead>
        <tr>
        <th>{{__('profile.planText')}}</th>
        <th>{{__('profile.subscribeAt')}}</th>
        <th>{{__('profile.invoiceNumber')}}</th>
        <th>{{__('profile.paymentAmount')}}</th>
        <th>{{__('profile.paymentStatus')}}</th>
        </tr>
        </thead>
<tbody>
  @foreach(auth()->guard('user')->user()->paymentsObjs as $payment)
    <tr>
  <td>{{$payment->planOb->name ?? ''}}</td>
  <td>{{\Carbon\Carbon::parse($payment->created_at)->format('d-M-Y')}}</td>
  <td>{{$payment->invoicenumber}}</td>
  <td>{{$payment->amount}} / {{__('profile.' . $payment->currency)}}</td>
  <td>{{__('profile.' . $payment->status)}}</td>
</tr>
 @endforeach
</tbody>
</table>
@else
     <div class="row noSubscriptionSectioninprofile">
       <div class="col-lg-6"><h4>{{__('profile.uhavntanylastpayments')}}</h4></div>
    </div>
    @endif
    </div>
</div>

</div>
@endsection