@extends('admin.index')
@section('content')
  <!-- BEGIN: Subheader -->
					<div class="m-subheader ">
						<div class="d-flex align-items-center">
							<div class="mr-auto">
								<h3 class="m-subheader__title m-subheader__title--separator">
										{{__('admin.addslider')}}
								</h3>
							
							</div>
						
						</div>
					</div>
					<!-- END: Subheader -->
					<div class="m-content">
					
						<div class="m-portlet m-portlet--mobile">
							<div class="m-portlet__body">
								<form class="m-form m-form--fit m-form--label-align-right" method="post" action="{{route('slider.insert')}}" enctype="multipart/form-data">
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
													{{__('admin.slider title')}}
												</label>
												<input type="text" class="form-control m-input" id="title" name="title">
											
											</div>
											<div class="form-group m-form__group">
												<label for="email">
													{{__('admin.slider subtitle')}}
												</label>
												<input type="text" class="form-control m-input" id="subtitle" name="subtitle">
											</div>
                                            <div class="form-group m-form__group">
												<div class="image_upload_aree_slider">
                                                    <input type="file" class="form-control m-input" id="image" name="image" hidden="hidden">
                                                <div class="addimagebutton">
                                                    <i class="fa fa-plus"></i>
                                                    <p>{{__('admin.addImage')}}</p>
                                                    </div>
                                                
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
@section('footer')
<script>
$(".addimagebutton").click(function(){
    $("#image").click();
});
    $("#image").change(function(){
            var imageFile = document.getElementById('image');
            var reader = new FileReader();
            reader.onload = function(e) {
              $(".image_upload_aree_slider").css('background-image','url('+e.target.result+')');
            }

            reader.readAsDataURL(imageFile.files[0]); // convert to base64 string
    });
</script>
@endsection