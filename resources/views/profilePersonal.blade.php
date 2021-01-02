@extends('profile')
@section('profileHead')
<h1>{{__('profile.My Account')}}</h1>
@endsection
@section('content')
<div class="col-lg-9">

<div class="card card--lg">
<div class="card__header">
<h4>{{__('profile.Personal Information')}}</h4>
</div>
<div class="card__content">
<form method="POST" class="df-personal-info" action="{{route('profile.update')}}">
    {{csrf_field()}}
    @if($errors->any())
    <div class="alert alert-danger danger-errors">
      @foreach ($errors->all() as $error)
        <p>{{ $error }}</p>
            @endforeach
    </div>
    @endif
    @if(session()->has('message'))
     <div class="alert alert-success danger-errors">
      <p>{{session()->get('message')}}</p>
    </div>
    @endif
                      <div class="form-group">
									<label>{{__('sign.name')}}</label>
									<input type="text" name="name" class="form-control" required="" value="{{Auth::guard('user')->user()->name}}">
								</div>
								{{--<div class="form-group">
									<label>{{__('sign.email')}}</label>
									<input type="email" name="email" class="form-control" required="" value="{{Auth::guard('user')->user()->email}}">
								</div>--}}
                      	<div class="form-group">
									<label>{{__('sign.identity')}}</label>
									<input type="number" name="identity" class="form-control" required="" value="{{Auth::guard('user')->user()->identity}}">
								</div>
     	<div class="form-group">
									<label>{{__('sign.birth')}}</label>
            
									<input type="date" name="birth" class="form-control" required="" value="{{\Carbon\Carbon::parse(Auth::guard('user')->user()->birth)->format('Y-m-d')}}">
								</div>

    <div class="form-group ">
										<label>{{__('sign.mobile')}}</label>
										<input type="mobile" name="mobile" class="form-control" required="" value="{{Auth::guard('user')->user()->mobile}}">
									</div>
     <button type="submit" class="btn btn-primary-inverse" style="margin-top: 25px;">{{__('profile.EditSubmit')}}</button>

    </form>
    </div>
</div>

</div>
@endsection