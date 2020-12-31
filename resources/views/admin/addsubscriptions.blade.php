@extends('admin.index')
@section('content')
  <!-- BEGIN: Subheader -->
					<div class="m-subheader ">
						<div class="d-flex align-items-center">
							<div class="mr-auto">
								<h3 class="m-subheader__title m-subheader__title--separator">
										{{__('admin.addSubscription')}}
								</h3>
							
							</div>
						
						</div>
					</div>
					<!-- END: Subheader -->
					<div class="m-content">
					
						<div class="m-portlet m-portlet--mobile">
							<div class="m-portlet__body">
								<form class="m-form m-form--fit m-form--label-align-right" method="post" action="{{route('subscriptions.insert')}}">
										<div class="m-portlet__body">
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
											<div class="form-group m-form__group">
												<label for="name">
													{{__('admin.user name')}}
												</label>
													<select action="{{route('SearchUser')}}" class="form-control m-select2" id="add_user_subscription" name="user">
												<option></option>
											</select>
											
											</div>
											<div class="form-group m-form__group">
												<label for="email">
													{{__('admin.plan')}}
												</label>
												<select  class="form-control"  name="plan">
												<option selected disabled>{{__('admin.choosePlan')}}</option>
                                                    @foreach($allplans as $plan)
                                                    <option value="{{$plan->id}}">{{$plan->name}} - {{$plan->price}} / {{__('main.coin')}}</option>
                                                    @endforeach
											</select>
											</div>
										<div class="m-form__group form-group">
																<label for="">
																	{{__('admin.paymentWay')}}
																</label>
																<div class="m-radio-inline">
																	<label class="m-radio">
																		<input type="radio" name="payment" value="1">
																		Cash
																		<span></span>
																	</label>
																	<label class="m-radio">
																		<input type="radio" name="payment" value="2">
																		Ke.net
																		<span></span>
																	</label>
																
																</div>
															
															</div>
										</div>
										<div class="m-portlet__foot m-portlet__foot--fit">
											<div class="m-form__actions">
												<button type="submit" class="btn btn-primary">
													{{__('admin.save')}}
												</button>
												<button type="reset" class="btn btn-secondary">
													{{__('admin.cancel')}}
												</button>
											</div>
										</div>
									</form>
							</div>
						</div>
					</div>
@endsection