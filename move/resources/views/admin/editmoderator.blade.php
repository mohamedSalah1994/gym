@extends('admin.index')
@section('content')
  <!-- BEGIN: Subheader -->
					<div class="m-subheader ">
						<div class="d-flex align-items-center">
							<div class="mr-auto">
								<h3 class="m-subheader__title m-subheader__title--separator">
										{{__('admin.moderator')}} - {{$moderator->name}}
								</h3>
							
							</div>
						
						</div>
					</div>
					<!-- END: Subheader -->
					<div class="m-content">
					
						<div class="m-portlet m-portlet--mobile">
							<div class="m-portlet__body">
								<form class="m-form m-form--fit m-form--label-align-right" method="post" action="{{route('moderator.update',$moderator->id)}}">
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
												<input type="text" class="form-control m-input" id="name" name="name" value="{{$moderator->name}}">
											
											</div>
											<div class="form-group m-form__group">
												<label for="email">
													{{__('admin.user email')}}
												</label>
												<input type="email" class="form-control m-input" id="email" name="email" value="{{$moderator->email}}">
											</div>
											<div class="form-group m-form__group">
												<label for="identity">
													{{__('admin.user identity')}}
												</label>
												<input type="text" class="form-control m-input" id="identity" name="identity" value="{{$moderator->identity}}">
											</div>
                                            	<div class="form-group m-form__group">
												<label for="mobile">
													{{__('admin.user mobile')}}
												</label>
												<input type="text" class="form-control m-input" id="mobile" name="mobile" value="{{$moderator->mobile}}">
											</div>
                                             <div class="form-group m-form__group">
												<label for="password">
													{{__('admin.addroles')}}
												</label>
												    <select class="form-control  role_picker" name="role">
												@foreach($roles as $role)
                                                        <option @if($moderator->role->role == $role->id) selected @endif value="{{$role->id}}">
													{{$role->name}}
												</option>
											   @endforeach
											</select>
											</div>
											<div class="form-group m-form__group">
												<label for="password">
													{{__('admin.user update password')}}
												</label>
												<input type="password" class="form-control m-input" id="password" name="password">
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
@section('footer')
<script>
$('.role_picker').selectpicker();
</script>
@endsection