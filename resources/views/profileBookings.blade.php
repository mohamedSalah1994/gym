@extends('profile')
@section('profileHead')
<h1>{{__('profile.Personal booking')}}</h1>
@endsection
@section('content')
<div class="col-lg-9">

<div class="card card--lg">
<div class="card__header">
<h4>{{__('profile.Personal booking')}}</h4>
</div>
<div class="card__content">
    @if(count(auth()->guard('user')->user()->bookingsObjs) > 0)
       <table class="table  table-hover custom_table_subscriptions">
        <thead>
        <tr>
        <th>{{__('profile.bookingstartIn')}}</th>
        <th>{{__('profile.bookingDay')}}</th>
        <th>{{__('profile.durationFrom')}}</th>
        <th>{{__('profile.durationTo')}}</th>
        <th>{{__('profile.bookStatus')}}</th>
        </tr>
        </thead>
<tbody>
  @foreach(auth()->guard('user')->user()->bookingsObjs as $book)
    <tr>
  <td>{{\Carbon\Carbon::parse($book->created_at)->format('d-M-Y')}}</td>
  <td>{{\Carbon\Carbon::parse($book->day)->format('d-M-Y')}}</td>
  <td>{{\Carbon\Carbon::parse($book->from)->format('h:i a')}}</td>
  <td>{{\Carbon\Carbon::parse($book->to)->format('h:i a')}}</td>
  <td>
        @if(\Carbon\Carbon::parse($book->day) > \Carbon\Carbon::now())
          @if($book->status == 0)
           <a type="button" class="primary-btn cancelBook" action="{{route('profile.cancelBook')}}" style="font-size: small;color:white;cursor:pointer" data="{{$book->id}}">{{__('profile.cancelBooking')}}</a>
          @else
            {{__('profile.bookcancelled')}}
          @endif
        @else
          @if($book->status == 1)
                    {{__('profile.bookConfirmed')}}
          @elseif($book->status == 2)
                {{__('profile.bookcancelled')}}
          @else
                    {{__('profile.bookNotConfirmed')}}
          @endif
        @endif
        </td>
</tr>
 @endforeach
</tbody>
</table>
    @else
     <div class="row noSubscriptionSectioninprofile">
       <div class="col-lg-6"><h4>{{__('profile.uhavntanybookings')}}</h4></div>
    </div>
    @endif

    </div>
</div>

</div>
@endsection