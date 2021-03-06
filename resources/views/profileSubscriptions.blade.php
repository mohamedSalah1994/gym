@extends('profile')
@section('profileHead')
<h1>{{__('profile.My Account')}}</h1>
@endsection
@section('content')
<div class="col-lg-9">

<div class="card card--lg">
<div class="card__header">
<h4>{{__('profile.Subscription')}}</h4>
</div>
<div class="card__content">
    @if(auth()->guard('user')->user()->subscriptionOb)
       <table class="table  table-hover custom_table_subscriptions">
        <thead>
        <tr>
        <th>{{__('profile.currentPlan')}}</th>
        <th>{{__('profile.planEndTo')}}</th>
        <th>{{__('profile.remainingDays')}}</th>
        </tr>
        </thead>
<tbody>
 <tr>
<td>{{auth()->guard('user')->user()->subscriptionOb->planOb->name ?? ''}}</td>
<td>{{\Carbon\Carbon::parse(auth()->guard('user')->user()->subscriptionOb->end_to)->format('d-M-Y')}}</td>
     @php
       $now = \Carbon\Carbon::now();
       if($now < \Carbon\Carbon::parse( auth()->guard('user')->user()->subscriptionOb->end_to)){
       $parsedDate = \Carbon\Carbon::parse( auth()->guard('user')->user()->subscriptionOb->end_to);
       $diff = $parsedDate->diffInDays($now);
       }
       else{
       $diff = 0;
       }
     @endphp
     @if($diff >0)
<td>{{$diff}} / {{__('profile.DayText')}}</td>
     @else
     <td>{{__('profile.notremainingdays')}}</td>
     @endif
</tr>

</tbody>
</table>
    @else
    <div class="row noSubscriptionSectioninprofile">
       <div class="col-lg-6"><h4>{{__('main.youhavntanysubscriptionbutcansubscribe')}}</h4></div>
       <div class="col-lg-6"><a href="{{route('packages')}}">{{__('main.ORDER NOW')}}</a></div>
    </div>
@endif
    </div>
</div>

</div>
@endsection