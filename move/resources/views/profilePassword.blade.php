@extends('profile')
@section('profileHead')
<h1>{{__('profile.My Account')}}</h1>
@endsection
@section('content')
<div class="col-lg-9">

<div class="card card--lg">
<div class="card__header">
<h4>{{__('profile.passwordChange')}}</h4>
</div>
<div class="card__content">
<form method="POST" class="df-personal-info" action="{{route('profile.update.password')}}">
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
									<label>{{__('sign.currentPassword')}}</label>
									<input type="password" name="current" class="form-control" required="">
								</div>
     	<div class="form-group">
									<label>{{__('sign.newPassword')}}</label>
									<input type="password" name="new" class="form-control" required="">
								</div>
     	<div class="form-group">
									<label>{{__('sign.newPasswordConfirm')}}</label>
									<input type="password" name="confirm" class="form-control" required="">
								</div>



     <button type="submit" class="btn btn-primary-inverse" style="margin-top: 25px;">{{__('profile.EditSubmit')}}</button>

    </form>
    </div>
</div>

</div>
@endsection