@extends('admin.index')
@section('content')
  <!-- BEGIN: Subheader -->
					<div class="m-subheader ">
						<div class="d-flex align-items-center">
							<div class="mr-auto">
								<h3 class="m-subheader__title m-subheader__title--separator">
										{{__('admin.edittrainer')}} - {{$trainer->name}}
								</h3>
							
							</div>
						
						</div>
					</div>
					<!-- END: Subheader -->
					<div class="m-content">
					
						<div class="m-portlet m-portlet--mobile">
							<div class="m-portlet__body">
								<form class="m-form m-form--fit m-form--label-align-right" method="post" action="{{route('trainer.update',$trainer->id)}}" enctype="multipart/form-data">
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
													{{__('admin.trainer name')}}
												</label>
												<input type="text" class="form-control m-input" id="name" name="name" value="{{$trainer->name}}">
											
											</div>
											<div class="form-group m-form__group">
												<label for="email">
													{{__('admin.trainer job')}}
												</label>
												<input type="text" class="form-control m-input" id="job" name="job" value="{{$trainer->jobTitle}}">
											</div>
											<div class="form-group m-form__group">
												<label for="identity">
													{{__('admin.trainer desc')}}
												</label>
												<input type="text" class="form-control m-input" id="desc" name="desc" value="{{$trainer->desc}}">
											</div>
                                            <div class="form-group m-form__group">
												<label for="identity">
													{{__('admin.trainer image')}}
												</label>
												<input type="file" class="form-control m-input" id="image" name="image">
											</div>
                                              <div class="form-group m-form__group">
												<label for="identity">
													{{__('admin.trainer facebook')}}
												</label>
												<input type="text" class="form-control m-input" id="facebook" name="facebook" value="{{$trainer->facebook}}">
											</div>
                                              <div class="form-group m-form__group">
												<label for="identity">
													{{__('admin.trainer twitter')}}
												</label>
												<input type="text" class="form-control m-input" id="twitter" name="twitter" value="{{$trainer->twitter}}">
											</div>
                                              <div class="form-group m-form__group">
												<label for="identity">
													{{__('admin.trainer insta')}}
												</label>
												<input type="text" class="form-control m-input" id="insta" name="insta" value="{{$trainer->insta}}">
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