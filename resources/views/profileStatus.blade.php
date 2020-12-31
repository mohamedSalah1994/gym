@extends('profile')
@section('profileHead')
<h1>{{__('profile.My Account')}}</h1>
@endsection
@section('content')
<div class="col-lg-9">

<div class="card card--lg">
<div class="card__header">
<h4>{{__('profile.profileStatus')}}</h4>
</div>
<div class="card__content">
      @if(session()->has('message'))
     <div class="alert alert-success danger-errors">
      <p>{{session()->get('message')}}</p>
    </div>
    @endif
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
<td>{{(auth()->guard('user')->user()->FreezedObj) ? auth()->guard('user')->user()->FreezedObj->remaining :  $diff}} / {{__('profile.DayText')}}</td>
</tr>

</tbody>
</table>
<div class="row acountstatus">
    <div class="col-lg-2"><h4>{{__('profile.subscriptionStatus')}}</h4></div>
    @if($now < \Carbon\Carbon::parse( auth()->guard('user')->user()->subscriptionOb->end_to))
    <div class="col-lg-2"><h4>{{__((auth()->guard('user')->user()->FreezedObj) ? 'profile.inactive' : 'profile.active')}}</h4></div>
    @else
    <div class="col-lg-2"><h4>{{__('profile.inactive')}}</h4></div>
    @endif
   {{--
    <div class="col-lg-12"><a type="button" href="{{route('profile.freeze.updateStatus')}}" class="btn btn-{{(auth()->guard('user')->user()->FreezedObj) ? 'success' : 'danger'}} freezebtn">{{__((auth()->guard('user')->user()->FreezedObj) ? 'profile.unfreezetxt' : 'profile.freezetxt')}}</a></div>
   --}}
    </div>
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