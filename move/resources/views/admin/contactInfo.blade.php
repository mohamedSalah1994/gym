@extends('admin.index')
@section('content')
  <!-- BEGIN: Subheader -->
					<div class="m-subheader ">
						<div class="d-flex align-items-center">
							<div class="mr-auto">
								<h3 class="m-subheader__title m-subheader__title--separator">
										{{__('admin.contact info')}}
								</h3>
							
							</div>
						
						</div>
					</div>
					<!-- END: Subheader -->
					<div class="m-content">
					
						<div class="m-portlet m-portlet--mobile">
							<div class="m-portlet__body">
								<form class="m-form m-form--fit m-form--label-align-right" method="post" action="{{route('contact.update')}}">
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
                                            
                                                       @php
                    $email = \App\contact::where('key','email')->firstOrFail()->value;
                    $mobile = \App\contact::where('key','mobile')->firstOrFail()->value;
                    $address = \App\contact::where('key','address')->firstOrFail()->value;
                    @endphp
											<div class="form-group m-form__group">
												<label for="name">
													{{__('admin.email')}}
												</label>
												<input type="text" class="form-control m-input" id="email" name="email" value="{{$email ?? ''}}">
											
											</div>
											<div class="form-group m-form__group">
												<label for="email">
													{{__('admin.address')}}
												</label>
												<input type="text" class="form-control m-input" id="address" name="address" value="{{$address ?? ''}}">
											</div>
											<div class="form-group m-form__group">
												<label for="identity">
													{{__('admin.mobile')}}
												</label>
												<input type="text" class="form-control m-input" id="mobile" name="mobile" value="{{$mobile ?? ''}}">
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