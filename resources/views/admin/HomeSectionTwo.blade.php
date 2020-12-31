@extends('admin.index')
@section('content')
  <!-- BEGIN: Subheader -->
					<div class="m-subheader ">
						<div class="d-flex align-items-center">
							<div class="mr-auto">
								<h3 class="m-subheader__title m-subheader__title--separator">
										{{__('admin.secondsection')}}
								</h3>
							
							</div>
						
						</div>
					</div>
					<!-- END: Subheader -->
					<div class="m-content">
					
						<div class="m-portlet m-portlet--mobile">
							<div class="m-portlet__body">
								<form class="m-form m-form--fit m-form--label-align-right" method="post" action="{{route('home.section.two.insert')}}" enctype="multipart/form-data">
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
                                              $home_second = \App\home_second::find(1);
                                            @endphp
											<div class="form-group m-form__group">
												<label for="name">
													{{__('admin.sectwotitle')}}
												</label>
												<input type="text" class="form-control m-input"  name="title" value="{{$home_second->title ?? ''}}">
											
											</div>
											<div class="form-group m-form__group">
												<label for="email">
													{{__('admin.sectwosubtitle')}}
												</label>
												<input type="text" class="form-control m-input"  name="subtitle" value="{{$home_second->subtitle ?? ''}}">
											</div>
                                            <div class="form-group m-form__group">
												<label for="email">
                              
													{{__('admin.firstphoto')}}
												</label>
                                                <div class="imageUploadsecond" id="first"  @if($home_second) style="background-image:url({{asset('uploads/home_second_section/'.($home_second) ? $home_second->firstImage : '')}})" @endif>
                                                <div class="addimagebtn">
                                                    <i class="fa fa-plus"></i>
                                                    @if($home_second && $home_second->firstImage)
                                                    <p class="colorWhite">{{__('admin.editImage')}}</p>
                                                    @else
                                                     <p>{{__('admin.addImage')}}</p>
                                                    @endif
                                                    </div>
                                                </div>
												 <input type="file" class="form-control m-input"  name="first" hidden="hidden" id="firstImage">
											</div>
                                                <div class="form-group m-form__group">
												<label for="email">
													{{__('admin.secondphoto')}}
												</label>
                                                      <div class="imageUploadsecond" id="second" @if($home_second) style="background-image:url({{asset('uploads/home_second_section/'.($home_second) ? $home_second->secondImage : '')}})" @endif>
                                                <div class="addimagebtn">
                                                    <i class="fa fa-plus"></i>
                                                      @if($home_second && $home_second->secondImage)
                                                    <p class="colorWhite">{{__('admin.editImage')}}</p>
                                                    @else
                                                     <p>{{__('admin.addImage')}}</p>
                                                    @endif
                                                   
                                                    </div>
                                                </div>
												 <input type="file" class="form-control m-input"  name="second" hidden="hidden" id="secondImage">
											</div>
                                                <div class="form-group m-form__group">
												<label for="email">
													{{__('admin.thirdphoto')}}
												</label>
                                                      <div class="imageUploadsecond" id="third"  @if($home_second) style="background-image:url({{asset('uploads/home_second_section/'.($home_second) ? $home_second->thiedImage : '')}})"  @endif>
                                                <div class="addimagebtn">
                                                    <i class="fa fa-plus"></i>
                                                      @if($home_second &&$home_second->thiedImage)
                                                    <p class="colorWhite">{{__('admin.editImage')}}</p>
                                                    @else
                                                     <p>{{__('admin.addImage')}}</p>
                                                    @endif
                                                   
                                                    </div>
                                                </div>
												 <input type="file" class="form-control m-input"  name="third" hidden="hidden" id="thirdImage">
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
  $('#first').click(function(){
      $("#firstImage").click();
  });
       $('#second').click(function(){
      $("#secondImage").click();
  });
       $('#third').click(function(){
      $("#thirdImage").click();
  });
     $("#firstImage").change(function(){
         var reader = new FileReader();
    
    reader.onload = function(e) {
      $('#first').css("background-image", "url(" + e.target.result + ")");
    }
    
    reader.readAsDataURL($(this).get(0).files[0]);
     });
        $("#secondImage").change(function(){
         var reader = new FileReader();
    
    reader.onload = function(e) {
      $('#second').css("background-image", "url(" + e.target.result + ")");
    }
    
    reader.readAsDataURL($(this).get(0).files[0]);
     });
        $("#thirdImage").change(function(){
         var reader = new FileReader();
    
    reader.onload = function(e) {
      $('#third').css("background-image", "url(" + e.target.result + ")");
    }
    
    reader.readAsDataURL($(this).get(0).files[0]);
     });
</script>
@endsection