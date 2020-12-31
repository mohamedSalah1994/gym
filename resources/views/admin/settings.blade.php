@extends('admin.index')
@section('content')
  <!-- BEGIN: Subheader -->
					<div class="m-subheader ">
						<div class="d-flex align-items-center">
							<div class="mr-auto">
								<h3 class="m-subheader__title m-subheader__title--separator">
										{{__('admin.settings')}}
								</h3>
							
							</div>
						
						</div>
					</div>
					<!-- END: Subheader -->
					<div class="m-content">
					
						<div class="m-portlet m-portlet--mobile">
							<div class="m-portlet__body">
								<form class="m-form m-form--fit m-form--label-align-right" method="post" action="{{route('settings.update')}}">
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
													{{__('admin.site_title')}}
												</label>
												<input type="text" class="form-control m-input" id="site_title" value="{{$site_title}}" name="title">
											
											</div>
                                            	<div class="form-group m-form__group">
												<label for="name">
													{{__('admin.number_of_users_in_slot')}}
												</label>
												<input type="number" class="form-control m-input" id="number_of_users_in_slot" value="{{$numOfUsers}}" name="number_of_users_in_slot">
								
											</div>
                                            	<div class="form-group m-form__group">
												<label for="name">
													{{__('admin.number_of_hours_in_slot')}}
												</label>
												<input type="number" class="form-control m-input" id="number_of_hours_in_slot" value="{{$sessionHours}}" name="number_of_hours_in_slot">
														
											</div>
                                              	<div class="form-group m-form__group">
												<label for="name">
													{{__('admin.work_start_at')}}
												</label>
	                   <input type='text' class="form-control" id="work_start_at" readonly placeholder="Select time" type="text" value="{{$gymStart}}" name="work_start_at">
											</div>
                                          
										<div class="form-group m-form__group">
												<label for="name">
													{{__('admin.number_of_work_hours')}}
												</label>
												<input type="number" class="form-control m-input" id="number_of_work_hours" value="{{$gymEnd}}" name="number_of_work_hours">
											 
											</div>
                                            <div class="form-group m-form__group">
												<label for="name">
													{{__('admin.quickdesc')}}
												</label>
                                                <textarea class="form-control m-input" name="desc">{{$sitedesc}}</textarea>
											 
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